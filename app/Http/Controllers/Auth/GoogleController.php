<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirect(): RedirectResponse
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret) || str_starts_with($clientId, 'your-') || str_starts_with($clientSecret, 'your-')) {
            Log::error('Google OAuth credentials are missing or placeholder values are still configured.', [
                'client_id' => $clientId ? 'present' : 'missing',
                'client_secret' => $clientSecret ? 'present' : 'missing',
            ]);

            return redirect()->route('login')->with('error', 'Google login not configured. Please set GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET in .env.');
        }

        // Use stateless to avoid issues with session/cookies on certain hosts
        Log::info('Google OAuth redirect', [
            'app_url' => config('app.url'),
            'base_url' => url('/'),
            'services_google_redirect' => config('services.google.redirect'),
            'current_url' => url()->current(),
        ]);

        return Socialite::driver('google')
            ->stateless()
            ->redirectUrl(config('services.google.redirect'))
            ->redirect();
    }

    /**
     * Handle Google callback
     */
    public function callback(): RedirectResponse
    {
        // Log enough context to distinguish redirect URI mismatch, malformed requests, and token issues.
        Log::info('Google OAuth callback hit', [
            'app_url' => config('app.url'),
            'base_url' => url('/'),
            'services_google_redirect' => config('services.google.redirect'),
            'current_url' => url()->current(),
            'full_url' => request()->fullUrl(),
            'method' => request()->method(),
            'host' => request()->getHost(),
            'query' => request()->query(),
        ]);

        try {
            // Use stateless and explicit redirect URL for reliable callback behavior.
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->redirectUrl(config('services.google.redirect'))
                ->setHttpClient($this->createGoogleHttpClient())
                ->user();
        } catch (\Throwable $e) {
            Log::error('Google OAuth callback failed', [
                'message' => $e->getMessage(),
                'class' => get_class($e),
                'curl_cainfo' => ini_get('curl.cainfo'),
                'openssl_cafile' => ini_get('openssl.cafile'),
                'google_verify_setting' => config('services.google.verify'),
            ]);

            return redirect()->route('login')
                ->with('error', 'Autentikasi Google gagal. Silakan coba lagi atau pastikan redirect URL sudah benar.');
        }

        // Find existing user by google_id or email
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if (!$user) {
            try {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(24)),
                    // Keep only the fields you expect to exist in your users table.
                    // If your table doesn't have these columns, creation will throw and we will show a clear error.
                    'role' => 'customer',
                    'is_verified' => true,
                    'status' => 'approved',
                    'email_verified_at' => now(),
                    'profile_photo_path' => $googleUser->getAvatar(),
                ]);
            } catch (\Throwable $e) {
                Log::error('Failed to create user from Google callback', [
                    'message' => $e->getMessage(),
                    'class' => get_class($e),
                    'google_email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                ]);

                return redirect()->route('login')
                    ->with('error', 'Masuk dengan Google berhasil, tetapi akun gagal disimpan. Silakan hubungi admin atau developer.');
            }

            Auth::login($user, true);

            return redirect()->route('dashboard')
                ->with('success', 'Selamat datang! Akun Google Anda telah dibuat dan Anda berhasil masuk.');
        } else {
            // Update google_id if not set
            if (empty($user->google_id)) {
                try {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'profile_photo_path' => $user->profile_photo_path ?? $googleUser->getAvatar(),
                    ]);
                } catch (\Throwable $e) {
                    // Not fatal for login; log only
                    Log::warning('Failed to update google_id/profile photo', [
                        'message' => $e->getMessage(),
                        'class' => get_class($e),
                        'user_id' => $user->id,
                    ]);
                }
            }

            // Check if existing user's account is pending or rejected
            if (($user->status ?? null) === 'pending') {
                return redirect()->route('auth.pending')
                    ->with('info', 'Akun Anda sedang ditinjau oleh admin. Silakan tunggu persetujuan.');
            }

            if (($user->status ?? null) === 'rejected') {
                return redirect()->route('auth.pending')
                    ->with('error', 'Akun Anda telah ditolak. Silakan hubungi admin untuk informasi lebih lanjut.');
            }
        }

        Auth::login($user, true);

        return redirect()->route('dashboard')
            ->with('success', 'Selamat datang! Berhasil masuk dengan Google.');
    }

    /**
     * Create a Guzzle HTTP client for Google OAuth.
     *
     * Uses the configured verify setting or local CA certificates when available.
     */
    protected function createGoogleHttpClient(): Client
    {
        $verify = config('services.google.verify', true);
        $cafile = ini_get('curl.cainfo') ?: ini_get('openssl.cafile');

        if ($verify === true && ! empty($cafile)) {
            $verify = $cafile;
        }

        if ($verify === true && app()->environment('local') && empty($cafile)) {
            Log::warning('Google OAuth local environment missing CA bundle; disabling SSL verification for callback.', [
                'curl_cainfo' => ini_get('curl.cainfo'),
                'openssl_cafile' => ini_get('openssl.cafile'),
                'google_verify_setting' => config('services.google.verify'),
            ]);

            $verify = false;
        }

        Log::info('Google OAuth HTTP client config', [
            'verify' => $verify,
            'curl_cainfo' => ini_get('curl.cainfo'),
            'openssl_cafile' => ini_get('openssl.cafile'),
        ]);

        return new Client(['verify' => $verify]);
    }
}
