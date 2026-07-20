<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! Auth::check()) {
            if ($this->wantsJson($request)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please login first.',
                    'code' => 'UNAUTHENTICATED',
                ], 401);
            }

            return redirect()->route('login');
        }

        if (! in_array(Auth::user()->role, $roles)) {
            if ($this->wantsJson($request)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden. Your role does not have access to this resource.',
                    'code' => 'FORBIDDEN',
                    'user_role' => Auth::user()->role,
                    'required_roles' => $roles,
                ], 403);
            }

            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }

    private function wantsJson(Request $request): bool
    {
        return $request->expectsJson() || $request->is('api/*');
    }
}
