<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrimStrings
{
    protected $except = [
        'password',
        'password_confirmation',
    ];

    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
