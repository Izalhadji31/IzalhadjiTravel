@extends('layouts.public')

@section('title', 'Home')

@section('content')
<!-- ==================== HERO ==================== -->
<section class="trvl-hero relative" id="layanan">
    <div class="trvl-hero-orb trvl-hero-orb-1"></div>
    <div class="trvl-hero-orb trvl-hero-orb-2"></div>

    <div class="trvl-container relative z-10 trvl-hero-content">
        <div class="text-center">
            <div class="trvl-hero-badge">
                <span class="pulse-dot"></span>
                Melayani seluruh rute di Pulau Flores
            </div>
            <h1 class="trvl-hero-title">
                Jelajahi Flores<br>
                <span class="highlight">Bersama ASR GO</span>
            </h1>
            <p class="trvl-hero-subtitle mx-auto">
                Travel antar kota, airport transfer, dan rental kendaraan terpercaya di Pulau Flores. Nyaman, aman, tepat waktu.
            </p>
        </div>

        <!-- Service Tabs -->
        <div class="trvl-service-tabs" id="service-tabs">
            <button class="trvl-service-tab active" onclick="switchTab('rental', this)" id="tab-rental">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                Rental Mobil
            </button>
            <button class="trvl-service-tab inactive" onclick="switchTab('travel', this)" id="tab-travel">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Travel
            </button>
            <button class="trvl-service-tab inactive" onclick="switchTab('airport', this)" id="tab-airport">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0L7 10m5-5l5 5"/></svg>
                Airport Transfer
            </button>
        </div>

        <!-- Booking Card -->
        <div class="trvl-booking-wrapper max-w-5xl mx-auto">
            <div class="trvl-booking-card">
                <!-- PANEL: RENTAL -->
                <div id="panel-rental" class="trvl-booking-panel active">
                    <div class="trvl-booking-header">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#dbeafe;">
                                <svg class="w-5 h-5" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            </div>
                            <div>
                                <p class="trvl-field-label" style="margin:0;">Sewa Kendaraan</p>
                                <h2 class="text-base font-bold text-gray-900">Berpergian Lebih Bebas #AmanBarengASR</h2>
                            </div>
                        </div>
                    </div>
                    <div class="trvl-booking-body">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="trvl-field-label">Lokasi Penjemputan</label>
                                <input type="text" placeholder="Ende, Flores" value="Ende" class="trvl-form-field">
                            </div>
                            <div>
                                <label class="trvl-field-label">Tanggal Mulai</label>
                                <input type="date" value="{{ date('Y-m-d') }}" class="trvl-form-field">
                            </div>
                            <div>
                                <label class="trvl-field-label">Jam Jemput</label>
                                <input type="time" value="08:00" class="trvl-form-field">
                            </div>
                            <div>
                                <label class="trvl-field-label">Durasi Sewa</label>
                                <select class="trvl-form-field">
                                    <option>4 Jam</option><option>8 Jam</option><option>12 Jam</option>
                                    <option>24 Jam (Full Day)</option><option>2 Hari</option><option>3 Hari</option><option>1 Minggu</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="trvl-info-panel flex items-center gap-2 flex-1">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span style="color:#1e40af; font-weight:500;">Tersedia: Avanza, Innova, Hiace, Elf — armada terawat & ber-AC</span>
                            </div>
                            <a href="{{ route('public.vehicles') }}" class="trvl-btn-search flex-shrink-0 text-decoration-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Cari Kendaraan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- PANEL: TRAVEL -->
                <div id="panel-travel" class="trvl-booking-panel">
                    <div class="trvl-booking-header">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#dbeafe;">
                                <svg class="w-5 h-5" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </div>
                            <div>
                                <p class="trvl-field-label" style="margin:0;">Travel Antar Kota · Pulau Flores</p>
                                <h2 class="text-base font-bold text-gray-900">Berpusat di Ende — Melayani Seluruh Kota di Flores</h2>
                            </div>
                        </div>
                    </div>
                    <div class="trvl-booking-body">
                        <div class="trvl-info-panel flex items-center gap-2">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span style="color:#1e40af; font-weight:500; font-size:0.875rem;">✅ Pengemudi berpengalaman · ✅ AC · ✅ Asuransi Perjalanan · ✅ Door-to-door</span>
                        </div>
                        <div class="mt-6 flex justify-center">
                            <a href="{{ route('public.travel') }}" class="trvl-btn-search text-decoration-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Lihat Rute Travel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- PANEL: AIRPORT TRANSFER -->
                <div id="panel-airport" class="trvl-booking-panel">
                    <div class="trvl-booking-header">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#dbeafe;">
                                <svg class="w-5 h-5" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0L7 10m5-5l5 5"/></svg>
                            </div>
                            <div>
                                <p class="trvl-field-label" style="margin:0;">Airport Transfer · Pulau Flores</p>
                                <h2 class="text-base font-bold text-gray-900">Antar-Jemput Bandara — 6 Bandara di Flores</h2>
                            </div>
                        </div>
                    </div>
                    <div class="trvl-booking-body">
                        <div class="trvl-info-panel mb-4">
                            <div class="flex flex-wrap gap-x-6 gap-y-1 text-xs font-medium" style="color:#1e40af;">
                                <span>✅ Sudah termasuk tol & parkir</span>
                                <span>✅ Driver standby 30 menit lebih awal</span>
                                <span>✅ Free 1 bagasi besar</span>
                                <span>✅ Konfirmasi instan via WhatsApp</span>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <a href="https://wa.me/621500009" class="trvl-btn-search text-decoration-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Pesan Airport Transfer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== TRUST BADGES ==================== -->
