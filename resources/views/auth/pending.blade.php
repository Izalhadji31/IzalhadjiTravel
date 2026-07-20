<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() === 'id' ? 'Status Akun' : 'Account Status' }} - ASR GO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0a1a40 0%, #1e3a8a 60%, #2563eb 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 1rem;
        }
        body::before {
            content: '';
            position: fixed; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }
        .card {
            width: 100%; max-width: 500px;
            background: white; border-radius: 1.5rem;
            padding: 2.5rem 2rem;
            box-shadow: 0 4px 24px rgba(37,99,235,0.10), 0 1px 4px rgba(0,0,0,0.06);
            position: relative; z-index: 1;
            text-align: center;
        }
        .brand {
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            margin-bottom: 2rem;
        }
        .brand-logo {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #1e40af, #2563eb);
            border-radius: 0.75rem;
            display: flex; align-items: center; justify-content: center;
        }
        .brand-name { font-size: 1.4rem; font-weight: 800; color: #111; }
        .brand-name span { color: #2563eb; }

        /* Status icon */
        .status-icon-wrap {
            width: 90px; height: 90px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
        }
        .status-icon-wrap.pending  { background: #fef9c3; }
        .status-icon-wrap.rejected { background: #fef2f2; }
        .status-icon-wrap.success  { background: #f0fdf4; }

        .status-title {
            font-size: 1.4rem; font-weight: 800; color: #111;
            margin-bottom: 0.75rem;
        }
        .status-message {
            font-size: 0.9rem; color: #6b7280; line-height: 1.7;
            margin-bottom: 1.75rem;
        }

        /* Progress steps for pending */
        .steps { display: flex; align-items: center; justify-content: center; gap: 0; margin: 1.5rem 0; }
        .step { display: flex; flex-direction: column; align-items: center; gap: 0.3rem; }
        .step-dot {
            width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; font-weight: 700;
        }
        .step-dot.done  { background: #2563eb; color: white; }
        .step-dot.active { background: #fbbf24; color: white; }
        .step-dot.wait  { background: #e5e7eb; color: #9ca3af; }
        .step-label { font-size: 0.7rem; color: #9ca3af; font-weight: 600; white-space: nowrap; }
        .step-label.done  { color: #2563eb; }
        .step-label.active { color: #d97706; }
        .step-line {
            width: 50px; height: 2px; background: #e5e7eb;
            margin-bottom: 1.2rem;
        }
        .step-line.done { background: #2563eb; }

        .btn {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.75rem 2rem;
            border-radius: 0.75rem;
            font-weight: 700; font-size: 0.9rem;
            text-decoration: none; cursor: pointer;
            transition: all 0.2s; border: none; font-family: inherit;
        }
        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            box-shadow: 0 4px 14px rgba(37,99,235,0.35);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(37,99,235,0.45); }
        .btn-ghost {
            background: transparent; color: #6b7280;
            border: 1.5px solid #e5e7eb;
            margin-left: 0.75rem;
        }
        .btn-ghost:hover { border-color: #9ca3af; color: #374151; }

        .info-box {
            background: #f8fafc; border: 1px solid #e5e7eb;
            border-radius: 0.75rem; padding: 1rem;
            margin: 1.25rem 0; text-align: left;
            font-size: 0.85rem; color: #374151;
        }
        .info-box li { display: flex; gap: 0.5rem; align-items: flex-start; margin-bottom: 0.4rem; }
        .info-box li:last-child { margin-bottom: 0; }
    </style>
</head>
<body>
    @php $locale = app()->getLocale(); @endphp
    <div class="card">
        <div class="brand">
            <div class="brand-logo">
                <svg width="22" height="22" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <span class="brand-name"><span>ASR</span> GO</span>
        </div>

        @if (session('success'))
            {{-- Registration just submitted --}}
            <div class="status-icon-wrap success">🎉</div>
            <h1 class="status-title">{{ $locale === 'id' ? 'Pendaftaran Berhasil!' : 'Registration Successful!' }}</h1>

            {{-- Progress steps --}}
            <div class="steps">
                <div class="step">
                    <div class="step-dot done">✓</div>
                    <div class="step-label done">{{ $locale === 'id' ? 'Daftar' : 'Register' }}</div>
                </div>
                <div class="step-line done"></div>
                <div class="step">
                    <div class="step-dot active">⏳</div>
                    <div class="step-label active">{{ $locale === 'id' ? 'Review Admin' : 'Admin Review' }}</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-dot wait">3</div>
                    <div class="step-label wait">{{ $locale === 'id' ? 'Aktif' : 'Active' }}</div>
                </div>
            </div>

            <p class="status-message">{{ session('success') }}</p>

            <ul class="info-box">
                <li><span>📧</span> <span>{{ $locale === 'id' ? 'Cek inbox email Anda untuk notifikasi persetujuan.' : 'Check your email inbox for an approval notification.' }}</span></li>
                <li><span>⏱️</span> <span>{{ $locale === 'id' ? 'Proses review biasanya membutuhkan 1×24 jam.' : 'The review process usually takes up to 24 hours.' }}</span></li>
                <li><span>📞</span> <span>{{ $locale === 'id' ? 'Hubungi WhatsApp kami jika perlu bantuan.' : 'Contact our WhatsApp if you need assistance.' }}</span></li>
            </ul>

        @elseif (session('info'))
            {{-- Trying to login while still pending --}}
            <div class="status-icon-wrap pending">⏳</div>
            <h1 class="status-title">{{ $locale === 'id' ? 'Akun Sedang Ditinjau' : 'Account Under Review' }}</h1>

            <div class="steps">
                <div class="step">
                    <div class="step-dot done">✓</div>
                    <div class="step-label done">{{ $locale === 'id' ? 'Daftar' : 'Register' }}</div>
                </div>
                <div class="step-line done"></div>
                <div class="step">
                    <div class="step-dot active">⏳</div>
                    <div class="step-label active">{{ $locale === 'id' ? 'Review Admin' : 'Admin Review' }}</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-dot wait">3</div>
                    <div class="step-label wait">{{ $locale === 'id' ? 'Aktif' : 'Active' }}</div>
                </div>
            </div>

            <p class="status-message">{{ session('info') }}</p>

        @elseif (session('error'))
            {{-- Rejected --}}
            <div class="status-icon-wrap rejected">❌</div>
            <h1 class="status-title">{{ $locale === 'id' ? 'Akun Ditolak' : 'Account Rejected' }}</h1>
            <p class="status-message">{{ session('error') }}</p>
            <ul class="info-box">
                <li><span>💬</span> <span>{{ $locale === 'id' ? 'Hubungi tim kami melalui WhatsApp untuk informasi lebih lanjut.' : 'Contact our team via WhatsApp for more information.' }}</span></li>
            </ul>

        @else
            {{-- Generic pending state --}}
            <div class="status-icon-wrap pending">⏳</div>
            <h1 class="status-title">{{ $locale === 'id' ? 'Status Akun' : 'Account Status' }}</h1>
            <p class="status-message">
                {{ $locale === 'id'
                    ? 'Akun Anda sedang dalam proses peninjauan oleh admin ASR GO.'
                    : 'Your account is currently being reviewed by the ASR GO admin team.' }}
            </p>
        @endif

        <div>
            <a href="{{ route('login') }}" class="btn btn-primary">
                {{ $locale === 'id' ? '← Kembali ke Masuk' : '← Back to Login' }}
            </a>
                <a href="tel:+6283156408078" class="btn btn-ghost">
                    📞 Hubungi Kami
                </a>
        </div>
    </div>
</body>
</html>
