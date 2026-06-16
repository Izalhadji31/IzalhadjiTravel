<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - ASR GO</title>
    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            text-align: center;
            max-width: 500px;
            padding: 2rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .error-icon {
            font-size: 6rem;
            margin-bottom: 1rem;
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .error-message {
            font-size: 1.1rem;
            color: #dc2626;
            margin-bottom: 1rem;
        }

        .error-description {
            font-size: 0.95rem;
            color: #6b7280;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background 0.2s;
        }

        .btn:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">⚠️</div>
        <h1>500</h1>
        <p class="error-message">Server Error</p>
        <p class="error-description">
            Maaf, terjadi kesalahan pada server. Tim kami sudah diberitahu dan sedang bekerja untuk memperbaikinya.
            Silahkan coba lagi nanti.
        </p>
        <a href="/" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>
