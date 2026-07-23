<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() === 'id' ? 'Daftar Akun' : 'Create Account' }} - ASR GO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-[#0b1329] text-gray-100 min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden font-sans">
    
    <!-- Background Orbs -->
    <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-blue-600/10 blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-cyan-500/10 blur-[120px] pointer-events-none"></div>

    @php $locale = app()->getLocale(); @endphp

    {{-- Language Toggle --}}
    <a href="{{ route('lang.switch', ['locale' => $locale === 'id' ? 'en' : 'id']) }}"
       class="fixed top-5 right-5 z-50 flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-semibold px-4 py-2 rounded-full backdrop-blur-md transition-all duration-300">
        <span>{{ $locale === 'id' ? '🇺🇸 EN' : '🇮🇩 ID' }}</span>
    </a>

    <div class="max-w-md w-full space-y-8 bg-slate-900/60 border border-white/10 backdrop-blur-xl p-8 rounded-3xl shadow-2xl relative z-10">
        {{-- Brand Header --}}
        <div class="text-center">
            <div class="mx-auto h-12 w-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-cyan-500 flex items-center justify-center shadow-lg shadow-blue-500/30 mb-4">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold tracking-tight text-white">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">ASR</span> GO
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                {{ $locale === 'id' ? 'Daftar akun dan mulai perjalanan Anda' : 'Register your account and start your journey' }}
            </p>
        </div>

        {{-- Admin Approval Notice --}}
        <div class="bg-amber-500/10 border border-amber-500/20 rounded-2xl p-4 flex gap-3 text-sm text-amber-300">
            <span class="text-base">⏳</span>
            <div>
                <strong class="font-semibold block">{{ $locale === 'id' ? 'Persetujuan Admin Diperlukan' : 'Admin Approval Required' }}</strong>
                {{ $locale === 'id'
                    ? 'Setelah mendaftar, akun Anda akan ditinjau oleh tim admin sebelum dapat diakses penuh.'
                    : 'Once registered, your account will be reviewed by admin staff before full access is granted.' }}
            </div>
        </div>

        {{-- Session Success / Error Alert --}}
        @if (session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl p-4 flex gap-2 text-sm">
                <span>✅</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-2xl p-4 text-sm space-y-1">
                <div class="font-bold flex items-center gap-2">
                    <span>⚠️</span>
                    <span>{{ $locale === 'id' ? 'Registrasi Gagal' : 'Registration Failed' }}</span>
                </div>
                <ul class="list-disc pl-5 space-y-0.5 text-xs text-rose-300">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (! empty($pendingRegistration))
            {{-- OTP VERIFICATION --}}
            <div class="bg-blue-500/10 border border-blue-500/20 text-blue-300 rounded-2xl p-4 flex gap-3 text-sm mb-4">
                <span>ℹ️</span>
                <div>
                    {{ $locale === 'id'
                        ? 'Masukkan kode verifikasi OTP yang kami kirimkan ke nomor WhatsApp Anda.'
                        : 'Please enter the OTP verification code sent to your WhatsApp number.' }}
                </div>
            </div>

            <form method="POST" action="{{ route('register.verify-otp') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2" for="otp">
                        {{ $locale === 'id' ? 'Kode OTP' : 'OTP Code' }}
                    </label>
                    <input type="text" id="otp" name="otp"
                           class="w-full px-4 py-3 bg-slate-800/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-center tracking-widest text-lg font-bold"
                           placeholder="123456" maxlength="6" required autofocus>
                    @error('otp')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-bold rounded-xl shadow-lg transition duration-200">
                    {{ $locale === 'id' ? 'Verifikasi OTP' : 'Verify OTP' }}
                </button>
            </form>

            <div class="relative flex py-3 items-center">
                <div class="flex-grow border-t border-white/10"></div>
                <span class="flex-shrink mx-4 text-gray-500 text-xs uppercase">{{ $locale === 'id' ? 'atau' : 'or' }}</span>
                <div class="flex-grow border-t border-white/10"></div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <form method="POST" action="{{ route('register.resend-otp') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold rounded-xl transition duration-200">
                        {{ $locale === 'id' ? 'Kirim Ulang' : 'Resend' }}
                    </button>
                </form>
                <form method="POST" action="{{ route('register.cancel') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-2.5 bg-gray-700 hover:bg-gray-600 text-white text-sm font-bold rounded-xl transition duration-200">
                        {{ $locale === 'id' ? 'Batalkan' : 'Cancel' }}
                    </button>
                </form>
            </div>
        @else
            {{-- REGISTER FORM --}}
            <form method="POST" action="{{ route('register.store') }}" id="registerForm" class="space-y-4">
                @csrf
                
                {{-- Role is always customer for public registration. Mitra & Sopir are added by admin. --}}
                <input type="hidden" id="role" name="role" value="customer">

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5" for="name">
                        {{ $locale === 'id' ? 'Nama Lengkap' : 'Full Name' }}
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2.5 bg-slate-800/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                           placeholder="John Doe" required autofocus>
                    @error('name')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5" for="phone_display">
                        {{ $locale === 'id' ? 'Nomor Telepon WhatsApp' : 'WhatsApp Phone Number' }}
                    </label>
                    <div class="flex rounded-xl border border-white/10 bg-slate-800/80 overflow-hidden focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500">
                        <select id="dialCode" class="bg-transparent border-none py-2.5 pl-3 pr-2 text-sm text-gray-300 focus:outline-none cursor-pointer border-r border-white/10" onchange="updatePhone()">
                            <option value="+62" class="bg-slate-900 text-white">🇮🇩 +62</option>
                            <option value="+1" class="bg-slate-900 text-white">🇺🇸 +1</option>
                            <option value="+44" class="bg-slate-900 text-white">🇬🇧 +44</option>
                            <option value="+61" class="bg-slate-900 text-white">🇦🇺 +61</option>
                            <option value="+65" class="bg-slate-900 text-white">🇸🇬 +65</option>
                            <option value="+60" class="bg-slate-900 text-white">🇲🇾 +60</option>
                        </select>
                        <input type="tel" id="phone_display" class="flex-1 bg-transparent border-none px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none"
                               placeholder="8123456789" oninput="updatePhone()" required>
                    </div>
                    <input type="hidden" id="phone" name="phone" value="{{ old('phone') }}">
                    <div id="phoneError" class="mt-1 text-xs text-rose-400 hidden"></div>
                    <div id="phoneSuccess" class="mt-1 text-xs text-emerald-400 hidden"></div>
                    @error('phone')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5" for="email">
                        Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-2.5 bg-slate-800/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                           placeholder="your@email.com" required>
                    @error('email')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5" for="password">
                            {{ $locale === 'id' ? 'Kata Sandi' : 'Password' }}
                        </label>
                        <input type="password" id="password" name="password"
                               class="w-full px-4 py-2.5 bg-slate-800/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                               placeholder="••••••••" required>
                        @error('password')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5" for="password_confirmation">
                            {{ $locale === 'id' ? 'Konfirmasi' : 'Confirm' }}
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full px-4 py-2.5 bg-slate-800/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                               placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 mt-4 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-bold rounded-xl shadow-lg transition duration-200 cursor-pointer">
                    {{ $locale === 'id' ? 'Daftar Sekarang' : 'Create Account' }}
                </button>
            </form>

            <div class="relative flex py-3 items-center">
                <div class="flex-grow border-t border-white/10"></div>
                <span class="flex-shrink mx-4 text-gray-500 text-xs uppercase">{{ $locale === 'id' ? 'atau' : 'or' }}</span>
                <div class="flex-grow border-t border-white/10"></div>
            </div>

            {{-- Google Login --}}
            @php
                $googleConfigured = config('services.google.client_id') && config('services.google.client_secret');
                $googleDisabledMessage = $locale === 'id'
                    ? 'Login Google belum dikonfigurasi. Lengkapi .env.'
                    : 'Google login not configured. Complete .env.';
            @endphp
            <a href="{{ $googleConfigured ? route('auth.google') : '#' }}"
               class="w-full flex items-center justify-center gap-3 py-2.5 bg-white hover:bg-gray-100 text-gray-900 text-sm font-semibold rounded-xl border border-gray-200 transition duration-200 text-decoration-none"
               {{ $googleConfigured ? '' : 'onclick="event.preventDefault(); alert(\'' . $googleDisabledMessage . '\');"' }}>
                <svg width="18" height="18" viewBox="0 0 24 24" class="flex-shrink-0">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.83C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                <span>{{ $locale === 'id' ? 'Daftar dengan Google' : 'Sign up with Google' }}</span>
            </a>

            <div class="text-center mt-6 text-sm text-gray-400">
                {{ $locale === 'id' ? 'Sudah memiliki akun?' : 'Already have an account?' }}
                <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-semibold underline decoration-2">{{ $locale === 'id' ? 'Masuk di sini' : 'Sign in' }}</a>
            </div>
        @endif
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
        window.updatePhone = updatePhone;

        function validatePhoneDisplay(combined, raw) {
            var err = document.getElementById('phoneError');
            var ok  = document.getElementById('phoneSuccess');
            var digits = combined.replace(/\D/g, '');
            if (raw.length === 0) {
                err.classList.add('hidden');
                ok.classList.add('hidden');
                return;
            }
            if (digits.length < 7) {
                err.textContent = locale === 'id'
                    ? 'Nomor terlalu pendek. Minimal 6 digit setelah kode negara.'
                    : 'Number too short. At least 6 digits required after country code.';
                err.classList.remove('hidden');
                ok.classList.add('hidden');
            } else if (digits.length > 16) {
                err.textContent = locale === 'id'
                    ? 'Nomor terlalu panjang.'
                    : 'Number too long.';
                err.classList.remove('hidden');
                ok.classList.add('hidden');
            } else {
                err.classList.add('hidden');
                ok.textContent = '✓ ' + combined;
                ok.classList.remove('hidden');
            }
        }


        var registerForm = document.getElementById('registerForm');
        if (registerForm) {
            registerForm.addEventListener('submit', function(e) {
                updatePhone();
                var err = document.getElementById('phoneError');
                if (!err.classList.contains('hidden')) {
                    e.preventDefault();
                }
            });

            // Initialize old inputs if any
            var oldPhone = @json(old('phone'));
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
