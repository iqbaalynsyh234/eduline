<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_active) {
            Auth::logout(); 
            return redirect()->route('login')->withErrors(['Your account is deactivated. Please contact the administrator.']);
        }
        return $next($request);
    }
}
