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
        $validRoles = ['admin', 'user', 'driver', 'partner'];
        
        if ($role && in_array($role, $validRoles)) {
            $view = match($role) {
                'admin' => 'auth.login',
                'user' => 'auth.login',
                'driver' => 'auth.login',
                'partner' => 'auth.login',
                default => 'auth.login',
            };
            return view($view);
        }

        return view('auth.login');
    }

    /**
     * Handle an authentication attempt
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Validate role if provided in request
            if ($request->has('role') && $request->input('role') !== $user->role) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Email atau password salah untuk peran ini.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Selamat datang!');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai dengan catatan kami.',
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

        return redirect('/')->with('success', 'You have been logged out');
    }
}
