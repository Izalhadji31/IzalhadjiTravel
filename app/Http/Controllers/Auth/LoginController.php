<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Show user login form (simplified main login)
     */
    public function index(): View
    {
        return view('auth.login');
    }

    /**
     * Show role-specific login form or default to user login
     */
    public function create($role = null): View
    {
        $validRoles = ['admin', 'customer', 'driver', 'partner'];
        
        if ($role && in_array($role, $validRoles)) {
            return view('auth.login');
        }

        return view('auth.login');
    }

    /**
     * Handle an authentication attempt
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Validate role if provided in request
            if ($request->has('role') && $request->input('role') !== $user->role) {
                Auth::logout();
                return back()->withErrors([
                    'email' => __('auth.role_mismatch'),
                ])->onlyInput('email');
            }

            // Block pending accounts – require admin approval
            if ($user->status === 'pending') {
                Auth::logout();
                return redirect()->route('auth.pending')
                                 ->with('info', app()->getLocale() === 'id'
                                     ? 'Akun Anda sedang menunggu persetujuan admin. Harap tunggu konfirmasi melalui email.'
                                     : 'Your account is awaiting admin approval. Please wait for an email confirmation.');
            }

            // Block rejected accounts
            if ($user->status === 'rejected') {
                Auth::logout();
                return redirect()->route('auth.pending')
                                 ->with('error', app()->getLocale() === 'id'
                                     ? 'Akun Anda telah ditolak. Silakan hubungi admin untuk informasi lebih lanjut.'
                                     : 'Your account has been rejected. Please contact the admin for more information.');
            }

            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success',
                app()->getLocale() === 'id' ? 'Selamat datang!' : 'Welcome back!');
        }

        return back()->withErrors([
            'email' => app()->getLocale() === 'id'
                ? 'Email atau kata sandi tidak sesuai dengan catatan kami.'
                : 'These credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success',
            app()->getLocale() === 'id' ? 'Anda berhasil keluar.' : 'You have been logged out.');
    }
}
