@extends('layouts.app')

@section('title', 'Tracking Map')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="page-title">Real-time Tracking</h1>
                <p class="page-subtitle">Monitor all vehicle locations and active trips.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="badge badge-success">● Live</span>
                <a href="{{ route('tracking.dashboard') }}" class="btn btn-secondary text-sm">
                    ← Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="stats-grid mb-6">
        <div class="stat-card">
            <div class="stat-icon bg-emerald-50">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="stat-value">{{ $onlineVehicles ?? 12 }}</p>
            <p class="stat-label">Kendaraan Online</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-blue-50">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <p class="stat-value">{{ $activeTrips ?? 8 }}</p>
            <p class="stat-label">Perjalanan Aktif</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-amber-50">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="stat-value">{{ $pendingPickup ?? 3 }}</p>
            <p class="stat-label">Menunggu Jemput</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-slate-100">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <p class="stat-value">{{ $offlineVehicles ?? 2 }}</p>
            <p class="stat-label">Offline</p>
        </div>
    </div>

    <!-- Main Grid: Map + Active Orders (Taxsee Driver Style) -->
    <div class="grid-split-left">
        <!-- Map Section -->
        <div>
            <div class="map-container">
                <div class="card-header flex justify-between items-center" style="padding:1rem 1.25rem;">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-slate-900">Peta Armada</span>
                        <span class="text-xs text-slate-400">Auto-refresh: 10s</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="filter-chip active text-xs">Semua</button>
                        <button class="filter-chip inactive text-xs">Online</button>
                        <button class="filter-chip inactive text-xs">Offline</button>
                    </div>
                </div>
                <div id="fullMap" class="map-inner" style="height:520px; background:linear-gradient(135deg,#e0f2fe 0%,#f0f9ff 100%); display:flex; align-items:center; justify-content:center;">
                    <div style="text-align:center; color:#94a3b8;">
                        <svg class="w-20 h-20 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        <p class="font-bold text-slate-500 text-lg">Peta Real-time Armada</p>
                        <p class="text-sm mt-1">Integrasikan Google Maps / Leaflet.js</p>
                        <p class="text-xs mt-2 text-slate-400">Data lokasi kendaraan akan ditampilkan di sini</p>
                    </div>
                </div>
            </div>

            <!-- Vehicle List Grid (below map) -->
            <div class="card mt-4">
                <div class="card-header flex justify-between items-center" style="padding:1rem 1.25rem; margin:0;">
                    <span class="font-bold text-slate-900">Daftar Armada</span>
                    <span class="text-xs text-slate-400">{{ $totalVehicles ?? 14 }} kendaraan</span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 p-4">
                    <!-- Vehicle Item -->
                    <div class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all cursor-pointer">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <div class="status-indicator online" style="width:8px; height:8px;"></div>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">B 1234 ABC</p>
                            <p class="text-[10px] text-slate-400">Avanza · 4 kursi</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all cursor-pointer">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <div class="status-indicator online" style="width:8px; height:8px;"></div>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">B 5678 DEF</p>
                            <p class="text-[10px] text-slate-400">Innova · 6 kursi</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all cursor-pointer">
                        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center">
                            <div class="status-indicator offline" style="width:8px; height:8px;"></div>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">B 9012 GHI</p>
                            <p class="text-[10px] text-slate-400">Hiace · 12 kursi</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all cursor-pointer">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <div class="status-indicator online" style="width:8px; height:8px;"></div>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">B 3456 JKL</p>
                            <p class="text-[10px] text-slate-400">Elf · 14 kursi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Side Panel: Active Orders -->
        <div class="flex flex-col gap-5">
            <!-- Active Trips -->
            <div class="card">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-base font-bold text-slate-900">Perjalanan Aktif</h2>
                    <span class="badge badge-primary">{{ $activeTrips ?? 3 }}</span>
                </div>

                <div class="space-y-3">
                    <!-- Active Trip 1 -->
                    <div class="order-card" style="border-left: 3px solid #10b981;">
                        <div class="order-card-header">
                            <span class="order-id">#TRK001</span>
                            <span class="badge badge-success">Dalam Perjalanan</span>
                        </div>
                        <div class="order-route">
                            <div class="order-route-item">
                                <div class="order-route-dot pickup">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/></svg>
                                </div>
                                <div>
                                    <p class="order-route-text">Ende - Terminal</p>
                                    <p class="order-route-sub">10:30 AM · Budi S.</p>
                                </div>
                            </div>
                            <div class="order-route-item">
                                <div class="order-route-dot dropoff">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <p class="order-route-text">Labuan Bajo</p>
                                    <p class="order-route-sub">Est. 06:30 PM</p>
                                </div>
                            </div>
                        </div>
                        <div class="order-meta-row">
                            <span class="order-meta-item">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                B 1234 ABC
                            </span>
                            <span class="order-meta-item">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                4 penumpang
                            </span>
                        </div>
                        <div class="order-actions">
                            <button class="btn-primary text-xs py-1.5 px-3 flex-1">📍 Lacak</button>
                            <button class="btn-secondary text-xs py-1.5 px-3 flex-1">📞 Hubungi</button>
                        </div>
                    </div>

                    <!-- Active Trip 2 -->
                    <div class="order-card" style="border-left: 3px solid #f59e0b;">
                        <div class="order-card-header">
                            <span class="order-id">#TRK002</span>
                            <span class="badge badge-warning">Menunggu Jemput</span>
                        </div>
                        <div class="order-route">
                            <div class="order-route-item">
                                <div class="order-route-dot pickup">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/></svg>
                                </div>
                                <div>
                                    <p class="order-route-text">Bandara Wai Oti, Maumere</p>
                                    <p class="order-route-sub">11:00 AM · Rudi H.</p>
                                </div>
                            </div>
                            <div class="order-route-item">
                                <div class="order-route-dot dropoff">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <p class="order-route-text">Ende - Pelabuhan</p>
                                    <p class="order-route-sub">Est. 04:00 PM</p>
                                </div>
                            </div>
                        </div>
                        <div class="order-meta-row">
                            <span class="order-meta-item">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                B 5678 DEF
                            </span>
                            <span class="order-meta-item">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                2 penumpang
                            </span>
                        </div>
                        <div class="order-actions">
                            <button class="btn-primary text-xs py-1.5 px-3 flex-1">📍 Lacak</button>
                            <button class="btn-secondary text-xs py-1.5 px-3 flex-1">📞 Hubungi</button>
                        </div>
                    </div>

                    <!-- Active Trip 3 -->
                    <div class="order-card" style="border-left: 3px solid #3b82f6;">
                        <div class="order-card-header">
                            <span class="order-id">#TRK003</span>
                            <span class="badge badge-primary">Menuju Pickup</span>
                        </div>
                        <div class="order-route">
                            <div class="order-route-item">
                                <div class="order-route-dot pickup">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/></svg>
                                </div>
                                <div>
                                    <p class="order-route-text">Hotel Ende, Soekarno-Hatta</p>
                                    <p class="order-route-sub">02:00 PM · Adi W.</p>
                                </div>
                            </div>
                            <div class="order-route-item">
                                <div class="order-route-dot dropoff">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <p class="order-route-text">Danau Kelimutu, Moni</p>
                                    <p class="order-route-sub">Est. 05:00 PM</p>
                                </div>
                            </div>
                        </div>
                        <div class="order-meta-row">
                            <span class="order-meta-item">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                B 3456 JKL
                            </span>
                            <span class="order-meta-item">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                6 penumpang
                            </span>
                        </div>
                        <div class="order-actions">
                            <button class="btn-primary text-xs py-1.5 px-3 flex-1">📍 Lacak</button>
                            <button class="btn-secondary text-xs py-1.5 px-3 flex-1">📞 Hubungi</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Geofence Alerts -->
            <div class="card">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-base font-bold text-slate-900">Geofence Alerts</h2>
                    <span class="badge badge-danger">2</span>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-red-50 border border-red-100">
                        <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-red-800">B 9012 GHI keluar geofence</p>
                            <p class="text-[10px] text-red-600">5 menit lalu · Maumere</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-amber-50 border border-amber-100">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-amber-800">B 1234 ABC terlambat 15 menit</p>
                            <p class="text-[10px] text-amber-600">Rute: Ende → Labuan Bajo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
