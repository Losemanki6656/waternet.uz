<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\LanguageManager::class,
            \App\Http\Middleware\OrganizationActivate::class,
        ]);

        $middleware->api(append: [
            \App\Http\Middleware\OrganizationActivate::class,
        ]);

        $middleware->alias([
            'role'               => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'         => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Spatie Permission: UnauthorizedException → 403
        $exceptions->render(function (
            \Spatie\Permission\Exceptions\UnauthorizedException $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'error'   => 'Forbidden',
                    'message' => __('messages.forbidden') ?? 'Ruxsat yo\'q',
                ], 403);
            }

            return response()->view('errors.403', [
                'message' => $e->getMessage(),
            ], 403);
        });

    })->create();