<section class="trvl-trust-section">
    <div class="trvl-container">
        <div class="text-center mb-6">
            <p style="font-size:0.75rem; font-weight:600; color:#6c757d; text-transform:uppercase; letter-spacing:0.08em;">Dipercaya oleh ribuan pelanggan di Flores</p>
        </div>
        <div class="flex flex-wrap justify-center items-center gap-4 md:gap-6">
            <div class="trvl-trust-badge">🏛️ Kemenparekraf</div>
            <div class="trvl-trust-badge">🛡️ Aman & Terjamin</div>
            <div class="trvl-trust-badge">⭐ 4.9 Rating</div>
            <div class="trvl-trust-badge">👥 10K+ Pelanggan</div>
            <div class="trvl-trust-badge">🕐 Layanan 24 Jam</div>
        </div>
    </div>
</section>

<!-- ==================== STATS ==================== -->
<section style="background:white; padding:2.5rem 0; border-bottom:1px solid #e9ecef;">
    <div class="trvl-container">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-0 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="trvl-stat-card" style="border-right:1px solid #e9ecef; border-bottom:1px solid #e9ecef;">
                <p class="trvl-stat-number">10K+</p>
                <p class="trvl-stat-label">Penumpang Terlayani</p>
            </div>
            <div class="trvl-stat-card" style="border-bottom:1px solid #e9ecef; border-right:1px solid #e9ecef;">
                <p class="trvl-stat-number">{{ count($travelRoutes ?? []) }}</p>
                <p class="trvl-stat-label">Rute Antar Kota</p>
            </div>
            <div class="trvl-stat-card" style="border-right:1px solid #e9ecef;">
                <p class="trvl-stat-number">6</p>
                <p class="trvl-stat-label">Bandara Dilayani</p>
            </div>
            <div class="trvl-stat-card">
                <p class="trvl-stat-number">98%</p>
                <p class="trvl-stat-label">Tepat Waktu</p>
            </div>
        </div>
    </div>
</section>

