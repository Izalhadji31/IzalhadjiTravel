<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Akun - ASR GO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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
        }
        * { font-family: 'Inter', sans-serif; }
        html, body { margin: 0; padding: 0; background: var(--trvl-bg); color: var(--trvl-text); }
        
        .status-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .status-box {
            width: 100%;
            max-width: 480px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 2.5rem 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            text-align: center;
        }
        
        .status-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
        }
        
        .status-icon.pending {
            background: #fef3c7;
            color: #d97706;
        }
        
        .status-icon.rejected {
            background: #fef2f2;
            color: #dc2626;
        }
        
        .status-icon.approved {
            background: #f0fdf4;
            color: #16a34a;
        }
        
        .status-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111;
            margin: 0 0 0.75rem 0;
        }
        
        .status-message {
            font-size: 0.95rem;
            color: #666;
            line-height: 1.6;
            margin: 0 0 2rem 0;
        }
        
        .status-action {
            display: inline-block;
            padding: 0.75rem 2rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        
        .status-action:hover {
            background: #1d4ed8;
        }
        
        .status-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 1.5rem;
        }
        
        .status-logo span { color: #2563eb; }
    </style>
</head>
<body>
    <div class="status-container">
        <div class="status-box">
            <div class="status-logo"><span>ASR</span> GO</div>
            
            @if (session('success'))
                <div class="status-icon pending">
                    <svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="status-title">Registrasi Berhasil!</h1>
                <p class="status-message">{{ session('success') }}</p>
            @elseif (session('info'))
                <div class="status-icon pending">
                    <svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="status-title">Akun Sedang Ditinjau</h1>
                <p class="status-message">{{ session('info') }}</p>
            @elseif (session('error'))
                <div class="status-icon rejected">
                    <svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="status-title">Akun Ditolak</h1>
                <p class="status-message">{{ session('error') }}</p>
            @else
                <div class="status-icon pending">
                    <svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="status-title">Status Akun</h1>
                <p class="status-message">Halaman ini menampilkan status akun Anda.</p>
            @endif
            
            <a href="{{ route('login') }}" class="status-action">Kembali ke Login</a>
        </div>
    </div>
</body>
</html>
