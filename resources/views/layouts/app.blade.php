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
        html, body { background: #f8f9fa; color: #333; }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 30;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-logo {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 1.125rem;
            color: #111;
        }
        
        .sidebar-logo span { color: #2563eb; }
        
        .sidebar-nav {
            padding: 1.5rem 0;
            flex: 1;
        }
        
        .sidebar-section {
            margin-bottom: 1.5rem;
        }
        
        .sidebar-section-label {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #999;
            padding: 0 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: #666;
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .sidebar-link:hover {
            background: #f3f4f6;
            color: #111;
        }
        
        .sidebar-link.active {
            background: #dbeafe;
            color: #2563eb;
            border-right: 3px solid #2563eb;
        }
        
        .sidebar-link svg { width: 1.125rem; height: 1.125rem; }
        
        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .topbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            height: 4rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 20;
        }
        
        .topbar-left { display: flex; align-items: center; gap: 2rem; flex: 1; }
        .topbar-right { display: flex; align-items: center; gap: 1rem; }
        
        .search-box {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            width: 300px;
        }
        
        .search-box input {
            background: transparent;
            border: none;
            outline: none;
            flex: 1;
            font-size: 0.9rem;
            color: #333;
        }
        
        .search-box input::placeholder { color: #999; }
        
        .topbar-btn {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            transition: all 0.2s;
        }
        
        .topbar-btn:hover {
            background: #e5e7eb;
            color: #111;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
        }
        
        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            background: #2563eb;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            width: 200px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            z-index: 100;
            margin-top: 0.5rem;
        }
        
        .user-menu:hover .dropdown-menu { display: block; }
        
        .dropdown-item {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            background: none;
            border: none;
            text-align: left;
            color: #666;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.9rem;
        }
        
        .dropdown-item:hover {
            background: #f3f4f6;
            color: #111;
        }
        
        .dropdown-item:first-child { border-radius: 0.5rem 0.5rem 0 0; }
        .dropdown-item:last-child { border-radius: 0 0 0.5rem 0.5rem; }
        
        /* Content Area */
        .content {
            flex: 1;
            padding: 2rem;
        }
        
        /* Page Header */
        .page-header {
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #111;
            margin: 0;
        }
        
        .page-subtitle {
            color: #666;
            margin: 0.5rem 0 0 0;
            font-size: 0.95rem;
        }
        
        /* Card */
        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.625rem;
            padding: 1.5rem;
            transition: all 0.2s;
        }
        
        .card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        
        /* Button */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        
        .btn-primary {
            background: #2563eb;
            color: white;
        }
        
        .btn-primary:hover {
            background: #1d4ed8;
        }
        
        .btn-secondary {
            background: #e5e7eb;
            color: #111;
        }
        
        .btn-secondary:hover {
            background: #d1d5db;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            }
            .sidebar.mobile-open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .topbar-left .search-box { display: none; }
            .page-title { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <span>ASR</span> GO
        </div>
        <nav class="sidebar-nav">
            <!-- Common / Dashboard Link -->
            <div class="sidebar-section">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link @if(request()->routeIs('admin.dashboard')) active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3v-6h4v6h3a1 1 0 001-1v-10"/></svg>
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="sidebar-link @if(request()->routeIs('dashboard')) active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3v-6h4v6h3a1 1 0 001-1v-10"/></svg>
                        Dashboard
                    </a>
                @endif
            </div>
            
            @if(auth()->user()->isAdmin())
                <!-- Admin Navigation -->
                <div class="sidebar-section">
                    <div class="sidebar-section-label">Manajemen Utama</div>
                    <a href="{{ route('admin.users') }}" class="sidebar-link @if(request()->routeIs('admin.users')) active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 4H9m6 16H9m6-7a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                        Manajemen User
                    </a>
                    <a href="/partners" class="sidebar-link @if(request()->segment(1) == 'partners') active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Manajemen Mitra
                    </a>
                    <a href="/drivers" class="sidebar-link @if(request()->segment(1) == 'drivers') active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Manajemen Driver
                    </a>
                    <a href="/vehicles" class="sidebar-link @if(request()->segment(1) == 'vehicles') active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        Manajemen Mobil
                    </a>
                </div>

                <div class="sidebar-section">
                    <div class="sidebar-section-label">Operasional & Armada</div>
                    <a href="/fleet" class="sidebar-link @if(request()->segment(1) == 'fleet') active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Fleet Management
                    </a>
                    <a href="/tracking" class="sidebar-link @if(request()->segment(1) == 'tracking') active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Live Tracking Maps
                    </a>
                    <a href="/routes" class="sidebar-link @if(request()->segment(1) == 'routes') active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        Manajemen Rute
                    </a>
                </div>

                <div class="sidebar-section">
                    <div class="sidebar-section-label">Sistem</div>
                    <a href="{{ route('admin.settings') }}" class="sidebar-link @if(request()->routeIs('admin.settings')) active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Pengaturan Sistem
                    </a>
                </div>
            @endif

            @if(auth()->user()->isPartner())
                <!-- Partner Navigation -->
                <div class="sidebar-section">
                    <div class="sidebar-section-label">Mitra Panel</div>
                    <a href="/vehicles" class="sidebar-link @if(request()->segment(1) == 'vehicles') active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        Armada Saya
                    </a>
                    <a href="/tracking" class="sidebar-link @if(request()->segment(1) == 'tracking') active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Lacak Lokasi Mobil
                    </a>
                </div>
            @endif

            @if(auth()->user()->isDriver())
                <!-- Driver Navigation -->
                <div class="sidebar-section">
                    <div class="sidebar-section-label">Driver Panel</div>
                    <a href="{{ route('dashboard') }}" class="sidebar-link @if(request()->routeIs('dashboard')) active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        Tugas Perjalanan
                    </a>
                </div>
            @endif

            @if(auth()->user()->role === 'customer')
                <!-- Customer Navigation -->
                <div class="sidebar-section">
                    <div class="sidebar-section-label">Pemesanan</div>
                    <a href="/bookings/travel" class="sidebar-link @if(request()->segment(2) == 'travel') active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Travel
                    </a>
                    <a href="/bookings/rental" class="sidebar-link @if(request()->segment(2) == 'rental') active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        Rental Mobil
                    </a>
                    <a href="/bookings/airport-transfer" class="sidebar-link @if(request()->segment(2) == 'airport-transfer') active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9-2-9-18-9 18 9 2zm0 0v-8m0-6v6m0 6v2m0-8h4m-4 0h-4m4-4h4m-4 0h-4"/></svg>
                        Airport Transfer
                    </a>
                </div>
            @endif

            <!-- Account Section -->
            @if(!auth()->user()->isAdmin())
                <div class="sidebar-section">
                    <div class="sidebar-section-label">Akun Saya</div>
                    <a href="/profile" class="sidebar-link @if(request()->segment(1) == 'profile') active @endif">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil Saya
                    </a>
                </div>
            @endif
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <div class="search-box">
                    <svg style="width: 1rem; height: 1rem; color: #999;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="Cari...">
                </div>
            </div>
            <div class="topbar-right">
                <button class="topbar-btn" title="Notifikasi">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </button>
                
                <div class="user-menu">
                    @auth
                        <div class="user-avatar" title="{{ auth()->user()->name }}">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="dropdown-menu">
                            <a href="/profile" class="dropdown-item">Profil</a>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>
    </div>
</body>
</html>
