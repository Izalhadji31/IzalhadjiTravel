<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Show register form
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Store a newly created user in storage
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['nullable', 'in:customer,driver,partner'],        ]);

        $role = $request->input('role', 'customer');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        // Auto-create driver profile if registering as driver
        if ($role === 'driver') {
            \App\Models\Driver::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'sim_number' => 'PENDING-' . strtoupper(Str::random(8)),
                'sim_expiry' => now()->addYears(5),
                'address' => '',
                'status' => 'offline',
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang di ASR GO');
    }
}
