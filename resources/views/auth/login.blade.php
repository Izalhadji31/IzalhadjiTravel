<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() === 'id' ? 'Masuk' : 'Login' }} - ASR GO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --blue: #2563eb;
            --blue-dark: #1d4ed8;
            --blue-light: #eff6ff;
            --border: #e5e7eb;
            --text: #111827;
            --muted: #6b7280;
            --bg: #f8fafc;
            --card: #ffffff;
            --shadow: 0 4px 24px rgba(37,99,235,0.10), 0 1px 4px rgba(0,0,0,0.06);
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0a1a40 0%, #1e3a8a 60%, #2563eb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* Lang toggle */
        .lang-toggle {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            z-index: 99;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            text-decoration: none;
            padding: 0.4rem 0.85rem;
            border-radius: 2rem;
            font-size: 0.8rem;
            font-weight: 600;
            backdrop-filter: blur(8px);
            transition: background 0.2s;
        }
        .lang-toggle:hover { background: rgba(255,255,255,0.25); }
        .lang-toggle .flag { font-size: 1.1rem; }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: var(--card);
            border-radius: 1.5rem;
            padding: 2.5rem 2rem;
            box-shadow: var(--shadow);
            position: relative;
            z-index: 1;
        }

        .brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        .brand-logo {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #1e40af, #2563eb);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.875rem;
            box-shadow: 0 4px 16px rgba(37,99,235,0.35);
        }
        .brand-name {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.02em;
        }
        .brand-name span { color: var(--blue); }
        .brand-sub {
            font-size: 0.85rem;
            color: var(--muted);
            margin-top: 0.25rem;
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.625rem;
            margin-bottom: 1.25rem;
            font-size: 0.875rem;
            display: flex;
            gap: 0.5rem;
            align-items: flex-start;
        }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
        .alert-info  { background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; }

        .form-group { margin-bottom: 1.125rem; }
        .form-label {
            display: block;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text);
            margin-bottom: 0.4rem;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 0.625rem;
            font-size: 0.9rem;
            color: var(--text);
            background: var(--bg);
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--blue);
            background: white;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .form-error { color: #ef4444; font-size: 0.78rem; margin-top: 0.3rem; }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            color: var(--muted);
            cursor: pointer;
        }
        .forgot-link {
            font-size: 0.85rem;
            color: var(--blue);
            text-decoration: none;
            font-weight: 500;
        }
        .forgot-link:hover { text-decoration: underline; }

        .btn-login {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, var(--blue), var(--blue-dark));
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(37,99,235,0.35);
            font-family: inherit;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37,99,235,0.45);
        }
        .btn-login:active { transform: scale(0.98); }

        .divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.25rem 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .divider span { font-size: 0.8rem; color: #9ca3af; white-space: nowrap; }

        .btn-google {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 0.75rem;
            background: white;
            color: var(--text);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            text-decoration: none;
            font-family: inherit;
        }
        .btn-google:hover {
            border-color: #4285F4;
            background: #f8f9ff;
            box-shadow: 0 2px 10px rgba(66,133,244,0.15);
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: var(--muted);
        }
        .register-link a {
            color: var(--blue);
            text-decoration: none;
            font-weight: 600;
        }
        .register-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    {{-- Language Toggle --}}
    @php $locale = app()->getLocale(); @endphp
    <a href="{{ route('lang.switch', ['locale' => $locale === 'id' ? 'en' : 'id']) }}"
       class="lang-toggle" title="{{ $locale === 'id' ? 'Switch to English' : 'Ganti ke Indonesia' }}">
        <span class="flag">{{ $locale === 'id' ? '🇺🇸' : '🇮🇩' }}</span>
        <span>{{ $locale === 'id' ? 'EN' : 'ID' }}</span>
    </a>

    <div class="login-card">
        {{-- Brand --}}
        <div class="brand">
            <div class="brand-logo">
                <svg width="26" height="26" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h1 class="brand-name"><span>ASR</span> GO</h1>
            <p class="brand-sub">{{ $locale === 'id' ? 'Sistem Manajemen Transportasi Flores' : 'Flores Transportation Management System' }}</p>
        </div>

        {{-- Alerts --}}
        @if ($errors->any())
            <div class="alert alert-error">
                <span>⚠️</span>
                <div>
                    <strong>{{ $locale === 'id' ? 'Masuk Gagal' : 'Login Failed' }}</strong>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">
                <span>ℹ️</span>
                <div>{{ session('info') }}</div>
            </div>
        @endif

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       class="form-input"
                       placeholder="{{ $locale === 'id' ? 'contoh@email.com' : 'your@email.com' }}"
                       required autofocus>
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">{{ $locale === 'id' ? 'Kata Sandi' : 'Password' }}</label>
                <input type="password" id="password" name="password"
                       class="form-input"
                       placeholder="••••••••"
                       required>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-row">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember" value="1">
                    {{ $locale === 'id' ? 'Ingat saya' : 'Remember me' }}
                </label>
                <a href="{{ route('password.request') }}" class="forgot-link">
                    {{ $locale === 'id' ? 'Lupa kata sandi?' : 'Forgot password?' }}
                </a>
            </div>

            <button type="submit" class="btn-login">
                {{ $locale === 'id' ? 'Masuk' : 'Sign In' }}
            </button>
        </form>

        {{-- Google Login --}}
        <div class="divider"><span>{{ $locale === 'id' ? 'atau' : 'or' }}</span></div>

        @php
            $googleConfigured = config('services.google.client_id') && config('services.google.client_secret');
            $googleDisabledMessage = $locale === 'id'
                ? 'Google login belum dikonfigurasi. Isi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET di .env.'
                : 'Google login is not configured. Set GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET in .env.';
        @endphp

        <a href="{{ $googleConfigured ? route('auth.google') : '#' }}"
           class="btn-google"
           {{ $googleConfigured ? '' : 'onclick="event.preventDefault(); alert(\'' . $googleDisabledMessage . '\');"' }}>
            <svg width="18" height="18" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.83C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            {{ $locale === 'id' ? 'Masuk dengan Google' : 'Continue with Google' }}
        </a>

        @unless($googleConfigured)
            <p class="register-link" style="margin-top:0.75rem; color:#6b7280; font-size:0.9rem;">
                {{ $googleDisabledMessage }}
            </p>
        @endunless

        <div class="register-link">
            {{ $locale === 'id' ? 'Belum punya akun?' : "Don't have an account?" }}
            <a href="{{ route('register') }}">{{ $locale === 'id' ? 'Daftar di sini' : 'Sign up' }}</a>
        </div>
    </div>
</body>
</html>
