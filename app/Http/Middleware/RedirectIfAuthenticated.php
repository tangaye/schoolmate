<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        /**
         * If a user is logged in and he/she tries to access the login page
         * for the account of which they are logged in already
         * that user should be redirected to the current user dashboard
         * 
         */

        switch ($guard) {
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('admin.dashboard');
                }
                break;
            case 'guardian':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('guardian.dashboard');
                }
                break;
            default:
                // code...
                if (Auth::guard($guard)->check()) {
                    return redirect('/home');
                }
                break;
        }

        return $next($request);
    }
}