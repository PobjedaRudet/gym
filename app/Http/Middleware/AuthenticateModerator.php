<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateModerator
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('moderator')->check()) {
            return redirect()->route('moderator.login');
        }

        return $next($request);
    }
}
