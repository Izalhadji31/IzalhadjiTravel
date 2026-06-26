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
        :root {
            --trvl-bg: #ffffff;
            --trvl-text: #1a1a1a;
            --trvl-card: #ffffff;
            --trvl-border: #e5e7eb;
        }
        .dark {
            --trvl-bg: #1a1a2e;
            --trvl-text: #e0e0e0;
            --trvl-card: #16213e;
            --trvl-border: #2a2a4a;
        }
        * { font-family: 'Inter', sans-serif; }
        html, body { background: var(--trvl-bg); color: var(--trvl-text); }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: var(--trvl-card);
            border-right: 1px solid var(--trvl-border);
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
            border-bottom: 1px solid var(--trvl-border);
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
            background: var(--trvl-card);
            border-bottom: 1px solid var(--trvl-border);
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
            background: var(--trvl-bg);
            border: 1px solid var(--trvl-border);
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            width: 300px;
            position: relative;
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
            background: var(--trvl-bg);
            border: 1px solid var(--trvl-border);
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
            background: var(--trvl-card);
            border: 1px solid var(--trvl-border);
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
            background: var(--trvl-card);
            border: 1px solid var(--trvl-border);
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

        /* Toast Animation */
        @keyframes trvlToastSlideIn {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
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
                <a href="{{ route('bookings.index') }}" class="sidebar-link @if(request()->routeIs('bookings.index')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    My Bookings
                </a>
                <a href="{{ route('bookings.travel') }}" class="sidebar-link @if(request()->routeIs('bookings.travel*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Travel
                </a>
                <a href="{{ route('bookings.rental') }}" class="sidebar-link @if(request()->routeIs('bookings.rental*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    Rental
                </a>
            </div>
            <div class="sidebar-section">
                <div class="sidebar-section-label">Lainnya</div>
                <a href="{{ route('refunds.index') }}" class="sidebar-link @if(request()->routeIs('refunds.*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                    My Refunds
                </a>
                <a href="{{ route('notifications.index') }}" class="sidebar-link @if(request()->routeIs('notifications.*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Notifications
                    @php $unreadCust = auth()->check() ? auth()->user()->notifications()->unread()->count() : 0; @endphp
                    @if($unreadCust > 0)
                        <span style="margin-left:auto;min-width:20px;height:20px;background:#ef4444;color:white;font-size:0.7rem;font-weight:700;border-radius:9999px;display:flex;align-items:center;justify-content:center;padding:0 6px;">{{ $unreadCust > 99 ? '99+' : $unreadCust }}</span>
                    @endif
                </a>
                <a href="{{ route('bookings.index', ['filter' => 'review']) }}" class="sidebar-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    My Reviews
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
            <div class="sidebar-section">
                <div class="sidebar-section-label">Lainnya</div>
                <a href="{{ route('notifications.index') }}" class="sidebar-link @if(request()->routeIs('notifications.*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Notifications
                    @php $unreadDriver = auth()->check() ? auth()->user()->notifications()->unread()->count() : 0; @endphp
                    @if($unreadDriver > 0)
                        <span style="margin-left:auto;min-width:20px;height:20px;background:#ef4444;color:white;font-size:0.7rem;font-weight:700;border-radius:9999px;display:flex;align-items:center;justify-content:center;padding:0 6px;">{{ $unreadDriver > 99 ? '99+' : $unreadDriver }}</span>
                    @endif
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
            <div class="sidebar-section">
                <div class="sidebar-section-label">Lainnya</div>
                <a href="{{ route('notifications.index') }}" class="sidebar-link @if(request()->routeIs('notifications.*')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Notifications
                    @php $unreadPartner = auth()->check() ? auth()->user()->notifications()->unread()->count() : 0; @endphp
                    @if($unreadPartner > 0)
                        <span style="margin-left:auto;min-width:20px;height:20px;background:#ef4444;color:white;font-size:0.7rem;font-weight:700;border-radius:9999px;display:flex;align-items:center;justify-content:center;padding:0 6px;">{{ $unreadPartner > 99 ? '99+' : $unreadPartner }}</span>
                    @endif
                </a>
                <a href="{{ route('fleet.maintenance') }}" class="sidebar-link @if(request()->routeIs('fleet.maintenance')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Maintenance Log
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
                <div class="search-box" id="globalSearchBox">
                    <svg style="width: 1rem; height: 1rem; color: #999;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" id="globalSearchInput" placeholder="Cari rute, kendaraan, driver..." autocomplete="off">
                    <!-- Search Dropdown -->
                    <div id="searchDropdown" style="display:none;position:absolute;top:100%;left:0;right:0;margin-top:4px;background:white;border:1px solid #e5e7eb;border-radius:0.5rem;box-shadow:0 10px 25px rgba(0,0,0,0.1);z-index:50;max-height:350px;overflow-y:auto;">
                    </div>
                </div>
            </div>
            <div class="topbar-right">
                <button id="darkModeToggle" class="topbar-btn" type="button" title="Toggle Dark Mode">
                    <svg id="sunIcon" class="hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:1.25rem;height:1.25rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg id="moonIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:1.25rem;height:1.25rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>

                <a href="{{ route('notifications.index') }}" class="topbar-btn" style="position: relative; text-decoration: none;" title="Notifikasi">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @php $unreadNotifications = auth()->check() ? auth()->user()->notifications()->unread()->count() : 0; @endphp
                    @if($unreadNotifications > 0)
                        <span style="position: absolute; top: -4px; right: -4px; min-width: 18px; height: 18px; background: #ef4444; color: white; font-size: 0.7rem; font-weight: 700; border-radius: 9999px; display: flex; align-items: center; justify-content: center; padding: 0 5px; box-shadow: 0 0 0 2px var(--trvl-card);">{{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}</span>
                    @endif
                </a>
                
                <div class="user-menu">
                    @auth
                        <div class="user-avatar" style="overflow:hidden; border-radius:9999px;" title="{{ auth()->user()->name }}">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="{{ auth()->user()->name }}" style="width:100%;height:100%;object-fit:cover;">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @endif
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

    {{-- Toast Notifications --}}
    @if(session('success'))
        @include('components.toast', ['type' => 'success', 'message' => session('success')])
    @endif
    @if(session('error'))
        @include('components.toast', ['type' => 'error', 'message' => session('error')])
    @endif
    @if(session('warning'))
        @include('components.toast', ['type' => 'warning', 'message' => session('warning')])
    @endif
    @if(session('info'))
        @include('components.toast', ['type' => 'info', 'message' => session('info')])
    @endif

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

        // Global Search with debounce
        (function () {
            const searchInput = document.getElementById('globalSearchInput');
            const searchDropdown = document.getElementById('searchDropdown');
            const searchBox = document.getElementById('globalSearchBox');
            let debounceTimer;

            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    const query = this.value.trim();
                    clearTimeout(debounceTimer);

                    if (query.length < 2) {
                        searchDropdown.style.display = 'none';
                        return;
                    }

                    debounceTimer = setTimeout(function () {
                        fetch('{{ route("api.search") }}?q=' + encodeURIComponent(query))
                            .then(response => response.json())
                            .then(data => {
                                let html = '';
                                const sections = [
                                    { key: 'routes', label: 'Rute', icon: '🛣️' },
                                    { key: 'vehicles', label: 'Kendaraan', icon: '🚗' },
                                    { key: 'drivers', label: 'Driver', icon: '👤' },
                                    { key: 'partners', label: 'Partner', icon: '🤝' },
                                ];

                                sections.forEach(function (section) {
                                    if (data[section.key] && data[section.key].length > 0) {
                                        html += '<div style="padding:8px 12px;font-size:0.75rem;font-weight:600;color:#999;background:#f9fafb;border-bottom:1px solid #f3f4f6;">' + section.label + '</div>';
                                        data[section.key].forEach(function (item) {
                                            html += '<a href="' + item.url + '" style="display:flex;align-items:center;gap:10px;padding:10px 12px;text-decoration:none;color:#333;transition:background 0.15s;" onmouseover="this.style.background=\'#f0f9ff\'" onmouseout="this.style.background=\'transparent\'">';
                                            html += '<span style="font-size:1.1rem;">' + section.icon + '</span>';
                                            html += '<div style="flex:1;min-width:0;">';
                                            html += '<div style="font-weight:500;font-size:0.9rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + item.label + '</div>';
                                            if (item.sub) html += '<div style="font-size:0.75rem;color:#999;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + item.sub + '</div>';
                                            html += '</div>';
                                            html += '</a>';
                                        });
                                    }
                                });

                                if (!html) {
                                    html = '<div style="padding:16px;text-align:center;color:#999;font-size:0.85rem;">Tidak ada hasil ditemukan</div>';
                                } else {
                                    html += '<a href="{{ route("search") }}?q=' + encodeURIComponent(query) + '" style="display:block;padding:10px 12px;text-align:center;font-size:0.85rem;color:#2563eb;font-weight:500;border-top:1px solid #f3f4f6;text-decoration:none;" onmouseover="this.style.background=\'#f0f9ff\'" onmouseout="this.style.background=\'transparent\'">Lihat semua hasil →</a>';
                                }

                                searchDropdown.innerHTML = html;
                                searchDropdown.style.display = 'block';
                            })
                            .catch(function () {
                                searchDropdown.style.display = 'none';
                            });
                    }, 300);
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function (e) {
                    if (!searchBox.contains(e.target)) {
                        searchDropdown.style.display = 'none';
                    }
                });

                // Focus input shows dropdown if has value
                searchInput.addEventListener('focus', function () {
                    if (this.value.trim().length >= 2) {
                        searchDropdown.style.display = 'block';
                    }
                });
            }
        })();
    </script>
</body>
</html>