<!-- ==================== MENGAPA PILIH ASR GO ==================== -->
<section class="trvl-section trvl-section-bg" id="keunggulan">
    <div class="trvl-container">
        <div class="trvl-section-header-center mb-12 trvl-reveal">
            <span class="trvl-section-badge">✨ Keunggulan Kami</span>
            <h2 class="trvl-section-title">Mengapa Pilih ASR GO?</h2>
            <p class="trvl-section-desc">Kami berkomitmen memberikan pengalaman perjalanan terbaik di Pulau Flores.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="trvl-feature-card trvl-reveal trvl-reveal-delay-1">
                <div class="trvl-feature-icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
                <h3 class="trvl-feature-title">Aman & Terpercaya</h3>
                <p class="trvl-feature-desc">Semua kendaraan dilengkapi asuransi perjalanan. Pengemudi berpengalaman dan tersertifikasi.</p>
            </div>
            <div class="trvl-feature-card trvl-reveal trvl-reveal-delay-2">
                <div class="trvl-feature-icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <h3 class="trvl-feature-title">Harga Transparan</h3>
                <p class="trvl-feature-desc">Tidak ada biaya tersembunyi. Harga sudah termasuk pajak, tol, dan parkir.</p>
            </div>
            <div class="trvl-feature-card trvl-reveal trvl-reveal-delay-3">
                <div class="trvl-feature-icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <h3 class="trvl-feature-title">Seluruh Pulau Flores</h3>
                <p class="trvl-feature-desc">Jangkauan layanan mencakup seluruh rute di Pulau Flores.</p>
            </div>
            <div class="trvl-feature-card trvl-reveal trvl-reveal-delay-1">
                <div class="trvl-feature-icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <h3 class="trvl-feature-title">Tepat Waktu</h3>
                <p class="trvl-feature-desc">98% perjalanan kami berangkat tepat waktu sesuai jadwal.</p>
            </div>
            <div class="trvl-feature-card trvl-reveal trvl-reveal-delay-2">
                <div class="trvl-feature-icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg></div>
                <h3 class="trvl-feature-title">Armada Premium</h3>
                <p class="trvl-feature-desc">Avanza, Innova, Hiace, Elf — semuanya terawat dan nyaman dengan AC.</p>
            </div>
            <div class="trvl-feature-card trvl-reveal trvl-reveal-delay-3">
                <div class="trvl-feature-icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
                <h3 class="trvl-feature-title">Layanan 24 Jam</h3>
                <p class="trvl-feature-desc">Tim customer service siap membantu 24/7 via telepon atau WhatsApp.</p>
            </div>
        </div>
    </div>
</section>

<!-- ==================== RUTE POPULER ==================== -->
<section class="trvl-section" id="rute">
    <div class="trvl-container">
        <div class="trvl-section-header-center mb-12 trvl-reveal">
            <span class="trvl-section-badge">🗺️ Rute Populer</span>
            <h2 class="trvl-section-title">Destinasi Favorit di Flores</h2>
            <p class="trvl-section-desc">Jelajahi keindahan Pulau Flores melalui rute-rute terpopuler.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse(($travelRoutes ?? []) as $route)
            <div class="trvl-route-card trvl-reveal">
                <div class="trvl-route-card-img">🏔️</div>
                <div class="trvl-route-card-body">
                    <div class="trvl-route-origin-dest">
                        <span class="trvl-route-city">{{ $route->origin ?? 'Ende' }}</span>
                        <span class="trvl-route-arrow">→</span>
                        <span class="trvl-route-city">{{ $route->destination ?? 'Labuan Bajo' }}</span>
                    </div>
                    <div class="trvl-route-meta">
                        <span class="trvl-route-meta-item">⏱️ {{ $route->duration ?? '8 jam' }}</span>
                        <span class="trvl-route-meta-item">📍 {{ $route->distance ?? '350 km' }}</span>
                    </div>
                    <div class="trvl-route-price">Rp {{ number_format($route->travelPrices->first()->price ?? 350000, 0, ',', '.') }} <span>/ orang</span></div>
                    <a href="{{ route('public.travel') }}" class="trvl-btn-pesan text-decoration-none">Pesan Sekarang</a>
                </div>
            </div>
            @empty
            <div class="trvl-route-card trvl-reveal">
                <div class="trvl-route-card-img">🏔️</div>
                <div class="trvl-route-card-body">
                    <div class="trvl-route-origin-dest"><span class="trvl-route-city">Ende</span><span class="trvl-route-arrow">→</span><span class="trvl-route-city">Labuan Bajo</span></div>
                    <div class="trvl-route-meta"><span class="trvl-route-meta-item">⏱️ 8 jam</span><span class="trvl-route-meta-item">📍 350 km</span></div>
                    <div class="trvl-route-price">Rp 350.000 <span>/ orang</span></div>
                    <a href="{{ route('public.travel') }}" class="trvl-btn-pesan text-decoration-none">Pesan Sekarang</a>
                </div>
            </div>
            <div class="trvl-route-card trvl-reveal trvl-reveal-delay-1">
                <div class="trvl-route-card-img" style="background:linear-gradient(135deg,#065f46 0%,#10b981 50%,#6ee7b7 100%);">🌊</div>
                <div class="trvl-route-card-body">
                    <div class="trvl-route-origin-dest"><span class="trvl-route-city">Ende</span><span class="trvl-route-arrow">→</span><span class="trvl-route-city">Maumere</span></div>
                    <div class="trvl-route-meta"><span class="trvl-route-meta-item">⏱️ 5 jam</span><span class="trvl-route-meta-item">📍 200 km</span></div>
                    <div class="trvl-route-price">Rp 250.000 <span>/ orang</span></div>
                    <a href="{{ route('public.travel') }}" class="trvl-btn-pesan text-decoration-none">Pesan Sekarang</a>
                </div>
            </div>
            <div class="trvl-route-card trvl-reveal trvl-reveal-delay-2">
                <div class="trvl-route-card-img" style="background:linear-gradient(135deg,#92400e 0%,#d97706 50%,#fbbf24 100%);">🌋</div>
                <div class="trvl-route-card-body">
                    <div class="trvl-route-origin-dest"><span class="trvl-route-city">Ende</span><span class="trvl-route-arrow">→</span><span class="trvl-route-city">Kelimutu</span></div>
                    <div class="trvl-route-meta"><span class="trvl-route-meta-item">⏱️ 3 jam</span><span class="trvl-route-meta-item">📍 100 km</span></div>
                    <div class="trvl-route-price">Rp 200.000 <span>/ orang</span></div>
                    <a href="{{ route('public.travel') }}" class="trvl-btn-pesan text-decoration-none">Pesan Sekarang</a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ==================== ARMADA ==================== -->
