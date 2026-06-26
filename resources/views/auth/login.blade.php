<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ASR GO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a', 950: '#172554' },
                        traveloka: { blue: '#0064d2', dark: '#0d2147', light: '#f0f6ff', orange: '#ff5e1c', green: '#00a651' }
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --trvl-blue: #0064d2;
            --trvl-blue-dark: #004ba0;
            --trvl-blue-light: #e8f4fd;
            --trvl-navy: #0d2147;
            --trvl-bg: #ffffff;
            --trvl-text: #1a1a1a;
            --trvl-card: #ffffff;
            --trvl-border: #e5e7eb;
            --trvl-shadow-sm: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06);
            --trvl-shadow-md: 0 4px 12px rgba(0,0,0,0.1), 0 2px 4px rgba(0,0,0,0.06);
            --trvl-shadow-lg: 0 10px 30px rgba(0,0,0,0.12), 0 4px 8px rgba(0,0,0,0.06);
            --trvl-shadow-blue: 0 4px 14px rgba(0,100,210,0.25);
            --trvl-radius-sm: 6px;
            --trvl-radius-md: 10px;
            --trvl-radius-lg: 16px;
            --trvl-radius-xl: 24px;
            --trvl-radius-full: 9999px;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .login-box {
            width: 100%;
            max-width: 400px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-logo {
            font-size: 2rem;
            font-weight: 700;
            color: #111;
            margin: 0 0 0.5rem 0;
        }
        
        .login-logo span { color: #2563eb; }
        
        .login-subtitle {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-weight: 500;
            color: #111;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            transition: all 0.2s;
            box-sizing: border-box;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
        }
        
        .form-error {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }
        
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }
        
        .login-button {
            width: 100%;
            padding: 0.75rem 1rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .login-button:hover {
            background: #1d4ed8;
        }
        
        .login-button:active {
            transform: scale(0.98);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .login-footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .checkbox-group input {
            cursor: pointer;
        }
        
        .checkbox-group label {
            cursor: pointer;
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }

        /* Dark mode toggle */
        .dark-mode-toggle {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 999;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--trvl-card);
            border: 1px solid var(--trvl-border);
            box-shadow: var(--trvl-shadow-md);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .dark-mode-toggle:hover { box-shadow: var(--trvl-shadow-lg); }
    </style>
</head>
<body>
    <div class="dark-mode-toggle" id="darkModeToggle" title="Toggle Dark Mode">
        <svg id="sunIcon" class="hidden" width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
        <svg id="moonIcon" width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
    </div>
    <div class="login-container">
        <div class="login-box">
            <!-- Header -->
            <div class="login-header">
                <h1 class="login-logo"><span>ASR</span> GO</h1>
                <p class="login-subtitle">Sistem Manajemen Transportasi</p>
            </div>
            
            <!-- Error Message -->
            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>Login Gagal</strong>
                    <ul style="margin: 0.5rem 0 0 0; padding-left: 1rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Login Form -->
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        value="{{ old('email') }}"
                        class="form-input"
                        placeholder="contoh@asrgo.com"
                        required
                        autofocus
                    >
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="form-input"
                        placeholder="••••••••"
                        required
                    >
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="remember" name="remember" value="1">
                        <label for="remember">Ingat saya</label>
                    </div>
                </div>
                
                <div style="margin: 1.25rem 0; display: flex; align-items: center; gap: 0.75rem;">
                    <div style="flex: 1; height: 1px; background: var(--trvl-border);"></div>
                    <span style="font-size: 0.85rem; color: #999;">atau</span>
                    <div style="flex: 1; height: 1px; background: var(--trvl-border);"></div>
                </div>

                <a href="{{ route('auth.google') }}" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; padding: 0.625rem 1rem; border: 1px solid var(--trvl-border); border-radius: 0.5rem; background: var(--trvl-card); color: var(--trvl-text); font-size: 0.9rem; font-weight: 500; text-decoration: none; transition: all 0.2s; margin-bottom: 1rem;" onmouseover="this.style.background='var(--trvl-bg)'" onmouseout="this.style.background='var(--trvl-card)'">
                    <svg width="18" height="18" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.83C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                    <span>Login dengan Google</span>
                </a>

                <button type="submit" class="login-button">Login</button>
            </form>
            
            <!-- Footer -->
            <div class="login-footer">
                <p style="margin: 0;">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                <p style="margin: 0.75rem 0 0 0; font-size: 0.85rem;"><a href="{{ route('password.request') }}" style="color: #666; text-decoration: none;">Lupa password?</a></p>
            </div>
        </div>
    </div>
    <script>
        (function () {
            const body = document.body;
            const sunIcon = document.getElementById('sunIcon');
            const moonIcon = document.getElementById('moonIcon');

            function applyDarkMode(enabled) {
                if (enabled) {
                    body.classList.add('dark');
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                } else {
                    body.classList.remove('dark');
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                }
                localStorage.setItem('darkMode', enabled ? '1' : '0');
            }

            const stored = localStorage.getItem('darkMode');
            applyDarkMode(stored === '1');

            document.getElementById('darkModeToggle').addEventListener('click', function () {
                applyDarkMode(!body.classList.contains('dark'));
            });
        })();
    </script>
</body>
</html>
