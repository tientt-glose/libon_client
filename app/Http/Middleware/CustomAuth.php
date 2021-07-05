<?php

namespace App\Http\Middleware;

use Closure;

class CustomAuth
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
        if (!empty(session('authenticated'))) {
            return $next($request);
        }

        return redirect()->route('user.login.show')->withErrors('Hãy đăng nhập để sử dụng chức năng');
    }
}
