<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class OrganizationActivate
{
    public function handle(Request $request, Closure $next)
    {

        if (Auth::check()) {
            $user = auth()->user();
            if ($user->id != 1) {
                if ($user->organization->date_traffic > now()) {
                    return $next($request);
                } else {
                    Auth::logout();
                    abort(403, 'Wrong Accept Header');
                }
            }
        }

        return $next($request);

    }
}
