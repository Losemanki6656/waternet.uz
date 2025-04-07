<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationActivate
{
    public function handle(Request $request, Closure $next)
    {

        if (Auth::check()) {
            $user = auth()->user();
            if ($user->id !== 1) {

                if (!$user->status) {
                    abort(401, 'Unauthorized');
                }

                if ($user->organization && $user->organization->date_traffic > now()) {
                    return $next($request);
                }

                Auth::logout();
                abort(403, 'Wrong Accept Header');
            }
        }

        return $next($request);

    }
}
