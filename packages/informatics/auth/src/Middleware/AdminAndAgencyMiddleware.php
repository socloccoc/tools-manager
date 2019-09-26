<?php

namespace Informatics\Auth\Middleware;

use Closure;
use Permission;

class AdminAndAgencyMiddleware
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
        if (Permission::isSuperAdmin() || Permission::isAgency()) {
            return $next($request);
        } else {
            abort(405);
        }
    }
}