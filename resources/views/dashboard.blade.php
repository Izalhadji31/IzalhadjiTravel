@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Selamat datang kembali, {{ auth()->user()->name ?? 'User' }}!</p>
    </div>

    <!-- Stats Grid - Taxsee Driver Style -->
    <div class="stats-grid mb-6">
        <!-- Total Bookings -->
        <div class="stat-card">
            <div class="stat-icon bg-blue-50">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="stat-value">{{ $totalBookings ?? 0 }}</p>
            <p class="stat-label">Total Pemesanan</p>
            <span class="stat-trend up">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                +12%
            </span>
        </div>

        <!-- Pending -->
        <div class="stat-card">
            <div class="stat-icon bg-amber-50">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="stat-value">{{ $pendingBookings ?? 0 }}</p>
            <p class="stat-label">Menunggu</p>
            <span class="stat-trend down">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                -5%
            </span>
        </div>

        <!-- Active Routes -->
        <div class="stat-card">
            <div class="stat-icon bg-emerald-50">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <p class="stat-value">{{ $activeRoutes ?? 0 }}</p>
            <p class="stat-label">Rute Aktif</p>
            <span class="stat-trend up">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                +8%
            </span>
        </div>

        <!-- Revenue -->
        <div class="stat-card">
            <div class="stat-icon bg-purple-50">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="stat-value" style="font-size:1.25rem;">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
            <p class="stat-label">Total Pendapatan</p>
            <span class="stat-trend up">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                +23%
            </span>
        </div>
    </div>

    <!-- Main Grid: Map + Orders (Taxsee Driver Style) -->
    <div class="driver-grid">
        <!-- Map Column -->
        <div class="driver-map-col">
            <div class="card" style="padding:0; overflow:hidden;">
                <div class="card-header flex justify-between items-center" style="padding:1.25rem 1.5rem; margin:0;">
                    <span class="font-bold text-slate-900">Peta Lokasi Armada</span>
                    <span class="badge badge-success">● Live</span>
                </div>
                <div id="dashboardMap" style="height:420px; background:linear-gradient(135deg,#e0f2fe 0%,#f0f9ff 100%); display:flex; align-items:center; justify-content:center;">
                    <div style="text-align:center; color:#94a3b8;">
                        <svg class="w-16 h-16 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        <p class="font-medium">Peta Real-time</p>
                        <p class="text-xs mt-1">Integrasikan Google Maps / Leaflet.js</p>
                    </div>
                </div>
            </div>

            <!-- Fleet Status Grid (below map) -->
            <div class="grid grid-cols-3 gap-4 mt-4">
                <div class="card" style="text-align:center; padding:1rem;">
                    <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-xl font-extrabold text-slate-900">{{ $activeVehicles ?? 0 }}</p>
                    <p class="text-xs text-slate-500">Kendaraan Aktif</p>
                </div>
                <div class="card" style="text-align:center; padding:1rem;">
                    <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <p class="text-xl font-extrabold text-slate-900">{{ $activeDrivers ?? 0 }}</p>
                    <p class="text-xs text-slate-500">Pengemudi Aktif</p>
                </div>
                <div class="card" style="text-align:center; padding:1rem;">
                    <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-purple-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    </div>
                    <p class="text-xl font-extrabold text-slate-900">{{ $totalRoutes ?? 0 }}</p>
                    <p class="text-xs text-slate-500">Rute Tersedia</p>
                </div>
            </div>
        </div>

        <!-- Side Column: Orders + Quick Info -->
        <div class="driver-side-col">
            <!-- Order List - Taxsee Style -->
            <div class="card">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-base font-bold text-slate-900">Pesanan Terbaru</h2>
                    <a href="{{ route('bookings.travel') }}" class="text-xs text-blue-600 font-semibold hover:underline">Lihat semua →</a>
                </div>

                <div class="space-y-3">
                    <!-- Order 1 -->
                    <div class="order-card">
                        <div class="order-card-header">
                            <span class="order-id">#BK001</span>
                            <span class="order-fare">Rp 250.000</span>
                        </div>
                        <div class="order-route">
                            <div class="order-route-item">
                                <div class="order-route-dot pickup">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/></svg>
                                </div>
                                <div>
                                    <p class="order-route-text">Ende - Kota</p>
                                    <p class="order-route-sub">Pickup: Terminal Ende</p>
                                </div>
                            </div>
                            <div class="order-route-item">
                                <div class="order-route-dot dropoff">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <p class="order-route-text">Labuan Bajo</p>
                                    <p class="order-route-sub">Dropoff: Hotel Bidadari</p>
                                </div>
                            </div>
                        </div>
                        <div class="order-meta-row">
                            <span class="order-meta-item">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                2 jam
                            </span>
                            <span class="order-meta-item">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                125 km
                            </span>
                            <span class="badge badge-success">Aktif</span>
                        </div>
                    </div>

                    <!-- Order 2 -->
                    <div class="order-card">
                        <div class="order-card-header">
                            <span class="order-id">#BK002</span>
                            <span class="order-fare">Rp 180.000</span>
                        </div>
                        <div class="order-route">
                            <div class="order-route-item">
                                <div class="order-route-dot pickup">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/></svg>
                                </div>
                                <div>
                                    <p class="order-route-text">Maumere</p>
                                    <p class="order-route-sub">Pickup: Bandara Wai Oti</p>
                                </div>
                            </div>
                            <div class="order-route-item">
                                <div class="order-route-dot dropoff">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <p class="order-route-text">Ende</p>
                                    <p class="order-route-sub">Dropoff: Pelabuhan Ende</p>
                                </div>
                            </div>
                        </div>
                        <div class="order-meta-row">
                            <span class="order-meta-item">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                1.5 jam
                            </span>
                            <span class="order-meta-item">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                95 km
                            </span>
                            <span class="badge badge-warning">Menunggu</span>
                        </div>
                    </div>

                    <!-- Order 3 -->
                    <div class="order-card">
                        <div class="order-card-header">
                            <span class="order-id">#BK003</span>
                            <span class="order-fare">Rp 320.000</span>
                        </div>
                        <div class="order-route">
                            <div class="order-route-item">
                                <div class="order-route-dot pickup">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/></svg>
                                </div>
                                <div>
                                    <p class="order-route-text">Ende - Kota</p>
                                    <p class="order-route-sub">Pickup: Hotel Ende</p>
                                </div>
                            </div>
                            <div class="order-route-item">
                                <div class="order-route-dot dropoff">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <p class="order-route-text">Moni</p>
                                    <p class="order-route-sub">Dropoff: Danau Kelimutu</p>
                                </div>
                            </div>
                        </div>
                        <div class="order-meta-row">
                            <span class="order-meta-item">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                3 jam
                            </span>
                            <span class="order-meta-item">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                65 km
                            </span>
                            <span class="badge badge-success">Selesai</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <h2 class="text-base font-bold text-slate-900 mb-4">Aksi Cepat</h2>
                <div class="grid grid-cols-2 gap-3">
                    <a href="/bookings/travel/create" class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50 transition-all duration-200 group">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                            <svg class="w-4.5 h-4.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span class="text-sm font-semibold text-slate-700">Travel Baru</span>
                    </a>
                    <a href="/bookings/rental/create" class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50 transition-all duration-200 group">
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                            <svg class="w-4.5 h-4.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>
                        <span class="text-sm font-semibold text-slate-700">Rental Baru</span>
                    </a>
                    <a href="/drivers" class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-100 hover:border-amber-200 hover:bg-amber-50 transition-all duration-200 group">
                        <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                            <svg class="w-4.5 h-4.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="text-sm font-semibold text-slate-700">Pengemudi</span>
                    </a>
                    <a href="/vehicles" class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-100 hover:border-purple-200 hover:bg-purple-50 transition-all duration-200 group">
                        <div class="w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                            <svg class="w-4.5 h-4.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        </div>
                        <span class="text-sm font-semibold text-slate-700">Kendaraan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
