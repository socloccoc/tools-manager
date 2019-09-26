<?php


namespace Informatics\Auth\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Sentinel;

class AuthMiddleware
{

    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (Sentinel::check()) {
            return $next($request);
        } else {
            return Redirect::route('login')
                ->withErrors('Vui lòng đăng nhập');
        }
    }
}