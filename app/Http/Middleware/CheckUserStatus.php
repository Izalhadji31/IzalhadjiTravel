<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->status === 'pending') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('auth.pending')
                                 ->with('info', 'Akun Anda sedang ditinjau oleh admin. Silakan tunggu persetujuan.');
            }

            if ($user->status === 'rejected') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('auth.pending')
                                 ->with('error', 'Akun Anda telah ditolak. Silakan hubungi admin untuk informasi lebih lanjut.');
            }

            // If status is null (legacy users), default to approved behavior
            if (is_null($user->status)) {
                $user->update(['status' => 'approved']);
            }
        }

        return $next($request);
    }
}
