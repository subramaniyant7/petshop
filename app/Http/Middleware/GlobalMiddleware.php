<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GlobalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (FRONTENDURL != SITEURL) {
            abort(404, 'Unauthorized Access');
        }
        return $next($request);
    }
}
