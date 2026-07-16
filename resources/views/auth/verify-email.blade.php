<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - ASR GO</title>
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

        * { font-family: 'Inter', sans-serif; }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: linear-gradient(135deg, #f0f6ff 0%, #ffffff 50%, #e8f4fd 100%);
        }

        .login-box {
            width: 100%;
            max-width: 480px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: var(--trvl-radius-lg);
            padding: 2.5rem;
            box-shadow: var(--trvl-shadow-lg);
            text-align: center;
        }

        .login-logo {
            font-size: 2rem;
            font-weight: 700;
            color: #111;
            margin: 0 0 1.5rem 0;
        }

        .login-logo span { color: var(--trvl-blue); }

        .icon-circle {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: var(--trvl-blue-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
        }

        .verify-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--trvl-navy);
            margin: 0 0 0.75rem 0;
        }

        .verify-text {
            font-size: 0.9rem;
            color: #666;
            margin: 0 0 1.5rem 0;
            line-height: 1.6;
        }

        .verify-email {
            font-weight: 600;
            color: var(--trvl-blue);
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: var(--trvl-radius-sm);
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: var(--trvl-blue);
            color: white;
            border: none;
            border-radius: var(--trvl-radius-sm);
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-primary:hover {
            background: var(--trvl-blue-dark);
            box-shadow: var(--trvl-shadow-blue);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: white;
            color: var(--trvl-blue);
            border: 1px solid var(--trvl-blue);
            border-radius: var(--trvl-radius-sm);
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            margin-top: 0.75rem;
        }

        .btn-secondary:hover {
            background: var(--trvl-blue-light);
        }

        .logout-link {
            display: block;
            margin-top: 1.5rem;
            color: #999;
            font-size: 0.85rem;
            text-decoration: none;
        }

        .logout-link:hover {
            color: #666;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <!-- Logo -->
            <h1 class="login-logo"><span>ASR</span> GO</h1>

            <!-- Icon -->
            <div class="icon-circle">
                <svg width="36" height="36" fill="none" stroke="#0064d2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>

            <!-- Title -->
            <h2 class="verify-title">Verifikasi Email Anda</h2>

            <!-- Description -->
            <p class="verify-text">
                Sebelum melanjutkan, silakan verifikasi alamat email Anda dengan mengklik link yang telah kami kirim ke
                <span class="verify-email">{{ auth()->user()->email }}</span>.
                Jika Anda tidak menerima email, periksa folder spam Anda.
            </p>

            <!-- Status Message -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Resend Button -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Kirim Ulang Link Verifikasi
                </button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-link" style="background: none; border: none; cursor: pointer; font-size: 0.85rem;">
                    Logout
                </button>
            </form>
        </div>
    </div>
</body>
</html>
