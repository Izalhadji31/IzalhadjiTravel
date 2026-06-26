<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                             ->with('error', 'Google authentication failed. Please try again.');
        }

        // Find existing user by google_id or email
        $user = User::where('google_id', $googleUser->getId())
                    ->orWhere('email', $googleUser->getEmail())
                    ->first();

        if (!$user) {
            // Create new user with customer role
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Hash::make(Str::random(24)),
                'role' => 'customer',
                'is_verified' => true,
                'profile_photo_path' => $googleUser->getAvatar(),
            ]);
        } else {
            // Update google_id if not set
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'profile_photo_path' => $user->profile_photo_path ?? $googleUser->getAvatar(),
                ]);
            }
        }

        Auth::login($user, true);

        return redirect()->route('dashboard')
                         ->with('success', 'Selamat datang! Login berhasil dengan Google.');
    }
}