<section class="trvl-section trvl-section-bg" id="armada">
    <div class="trvl-container">
        <div class="trvl-section-header-center mb-12 trvl-reveal">
            <span class="trvl-section-badge">🚐 Armada Kami</span>
            <h2 class="trvl-section-title">Kendaraan Terawat & Nyaman</h2>
            <p class="trvl-section-desc">Pilihan armada berkualitas dengan perawatan rutin.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse(($rentalServices ?? []) as $service)
            <div class="trvl-vehicle-card trvl-reveal">
                <div class="trvl-vehicle-card-img">🚐</div>
                <div class="trvl-vehicle-card-body">
                    <h3 class="trvl-vehicle-name">{{ $service->vehicle_type ?? 'Toyota Avanza' }}</h3>
                    <div class="trvl-vehicle-specs">
                        <span class="trvl-vehicle-spec">👥 {{ $service->capacity ?? '6' }} Kursi</span>
                        <span class="trvl-vehicle-spec">❄️ AC</span>
                    </div>
                    <div class="trvl-vehicle-price">Rp {{ number_format($service->price_per_day ?? 350000, 0, ',', '.') }} <span>/ hari</span></div>
                    <a href="{{ route('public.rental') }}" class="trvl-btn-pesan text-decoration-none">Sewa Sekarang</a>
                </div>
            </div>
            @empty
            <div class="trvl-vehicle-card trvl-reveal">
                <div class="trvl-vehicle-card-img">🚐</div>
                <div class="trvl-vehicle-card-body">
                    <h3 class="trvl-vehicle-name">Toyota Avanza</h3>
                    <div class="trvl-vehicle-specs"><span class="trvl-vehicle-spec">👥 6 Kursi</span><span class="trvl-vehicle-spec">❄️ AC</span></div>
                    <div class="trvl-vehicle-price">Rp 350.000 <span>/ hari</span></div>
                    <a href="{{ route('public.rental') }}" class="trvl-btn-pesan text-decoration-none">Sewa Sekarang</a>
                </div>
            </div>
            <div class="trvl-vehicle-card trvl-reveal trvl-reveal-delay-1">
                <div class="trvl-vehicle-card-img" style="background:linear-gradient(135deg,#0f172a 0%,#1e293b 50%,#334155 100%);">🚌</div>
                <div class="trvl-vehicle-card-body">
                    <h3 class="trvl-vehicle-name">Toyota Innova</h3>
                    <div class="trvl-vehicle-specs"><span class="trvl-vehicle-spec">👥 7 Kursi</span><span class="trvl-vehicle-spec">❄️ AC</span></div>
                    <div class="trvl-vehicle-price">Rp 500.000 <span>/ hari</span></div>
                    <a href="{{ route('public.rental') }}" class="trvl-btn-pesan text-decoration-none">Sewa Sekarang</a>
                </div>
            </div>
            <div class="trvl-vehicle-card trvl-reveal trvl-reveal-delay-2">
                <div class="trvl-vehicle-card-img" style="background:linear-gradient(135deg,#1e3a8a 0%,#2563eb 50%,#60a5fa 100%);">🚐</div>
                <div class="trvl-vehicle-card-body">
                    <h3 class="trvl-vehicle-name">Toyota Hiace</h3>
                    <div class="trvl-vehicle-specs"><span class="trvl-vehicle-spec">👥 12 Kursi</span><span class="trvl-vehicle-spec">❄️ AC</span></div>
                    <div class="trvl-vehicle-price">Rp 750.000 <span>/ hari</span></div>
                    <a href="{{ route('public.rental') }}" class="trvl-btn-pesan text-decoration-none">Sewa Sekarang</a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ==================== TAMPILAN APLIKASI ==================== -->
