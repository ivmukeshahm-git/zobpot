<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
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
        // 👉 List of route names to skip
        $excludedRoutes = [
            'admin.login',       
        ];

        if (in_array($request->route()->getName(), $excludedRoutes)) {
            return $next($request); // ✅ Skip middleware for these routes
        }


        if (!Auth::check() && !Auth::guard('college')->check() && !Auth::guard('college_staff')->check()) {
            return redirect()->route('admin.login')->with('error', 'You must be logged in to access this page.');
        }

        return $next($request);
    }
}
