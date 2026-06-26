<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect('/login');
        }

        // Redirect unverified users to verification notice (except for verification routes)
        $user = Auth::user();
        if ($user && method_exists($user, 'hasVerifiedEmail') && !$user->hasVerifiedEmail()) {
            $verificationRoutes = ['verification.notice', 'verification.verify', 'verification.send', 'logout'];
            $currentRoute = $request->route()?->getName();

            if (!in_array($currentRoute, $verificationRoutes)) {
                return redirect()->route('verification.notice');
            }
        }

        return $next($request);
    }
}
