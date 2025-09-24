<?php

namespace ErfanMasboogh\Laran\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfManagerAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('manager')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return $next($request);
    }
}
