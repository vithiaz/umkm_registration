<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->active_status != 'active') {
            return redirect()->route('profile');
        }
        
        return $next($request);
    }
}
