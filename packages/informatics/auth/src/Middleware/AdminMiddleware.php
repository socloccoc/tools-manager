<?php

namespace Informatics\Auth\Middleware;

use Closure;
use Permission;

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
        if (Permission::isSuperAdmin()) {
            return $next($request);
        } else {
            abort(405);
        }
    }
}