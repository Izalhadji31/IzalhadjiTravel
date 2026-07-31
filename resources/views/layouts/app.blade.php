<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ASR GO</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a', 950: '#172554' },
                    }
                }
            }
        }
    </script>
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
            scrollbar-width: thin;
            scrollbar-color: #d1d5db transparent;
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
            @php $role = auth()->user()->role ?? 'guest'; @endphp

            <div class="sidebar-section">
                <a href="{{ route('dashboard') }}" class="sidebar-link @if(request()->routeIs('dashboard')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3v-6h4v6h3a1 1 0 001-1v-10"/></svg>
                    Dashboard
                </a>
            </div>

            {{-- CUSTOMER / USER MENU --}}
            @if($role === 'customer')
            <div class="sidebar-section">
                <div class="sidebar-section-label">Pemesanan</div>
                <a href="{{ route('bookings.travel') }}" class="sidebar-link @if(request()->routeIs('bookings.travel*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Travel
                </a>
                <a href="{{ route('bookings.rental') }}" class="sidebar-link @if(request()->routeIs('bookings.rental*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    Rental
                </a>
            </div>
            @endif

            {{-- DRIVER / SOPIR MENU --}}
            @if($role === 'driver')
            <div class="sidebar-section">
                <div class="sidebar-section-label">Tugas</div>
                <a href="{{ route('driver.orders') }}" class="sidebar-link @if(request()->routeIs('driver.orders')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Order Aktif
                </a>
            </div>
            <div class="sidebar-section">
                <div class="sidebar-section-label">Pendapatan</div>
                <a href="{{ route('driver.earnings') }}" class="sidebar-link @if(request()->routeIs('driver.earnings')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Earnings
                </a>
            </div>
            @endif

            {{-- PARTNER / MITRA MENU --}}
            @if($role === 'partner')
            <div class="sidebar-section">
                <div class="sidebar-section-label">Partner</div>
                <a href="{{ route('partner.dashboard') }}" class="sidebar-link @if(request()->routeIs('partner.dashboard')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3v-6h4v6h3a1 1 0 001-1v-10"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('partner.armadas') }}" class="sidebar-link @if(request()->routeIs('partner.armadas.*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                    Armada
                </a>
                <a href="{{ route('partner.drivers') }}" class="sidebar-link @if(request()->routeIs('partner.drivers.*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Drivers
                </a>
                <a href="{{ route('partner.revenue') }}" class="sidebar-link @if(request()->routeIs('partner.revenue')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Revenue
                </a>
            </div>
            @endif

            {{-- ADMIN MENU --}}
            @if($role === 'admin')
            <div class="sidebar-section">
                <div class="sidebar-section-label">Manajemen</div>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link @if(request()->routeIs('admin.dashboard')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Overview
                </a>
                <a href="{{ route('admin.users') }}" class="sidebar-link @if(request()->routeIs('admin.users*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Users
                </a>
                <a href="{{ route('partners.index') }}" class="sidebar-link @if(request()->routeIs('partners.*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Mitra
                </a>
                <a href="{{ route('drivers.index') }}" class="sidebar-link @if(request()->routeIs('drivers.*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Sopir
                </a>
            </div>
            <div class="sidebar-section">
                <div class="sidebar-section-label">Booking</div>
                <a href="{{ route('bookings.travel') }}" class="sidebar-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Travel Booking
                </a>
                <a href="{{ route('bookings.rental') }}" class="sidebar-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2"/></svg>
                    Rental Booking
                </a>
            </div>
            <div class="sidebar-section">
                <div class="sidebar-section-label">Keuangan</div>
                <a href="{{ route('analytics.revenue') }}" class="sidebar-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Revenue & Payout
                </a>
                <a href="{{ route('fleet.dashboard') }}" class="sidebar-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                    Fleet & Armada
                </a>
                <a href="{{ route('admin.payments') }}" class="sidebar-link @if(request()->routeIs('admin.payments')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Payments
                </a>
                <a href="{{ route('admin.revenue-sharing') }}" class="sidebar-link @if(request()->routeIs('admin.revenue-sharing*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                    Revenue Sharing
                </a>
                <a href="{{ route('admin.vouchers') }}" class="sidebar-link @if(request()->routeIs('admin.vouchers*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                    Voucher
                </a>
            </div>
            @endif

            {{-- COMMON FOR ALL AUTHENTICATED USERS --}}
            <div class="sidebar-section">
                <div class="sidebar-section-label">Akun</div>
                <a href="{{ route('profile.show') }}" class="sidebar-link @if(request()->routeIs('profile.*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil
                </a>
            </div>
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
                <a href="{{ route('notifications.index') }}" class="topbar-btn" style="position: relative; text-decoration: none;" title="Notifikasi">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @php $unreadNotifications = auth()->check() ? auth()->user()->notifications()->unread()->count() : 0; @endphp
                    @if($unreadNotifications > 0)
                        <span style="position: absolute; top: -4px; right: -4px; min-width: 18px; height: 18px; background: #ef4444; color: white; font-size: 0.7rem; font-weight: 700; border-radius: 9999px; display: flex; align-items: center; justify-content: center; padding: 0 5px; box-shadow: 0 0 0 2px white;">{{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}</span>
                    @endif
                </a>
                
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
