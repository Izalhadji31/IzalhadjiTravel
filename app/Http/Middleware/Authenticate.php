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

        // Redirect unverified users to verification notice, except for booking/payment flows
        $user = Auth::user();
        if ($user && method_exists($user, 'hasVerifiedEmail') && !$user->hasVerifiedEmail()) {
            $verificationRoutes = ['verification.notice', 'verification.verify', 'verification.send', 'logout'];
            $currentRoute = $request->route()?->getName();
            $currentPath = $request->path();
            $allowsBookingFlow = str_starts_with($currentPath, 'bookings')
                || str_starts_with($currentPath, 'payments');

            if (!in_array($currentRoute, $verificationRoutes) && !$allowsBookingFlow) {
                return redirect()->route('verification.notice');
            }
        }

        return $next($request);
    }
}
