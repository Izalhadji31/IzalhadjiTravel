<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - ASR GO</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-wrapper {
            max-width: 560px;
            margin: 2rem auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .email-header {
            background: linear-gradient(135deg, #0064d2 0%, #0d2147 100%);
            padding: 2rem 2.5rem;
            text-align: center;
        }
        .email-header h1 {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }
        .email-header h1 span {
            opacity: 0.8;
        }
        .email-body {
            padding: 2.5rem;
        }
        .email-greeting {
            font-size: 1rem;
            color: #333;
            margin: 0 0 1rem 0;
        }
        .email-text {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.6;
            margin: 0 0 1.5rem 0;
        }
        .email-button {
            display: inline-block;
            background: #0064d2;
            color: #ffffff !important;
            text-decoration: none;
            padding: 0.875rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-align: center;
            transition: background 0.2s;
        }
        .email-button:hover {
            background: #004ba0;
        }
        .button-wrapper {
            text-align: center;
            margin: 1.5rem 0;
        }
        .email-divider {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 1.5rem 0;
        }
        .email-small {
            font-size: 0.8rem;
            color: #999;
            line-height: 1.5;
        }
        .email-footer {
            background: #f8f9fa;
            padding: 1.25rem 2.5rem;
            text-align: center;
            font-size: 0.8rem;
            color: #999;
        }
        .verify-icon {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <div class="verify-icon">
                <svg width="24" height="24" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1><span>ASR</span> GO</h1>
        </div>
        <div class="email-body">
            <p class="email-greeting">Halo, {{ $userName ?? 'Pengguna' }}!</p>
            <p class="email-text">
                Terima kasih telah mendaftar di ASR GO. Untuk mengaktifkan akun Anda dan mulai menggunakan layanan kami, silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini:
            </p>

            <div class="button-wrapper">
                <a href="{{ $verificationUrl }}" class="email-button">Verifikasi Email</a>
            </div>

            <p class="email-text">
                Jika tombol di atas tidak berfungsi, salin dan tempel link berikut di browser Anda:
            </p>
            <p class="email-small" style="word-break: break-all; color: #0064d2;">
                {{ $verificationUrl }}
            </p>

            <hr class="email-divider">

            <p class="email-small">
                Jika Anda tidak membuat akun di ASR GO, Anda dapat mengabaikan email ini. Tidak ada tindakan lebih lanjut yang diperlukan.
            </p>
        </div>
        <div class="email-footer">
            <p style="margin: 0;">&copy; {{ date('Y') }} ASR GO — Sistem Manajemen Transportasi</p>
        </div>
    </div>
</body>
</html>
