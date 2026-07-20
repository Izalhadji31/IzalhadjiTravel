<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisterController extends Controller
{
    protected WhatsAppService $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Show register form
     */
    public function create(): View
    {
        $pendingRegistration = session('register.pending', null);
        return view('auth.register', compact('pendingRegistration'));
    }

    /**
     * Store a newly created user pending OTP verification.
     */
    public function store(Request $request): RedirectResponse
    {
        $locale = app()->getLocale();

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone'    => [
                'required',
                'string',
                'max:25',
                'regex:/^(\+\d{1,4}[\s\-]?\d{4,14}|08\d{8,13})$/',
            ],
        ], [
            'phone.regex' => $locale === 'id'
                ? 'Nomor telepon harus menggunakan format internasional (+62 xxx, +1 xxx, dll.) atau format lokal (08xxx).'
                : 'Phone number must use international format (+62 xxx, +1 xxx, etc.) or local format (08xxx).',
        ]);

        $phone = $this->normalizePhone($request->phone);

        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors([
                'email' => $locale === 'id'
                    ? 'Email sudah terdaftar.'
                    : 'This email is already registered.',
            ])->onlyInput('name', 'phone');
        }

        if (User::where('phone', $phone)->exists()) {
            return back()->withErrors([
                'phone' => $locale === 'id'
                    ? 'Nomor telepon sudah digunakan.'
                    : 'This phone number is already in use.',
            ])->onlyInput('name', 'email');
        }

        $otp = random_int(100000, 999999);
        $otpExpiresAt = now()->addMinutes(10);

        $pending = [
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $phone,
            'password'       => Hash::make($request->password),
            'role'           => 'customer',
            'status'         => 'pending',
            'otp'            => (string) $otp,
            'otp_expires_at' => $otpExpiresAt->toDateTimeString(),
        ];

        session(['register.pending' => $pending]);

        $message = $locale === 'id'
            ? "Kode OTP pendaftaran Anda adalah: {$otp}. Jangan bagikan kode ini kepada siapapun."
            : "Your registration OTP code is: {$otp}. Do not share this code with anyone.";

        $sent = $this->whatsappService->send($phone, $message);

        if (! $sent) {
            Log::warning('WhatsApp OTP registration failed', ['phone' => $phone]);
            session()->forget('register.pending');

            return back()->with('error', $locale === 'id'
                ? 'Gagal mengirim kode OTP. Silakan periksa kembali nomor WhatsApp Anda atau coba lagi nanti.'
                : 'Failed to send OTP. Please check your WhatsApp number or try again later.');
        }

        return redirect()->route('register')
            ->with('success', $locale === 'id'
                ? 'Kode OTP telah dikirimkan ke WhatsApp Anda. Masukkan kode untuk melanjutkan.'
                : 'OTP has been sent to your WhatsApp. Enter the code to continue.');
    }

    /**
     * Verify OTP and create the user account.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $locale = app()->getLocale();
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $pending = session('register.pending');

        if (! $pending) {
            return redirect()->route('register')->with('error', $locale === 'id'
                ? 'Sesi pendaftaran telah kedaluwarsa. Silakan isi formulir pendaftaran ulang.'
                : 'Your registration session has expired. Please fill out the registration form again.');
        }

        if (Carbon::parse($pending['otp_expires_at'])->isPast()) {
            session()->forget('register.pending');
            return redirect()->route('register')->with('error', $locale === 'id'
                ? 'Kode OTP telah kedaluwarsa. Silakan kirim ulang kode OTP.'
                : 'The OTP code has expired. Please resend the OTP.');
        }

        if ($request->otp !== $pending['otp']) {
            return back()->withErrors([
                'otp' => $locale === 'id'
                    ? 'Kode OTP tidak valid. Silakan coba lagi.'
                    : 'The OTP code is invalid. Please try again.',
            ]);
        }

        $user = User::create([
            'name'     => $pending['name'],
            'email'    => $pending['email'],
            'phone'    => $pending['phone'],
            'password' => $pending['password'],
            'role'     => $pending['role'],
            'status'   => $pending['status'],
        ]);

        if (! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        event(new Registered($user));
        session()->forget('register.pending');

        return redirect()->route('auth.pending')->with('success', $locale === 'id'
            ? 'Registrasi berhasil! Akun Anda sedang ditinjau oleh admin. Silakan tunggu notifikasi.'
            : 'Registration successful! Your account is under review by an admin. Please wait for confirmation.');
    }

    /**
     * Resend OTP to the pending registration phone number.
     */
    public function resendOtp(): RedirectResponse
    {
        $locale = app()->getLocale();
        $pending = session('register.pending');

        if (! $pending) {
            return redirect()->route('register')->with('error', $locale === 'id'
                ? 'Tidak ada proses pendaftaran yang sedang aktif. Silakan daftar ulang.'
                : 'There is no active registration process. Please start over.');
        }

        $otp = random_int(100000, 999999);
        $pending['otp'] = (string) $otp;
        $pending['otp_expires_at'] = now()->addMinutes(10)->toDateTimeString();
        session(['register.pending' => $pending]);

        $message = $locale === 'id'
            ? "Kode OTP baru Anda adalah: {$otp}. Jangan bagikan kode ini kepada siapapun."
            : "Your new OTP code is: {$otp}. Do not share this code with anyone.";

        $sent = $this->whatsappService->send($pending['phone'], $message);

        if (! $sent) {
            Log::warning('WhatsApp OTP resend failed', ['phone' => $pending['phone']]);
            return back()->with('error', $locale === 'id'
                ? 'Gagal mengirim ulang kode OTP. Silakan coba lagi nanti.'
                : 'Failed to resend OTP. Please try again later.');
        }

        return redirect()->route('register')->with('success', $locale === 'id'
            ? 'Kode OTP baru telah dikirim ke WhatsApp Anda.'
            : 'A new OTP has been sent to your WhatsApp.');
    }

    /**
     * Cancel the pending registration and clear the session.
     */
    public function cancelPending(): RedirectResponse
    {
        session()->forget('register.pending');
        return redirect()->route('register')->with('success', app()->getLocale() === 'id'
            ? 'Silakan mulai ulang pendaftaran Anda.'
            : 'Please start your registration again.');
    }

    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[\s\-]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '+62' . substr($phone, 1);
        }

        if (! str_starts_with($phone, '+')) {
            $phone = '+' . $phone;
        }

        return $phone;
    }
}
