<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserRoleIsUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role !== 'User') {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Access denied. You are not allowed to login as a user.'
                ]);
            }
            return $next($request);
        } else {
            return $next($request);
        }

        // return redirect()->route('login');
    }
}
