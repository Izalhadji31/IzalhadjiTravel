<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
     * Store a newly created user in storage.
     * Accepts international phone numbers with country code (e.g. +1 202-555-0100, +62 812 xxx).
     */
    public function store(Request $request): RedirectResponse
    {
        $locale = app()->getLocale();

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone'    => [
                'required',
                'string',
                'max:25',
                // International format: must start with + followed by country code and number (6–14 digits)
                // OR Indonesian local format: 08xxxxxxxx
                'regex:/^(\+\d{1,4}[\s\-]?\d{4,14}|08\d{8,13})$/',
            ],
        ], [
            'phone.regex' => $locale === 'id'
                ? 'Nomor telepon harus menggunakan format internasional (+62 xxx, +1 xxx, dll.) atau format lokal (08xxx).'
                : 'Phone number must use international format (+62 xxx, +1 xxx, etc.) or local format (08xxx).',
        ]);

        // Normalize phone: strip spaces and dashes for storage
        $phone = preg_replace('/[\s\-]/', '', $request->phone);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $phone,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
            'status'   => 'pending',
        ]);

        event(new Registered($user));

        $successMsg = $locale === 'id'
            ? 'Registrasi berhasil! Akun Anda sedang ditinjau oleh admin. Anda akan mendapatkan notifikasi melalui email setelah disetujui.'
            : 'Registration successful! Your account is being reviewed by an admin. You will receive an email notification once approved.';

        return redirect()->route('auth.pending')->with('success', $successMsg);
    }
}
