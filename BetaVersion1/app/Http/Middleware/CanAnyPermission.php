<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanAnyPermission
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        // College and college staff guards bypass Spatie permission checks
        if (auth()->guard('college')->check() || auth()->guard('college_staff')->check()) {
            return $next($request);
        }

        if (!auth()->check() || !auth()->user()->canAny($permissions)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
