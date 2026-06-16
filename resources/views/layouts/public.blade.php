<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ASR GO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; }
        html, body { margin: 0; padding: 0; background: #f8f9fa; color: #333; }
        
        .navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111;
            text-decoration: none;
        }
        
        .navbar-brand span { color: #2563eb; }
        
        .navbar-nav {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-link {
            color: #666;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .nav-link:hover { color: #2563eb; }
        
        .nav-btn {
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .nav-btn-primary {
            background: #2563eb;
            color: white;
        }
        
        .nav-btn-primary:hover { background: #1d4ed8; }
        
        .nav-btn-secondary {
            background: transparent;
            color: #2563eb;
            border: 1px solid #2563eb;
        }
        
        .nav-btn-secondary:hover {
            background: #dbeafe;
            border-color: #1d4ed8;
        }
        
        .footer {
            background: white;
            border-top: 1px solid #e5e7eb;
            padding: 2rem;
            margin-top: 4rem;
            text-align: center;
            color: #666;
            font-size: 0.9rem;
        }
        
        .footer a {
            color: #2563eb;
            text-decoration: none;
        }
        
        .footer a:hover { text-decoration: underline; }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .page-content {
            padding: 2rem 0;
            min-height: calc(100vh - 200px);
        }
        
        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.625rem;
            padding: 1.5rem;
            transition: all 0.2s;
        }
        
        .card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        
        @media (max-width: 768px) {
            .navbar { flex-direction: column; gap: 1rem; }
            .navbar-nav { flex-direction: column; gap: 1rem; width: 100%; }
            .nav-link { display: block; text-align: center; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="navbar-brand"><span>ASR</span> GO</a>
        <div class="navbar-nav">
            <a href="/" class="nav-link">Beranda</a>
            <a href="/public/travel" class="nav-link">Travel</a>
            <a href="/public/rental" class="nav-link">Rental</a>
            <a href="/public/about" class="nav-link">Tentang</a>
            @if(auth()->check())
                <a href="{{ route('dashboard') }}" class="nav-btn nav-btn-primary">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="nav-link">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-btn nav-btn-secondary">Login</a>
                <a href="{{ route('register') }}" class="nav-btn nav-btn-primary">Daftar</a>
            @endif
        </div>
    </nav>
    
    <!-- Content -->
    <div class="container page-content">
        @yield('content')
    </div>
    
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2026 ASR GO. Semua hak dilindungi. | <a href="#">Kebijakan Privasi</a> | <a href="#">Syarat & Ketentuan</a></p>
    </footer>
</body>
</html>
