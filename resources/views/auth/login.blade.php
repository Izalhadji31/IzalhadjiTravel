<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() === 'id' ? 'Masuk' : 'Login' }} - ASR GO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-950 via-blue-900 to-blue-600 font-[Inter]">
    @php $locale = app()->getLocale(); @endphp

    <a href="{{ route('lang.switch', ['locale' => $locale === 'id' ? 'en' : 'id']) }}"
       class="fixed right-4 top-4 z-20 inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/15 px-3 py-2 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/25"
       title="{{ $locale === 'id' ? 'Switch to English' : 'Ganti ke Indonesia' }}">
        <span class="text-base">{{ $locale === 'id' ? '🇺🇸' : '🇮🇩' }}</span>
        <span>{{ $locale === 'id' ? 'EN' : 'ID' }}</span>
    </a>

    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white p-8 shadow-2xl shadow-slate-950/20">
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-200">
                    <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-slate-900"><span class="text-blue-600">ASR</span> GO</h1>
                <p class="mt-2 text-sm text-slate-600">{{ $locale === 'id' ? 'Sistem Manajemen Transportasi Flores' : 'Flores Transportation Management System' }}</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <div class="font-semibold">{{ $locale === 'id' ? 'Masuk Gagal' : 'Login Failed' }}</div>
                    <ul class="mt-2 ml-5 list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('info'))
                <div class="mb-5 flex items-start gap-2 rounded-2xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-700">
                    <span>ℹ️</span>
                    <div>{{ session('info') }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700" for="email">Email</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100"
                           placeholder="{{ $locale === 'id' ? 'contoh@email.com' : 'your@email.com' }}"
                           required autofocus>
                    @error('email')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700" for="password">{{ $locale === 'id' ? 'Kata Sandi' : 'Password' }}</label>
                    <input type="password" id="password" name="password"
                           class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100"
                           placeholder="••••••••"
                           required>
                    @error('password')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex items-center justify-between gap-3">
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        {{ $locale === 'id' ? 'Ingat saya' : 'Remember me' }}
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm font-semibold text-blue-600 hover:underline">
                        {{ $locale === 'id' ? 'Lupa kata sandi?' : 'Forgot password?' }}
                    </a>
                </div>

                <button type="submit" class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">
                    {{ $locale === 'id' ? 'Masuk' : 'Sign In' }}
                </button>
            </form>

            <div class="my-6 flex items-center gap-3">
                <div class="h-px flex-1 bg-slate-200"></div>
                <span class="text-xs font-medium uppercase tracking-[0.2em] text-slate-400">{{ $locale === 'id' ? 'atau' : 'or' }}</span>
                <div class="h-px flex-1 bg-slate-200"></div>
            </div>

            @php
                $googleConfigured = config('services.google.client_id') && config('services.google.client_secret');
                $googleDisabledMessage = $locale === 'id'
                    ? 'Google login belum dikonfigurasi. Isi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET di .env.'
                    : 'Google login is not configured. Set GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET in .env.';
            @endphp

            @if ($googleConfigured)
                <a href="{{ route('auth.google') }}"
                   class="flex items-center justify-center gap-3 rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50">
                    <svg width="18" height="18" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.83C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    {{ $locale === 'id' ? 'Masuk dengan Google' : 'Continue with Google' }}
                </a>
            @else
                <a href="#"
                   class="flex items-center justify-center gap-3 rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50"
                   onclick="event.preventDefault(); alert(@js($googleDisabledMessage));">
                    <svg width="18" height="18" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.83C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    {{ $locale === 'id' ? 'Masuk dengan Google' : 'Continue with Google' }}
                </a>
            @endif

            @unless($googleConfigured)
                <p class="mt-3 text-center text-sm text-slate-500">
                    {{ $googleDisabledMessage }}
                </p>
            @endunless

            <div class="mt-6 text-center text-sm text-slate-600">
                {{ $locale === 'id' ? 'Belum punya akun?' : "Don't have an account?" }}
                <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:underline">{{ $locale === 'id' ? 'Daftar di sini' : 'Sign up' }}</a>
            </div>
        </div>
    </div>
</body>
</html>
