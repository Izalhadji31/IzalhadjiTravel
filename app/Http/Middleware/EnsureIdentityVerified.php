<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIdentityVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please login first.',
                'code' => 'UNAUTHENTICATED'
            ], 401);
        }
        
        // Check if identity is verified
        if (!auth()->user()->is_identity_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Identity verification required before accessing this resource.',
                'code' => 'IDENTITY_NOT_VERIFIED',
                'requires_verification' => true,
                'verification_endpoint' => '/api/identity-verification'
            ], 403);
        }

        return $next($request);
    }
}
