<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuthenticate
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
        if (!auth()->guard('admin')->check() || (auth()->guard('admin')->check() && auth()->guard('admin')->user()->role == config('constant.role.client'))  ) {
            auth()->guard('admin')->logout();
            return redirect()->route('getLogin');

        }
        return $next($request);
    }
}
