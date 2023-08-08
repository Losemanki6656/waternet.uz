<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class OrganizationActivate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::check()) {
            $user = auth()->user();
            if ($user->organization->date_traffic > now()) {
                return $next($request);
            } else {
                Auth::logout();
                abort(403, 'Wrong Accept Header');
            }
        }

        return $next($request);

    }
}