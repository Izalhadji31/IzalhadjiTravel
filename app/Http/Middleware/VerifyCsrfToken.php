<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyCsrfToken
{
    protected $except = [
        'api/*',
    ];

    public function handle(Request $request, Closure $next)
    {
        if ($this->isReading($request) ||
            $this->tokensMatch($request)) {
            return $next($request);
        }

        return abort(419, 'CSRF token mismatch');
    }

    private function isReading(Request $request): bool
    {
        return in_array($request->method(), ['HEAD', 'GET', 'OPTIONS']);
    }

    private function tokensMatch(Request $request): bool
    {
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');
        return hash_equals(session('_token'), $token ?? '');
    }
}
