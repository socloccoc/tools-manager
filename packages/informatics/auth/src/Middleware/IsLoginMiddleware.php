<?php


namespace Informatics\Auth\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Sentinel;

class IsLoginMiddleware
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
        // check if user is login than it will send user to dashboard
        if (Sentinel::check()) {
            return Redirect::to('/user');
        } else {
            return $next($request);
        }
    }
}