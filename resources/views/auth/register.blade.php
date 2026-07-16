<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() === 'id' ? 'Daftar Akun' : 'Create Account' }} - ASR GO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --blue: #2563eb;
            --blue-dark: #1d4ed8;
            --border: #e5e7eb;
            --text: #111827;
            --muted: #6b7280;
            --bg: #f8fafc;
            --card: #ffffff;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0a1a40 0%, #1e3a8a 60%, #2563eb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

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

        .register-card {
            width: 100%;
            max-width: 500px;
            background: var(--card);
            border-radius: 1.5rem;
            padding: 2.5rem 2rem;
            box-shadow: 0 4px 24px rgba(37,99,235,0.10), 0 1px 4px rgba(0,0,0,0.06);
            position: relative;
            z-index: 1;
        }

        .brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        .brand-logo {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #1e40af, #2563eb);
            border-radius: 1rem;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 0.875rem;
            box-shadow: 0 4px 16px rgba(37,99,235,0.35);
        }
        .brand-name { font-size: 1.6rem; font-weight: 800; color: var(--text); letter-spacing: -0.02em; }
        .brand-name span { color: var(--blue); }
        .brand-sub { font-size: 0.85rem; color: var(--muted); margin-top: 0.25rem; }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.625rem;
            margin-bottom: 1.25rem;
            font-size: 0.875rem;
            display: flex; gap: 0.5rem; align-items: flex-start;
        }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
        .alert-error ul { margin: 0.4rem 0 0 1rem; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        @media (max-width: 520px) { .form-row { grid-template-columns: 1fr; } }

        .form-group { margin-bottom: 1rem; }
        .form-label {
            display: block;
            font-weight: 600; font-size: 0.85rem; color: var(--text);
            margin-bottom: 0.4rem;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 0.625rem;
            font-size: 0.9rem; color: var(--text);
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
        .form-success { color: #16a34a; font-size: 0.78rem; margin-top: 0.3rem; }

        /* Phone input with dial code */
        .phone-row {
            display: flex;
            gap: 0;
            border: 1.5px solid var(--border);
            border-radius: 0.625rem;
            overflow: hidden;
            background: var(--bg);
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .phone-row:focus-within {
            border-color: var(--blue);
            background: white;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .dial-select {
            border: none;
            background: transparent;
            padding: 0.75rem 0.5rem 0.75rem 0.875rem;
            font-size: 0.875rem; font-weight: 600;
            color: var(--text);
            cursor: pointer;
            outline: none;
            min-width: 90px;
            border-right: 1.5px solid var(--border);
            font-family: inherit;
        }
        .phone-number-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 0.75rem 1rem;
            font-size: 0.9rem; color: var(--text);
            outline: none;
            font-family: inherit;
        }
        .phone-hidden { display: none; }

        .btn-register {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, var(--blue), var(--blue-dark));
            color: white; border: none;
            border-radius: 0.75rem;
            font-weight: 700; font-size: 0.95rem;
            cursor: pointer; transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(37,99,235,0.35);
            font-family: inherit;
            margin-top: 0.5rem;
        }
        .btn-register:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(37,99,235,0.45); }
        .btn-register:active { transform: scale(0.98); }

        .divider {
            display: flex; align-items: center; gap: 0.75rem;
            margin: 1.25rem 0;
        }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        .divider span { font-size: 0.8rem; color: #9ca3af; white-space: nowrap; }

        .btn-google {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 0.75rem;
            background: white; color: var(--text);
            font-size: 0.9rem; font-weight: 600;
            cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 0.625rem;
            text-decoration: none; font-family: inherit;
        }
        .btn-google:hover { border-color: #4285F4; background: #f8f9ff; box-shadow: 0 2px 10px rgba(66,133,244,0.15); }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem; color: var(--muted);
        }
        .login-link a { color: var(--blue); text-decoration: none; font-weight: 600; }
        .login-link a:hover { text-decoration: underline; }

        .approval-notice {
            background: #fffbeb; border: 1px solid #fde68a;
            border-radius: 0.625rem; padding: 0.75rem 1rem;
            font-size: 0.82rem; color: #92400e;
            margin-bottom: 1.25rem;
            display: flex; gap: 0.5rem;
        }
    </style>
</head>
<body>
    @php $locale = app()->getLocale(); @endphp

    {{-- Language Toggle --}}
    <a href="{{ route('lang.switch', ['locale' => $locale === 'id' ? 'en' : 'id']) }}"
       class="lang-toggle">
        <span>{{ $locale === 'id' ? '🇺🇸 EN' : '🇮🇩 ID' }}</span>
    </a>

    <div class="register-card">
        {{-- Brand --}}
        <div class="brand">
            <div class="brand-logo">
                <svg width="26" height="26" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h1 class="brand-name"><span>ASR</span> GO</h1>
            <p class="brand-sub">{{ $locale === 'id' ? 'Buat akun baru Anda' : 'Create your new account' }}</p>
        </div>

        {{-- Admin approval notice --}}
        <div class="approval-notice">
            <span>⏳</span>
            <div>
                <strong>{{ $locale === 'id' ? 'Perlu Persetujuan Admin' : 'Admin Approval Required' }}</strong><br>
                {{ $locale === 'id'
                    ? 'Setelah mendaftar, akun Anda akan ditinjau oleh admin sebelum bisa digunakan.'
                    : 'After signing up, your account will be reviewed by an admin before you can access it.' }}
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success" style="background:#ecfdf5;border:1px solid #bbf7d0;color:#166534;">
                <span>✅</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <span>⚠️</span>
                <div>
                    <strong>{{ $locale === 'id' ? 'Pendaftaran Gagal' : 'Registration Failed' }}</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (! empty($pendingRegistration))
            <div class="alert alert-info" style="background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;">
                <span>ℹ️</span>
                <div>
                    {{ $locale === 'id'
                        ? 'Kami telah mengirimkan kode OTP ke nomor WhatsApp Anda. Masukkan kode untuk menyelesaikan pendaftaran.'
                        : 'We have sent the OTP code to your WhatsApp number. Enter it to complete registration.' }}
                </div>
            </div>

            <form method="POST" action="{{ route('register.verify-otp') }}" id="otpForm">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="otp">{{ $locale === 'id' ? 'Kode OTP' : 'OTP Code' }}</label>
                    <input type="text" id="otp" name="otp"
                           class="form-input"
                           placeholder="123456"
                           maxlength="6"
                           required autofocus>
                    @error('otp')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-register">
                    {{ $locale === 'id' ? 'Verifikasi OTP' : 'Verify OTP' }}
                </button>
            </form>

            <div class="divider"><span>{{ $locale === 'id' ? 'atau' : 'or' }}</span></div>
            <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
                <form method="POST" action="{{ route('register.resend-otp') }}" style="flex:1; min-width:180px;">
                    @csrf
                    <button type="submit" class="btn-register" style="background:#f97316;">{{ $locale === 'id' ? 'Kirim Ulang OTP' : 'Resend OTP' }}</button>
                </form>
                <form method="POST" action="{{ route('register.cancel') }}" style="flex:1; min-width:180px;">
                    @csrf
                    <button type="submit" class="btn-register" style="background:#9ca3af;">{{ $locale === 'id' ? 'Batalkan' : 'Cancel' }}</button>
                </form>
            </div>
        @else
            {{-- Register Form --}}
            <form method="POST" action="{{ route('register.store') }}" id="registerForm">
            @csrf
            <input type="hidden" name="role" value="customer">

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="name">
                        {{ $locale === 'id' ? 'Nama Lengkap' : 'Full Name' }}
                    </label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name') }}"
                           class="form-input"
                           placeholder="John Doe"
                           required autofocus>
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone_display">
                        {{ $locale === 'id' ? 'Nomor Telepon' : 'Phone Number' }}
                    </label>
                    {{-- Visible dial code + number UI --}}
                    <div class="phone-row" id="phoneRow">
                        <select id="dialCode" class="dial-select" onchange="updatePhone()">
                            <option value="+62" data-flag="🇮🇩" {{ str_starts_with(old('phone',''), '+62') || str_starts_with(old('phone',''), '08') ? 'selected' : '' }}>🇮🇩 +62</option>
                            <option value="+1" data-flag="🇺🇸">🇺🇸 +1</option>
                            <option value="+44" data-flag="🇬🇧">🇬🇧 +44</option>
                            <option value="+61" data-flag="🇦🇺">🇦🇺 +61</option>
                            <option value="+65" data-flag="🇸🇬">🇸🇬 +65</option>
                            <option value="+60" data-flag="🇲🇾">🇲🇾 +60</option>
                            <option value="+63" data-flag="🇵🇭">🇵🇭 +63</option>
                            <option value="+66" data-flag="🇹🇭">🇹🇭 +66</option>
                            <option value="+81" data-flag="🇯🇵">🇯🇵 +81</option>
                            <option value="+82" data-flag="🇰🇷">🇰🇷 +82</option>
                            <option value="+86" data-flag="🇨🇳">🇨🇳 +86</option>
                            <option value="+91" data-flag="🇮🇳">🇮🇳 +91</option>
                            <option value="+971" data-flag="🇦🇪">🇦🇪 +971</option>
                            <option value="+966" data-flag="🇸🇦">🇸🇦 +966</option>
                            <option value="+49" data-flag="🇩🇪">🇩🇪 +49</option>
                            <option value="+33" data-flag="🇫🇷">🇫🇷 +33</option>
                            <option value="+39" data-flag="🇮🇹">🇮🇹 +39</option>
                            <option value="+31" data-flag="🇳🇱">🇳🇱 +31</option>
                            <option value="+7" data-flag="🇷🇺">🇷🇺 +7</option>
                            <option value="+55" data-flag="🇧🇷">🇧🇷 +55</option>
                            <option value="+27" data-flag="🇿🇦">🇿🇦 +27</option>
                        </select>
                        <input type="tel" id="phone_display"
                               class="phone-number-input"
                               placeholder="{{ $locale === 'id' ? '812 3456 7890' : '800 555 1234' }}"
                               oninput="updatePhone()" required>
                    </div>
                    {{-- Hidden field submitted to server --}}
                    <input type="hidden" id="phone" name="phone" value="{{ old('phone') }}">
                    <div id="phoneError" class="form-error" style="display:none;"></div>
                    <div id="phoneSuccess" class="form-success" style="display:none;"></div>
                    @error('phone')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       class="form-input"
                       placeholder="{{ $locale === 'id' ? 'contoh@email.com' : 'your@email.com' }}"
                       required>
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="password">
                        {{ $locale === 'id' ? 'Kata Sandi' : 'Password' }}
                    </label>
                    <input type="password" id="password" name="password"
                           class="form-input" placeholder="••••••••" required>
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">
                        {{ $locale === 'id' ? 'Konfirmasi Kata Sandi' : 'Confirm Password' }}
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="form-input" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-register" id="submitBtn">
                {{ $locale === 'id' ? 'Daftar Sekarang' : 'Create Account' }}
            </button>
        </form>

        {{-- Google OAuth --}}
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
            {{ $locale === 'id' ? 'Daftar dengan Google' : 'Sign up with Google' }}
        </a>

        @unless($googleConfigured)
            <p class="login-link" style="margin-top:0.75rem; color:#6b7280; font-size:0.9rem;">
                {{ $googleDisabledMessage }}
            </p>
        @endunless

        <div class="login-link">
            {{ $locale === 'id' ? 'Sudah punya akun?' : 'Already have an account?' }}
            <a href="{{ route('login') }}">{{ $locale === 'id' ? 'Masuk di sini' : 'Sign in' }}</a>
        </div>
    </div>

    <script>
    (function() {
        var locale = '{{ $locale }}';

        function updatePhone() {
            var dial = document.getElementById('dialCode').value;
            var num  = document.getElementById('phone_display').value.trim();
            // Remove leading 0 for international
            var clean = num.replace(/^0+/, '').replace(/[\s\-]/g, '');
            var combined = dial + clean;
            document.getElementById('phone').value = combined;
            validatePhoneDisplay(combined, num);
        }

        function validatePhoneDisplay(combined, raw) {
            var err = document.getElementById('phoneError');
            var ok  = document.getElementById('phoneSuccess');
            // Must have at least 6 digits after the dial code
            var digits = combined.replace(/\D/g, '');
            if (raw.length === 0) {
                err.style.display = 'none';
                ok.style.display = 'none';
                return;
            }
            if (digits.length < 7) {
                err.textContent = locale === 'id'
                    ? 'Nomor terlalu pendek. Minimal 6 digit setelah kode negara.'
                    : 'Number too short. At least 6 digits required after country code.';
                err.style.display = 'block';
                ok.style.display = 'none';
            } else if (digits.length > 16) {
                err.textContent = locale === 'id'
                    ? 'Nomor terlalu panjang.'
                    : 'Number too long.';
                err.style.display = 'block';
                ok.style.display = 'none';
            } else {
                err.style.display = 'none';
                ok.textContent = '✓ ' + combined;
                ok.style.display = 'block';
            }
        }

        var registerForm = document.getElementById('registerForm');

        if (registerForm) {
            registerForm.addEventListener('submit', function(e) {
                updatePhone();
                var err = document.getElementById('phoneError');
                if (err.style.display === 'block') {
                    e.preventDefault();
                    document.getElementById('phoneRow').style.borderColor = '#ef4444';
                }
            });

            var oldPhone = '{{ old('phone') }}';
            if (oldPhone) {
                document.getElementById('phone').value = oldPhone;
                var normalized = oldPhone.replace(/[^0-9+]/g, '');
                if (normalized.startsWith('+')) {
                    var dialMatch = normalized.match(/^\+(\d{1,4})/);
                    if (dialMatch) {
                        var dialCode = '+' + dialMatch[1];
                        var select = document.getElementById('dialCode');
                        for (var i = 0; i < select.options.length; i++) {
                            if (select.options[i].value === dialCode) {
                                select.selectedIndex = i;
                                break;
                            }
                        }
                        document.getElementById('phone_display').value = normalized.slice(dialMatch[1].length + 1);
                    }
                } else if (normalized.startsWith('0')) {
                    document.getElementById('dialCode').value = '+62';
                    document.getElementById('phone_display').value = normalized.slice(1);
                } else {
                    document.getElementById('phone_display').value = normalized;
                }
            }
        }
    })();
    </script>
</body>
</html>