<section class="trvl-section" id="tampilan" style="background:#fff;">
    <div class="trvl-container">
        <div class="trvl-section-header-center mb-8 trvl-reveal">
            <span class="trvl-section-badge" style="background:#f0fdf4;color:#059669;border-color:#a7f3d0;">📱 Tampilan Aplikasi</span>
            <h2 class="trvl-section-title" style="color:#0f172a;">Sistem Booking Online ASR GO</h2>
            <p class="trvl-section-desc">Kelola perjalanan dan pembayaran dalam satu platform terintegrasi.</p>
        </div>
        <div class="trvl-reveal">
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:12px;text-align:center;">
                <a href="{{ asset('images/screenshot-app.png') }}" target="_blank" style="display:block;">
                    <img src="{{ asset('images/screenshot-app.png') }}" 
                         alt="Tampilan Dashboard ASR GO" 
                         style="width:100%;max-width:900px;max-height:420px;object-fit:contain;border-radius:8px;box-shadow:0 4px 24px rgba(0,0,0,0.1);"
                         loading="lazy"
                    />
                </a>
                <p style="color:#64748b;font-size:0.85rem;margin-top:12px;margin-bottom:0;">Dashboard Pemilik Armada &mdash; Kelola driver, kendaraan, booking, dan bagi hasil.</p>
            </div>
        </div>
    </div>
</section>

<!-- ==================== CTA ==================== -->
<section class="trvl-cta-section py-20">
    <div class="trvl-container relative z-10">
        <div class="text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Siap Jelajahi Flores?</h2>
            <p style="color:rgba(191,219,254,0.9); margin-bottom:2rem; max-width:32rem; margin-left:auto; margin-right:auto;">Pesan sekarang dan nikmati perjalanan nyaman bersama ASR GO.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#layanan" class="trvl-btn-cta-white text-decoration-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Pesan Sekarang
                </a>
                <a href="https://wa.me/621500009" class="trvl-btn-cta-outline text-decoration-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Hubungi WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ==================== FOOTER ==================== -->
<footer class="trvl-footer py-12">
    <div class="trvl-container">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <p class="trvl-footer-brand mb-4">ASR <span>GO</span></p>
                <p class="text-sm" style="color:#64748b;">Layanan travel dan rental kendaraan terpercaya di Pulau Flores, NTT.</p>
            </div>
            <div>
                <p class="trvl-footer-heading">Layanan</p>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('public.travel') }}" class="trvl-footer-link">Travel Antar Kota</a>
                    <a href="{{ route('public.rental') }}" class="trvl-footer-link">Rental Mobil</a>
                    <a href="#" class="trvl-footer-link">Airport Transfer</a>
                </div>
            </div>
            <div>
                <p class="trvl-footer-heading">Perusahaan</p>
                <div class="flex flex-col gap-2">
                    <a href="#" class="trvl-footer-link">Tentang Kami</a>
                    <a href="#" class="trvl-footer-link">Syarat & Ketentuan</a>
                    <a href="#" class="trvl-footer-link">Kebijakan Privasi</a>
                </div>
            </div>
            <div>
                <p class="trvl-footer-heading">Kontak</p>
                <div class="flex flex-col gap-2">
                    <a href="https://wa.me/621500009" class="trvl-footer-link">📱 WhatsApp: 1500 009</a>
                    <a href="#" class="trvl-footer-link">📍 Jl. Soekarno-Hatta, Ende</a>
                    <a href="#" class="trvl-footer-link">📧 info@asrgo.id</a>
                </div>
            </div>
        </div>
        <div style="border-top:1px solid #1e293b; margin-top:2rem; padding-top:2rem; text-align:center;">
            <p class="text-sm" style="color:#64748b;">&copy; {{ date('Y') }} ASR GO. All rights reserved.</p>
        </div>
    </div>
</footer>
@endsection
