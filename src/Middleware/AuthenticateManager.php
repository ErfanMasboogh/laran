<?php

namespace ErfanMasboogh\Laran\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateManager
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('manager')->check()) {
            return redirect()->route('admin.login');
        }
        return $next($request);
    }
}
