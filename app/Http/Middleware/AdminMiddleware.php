<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if user is not guardian but secretary, registrar allow access
        if ($request->user()->hasType("\App\Guardian") ) {
            abort(403, "You are not authorized to access this page");
        }
        return $next($request);
    }
}
