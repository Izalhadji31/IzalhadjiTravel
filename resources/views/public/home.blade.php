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
                                <input type="text" value="Ende" readonly class="trvl-form-field" aria-label="Lokasi Penjemputan Rental">
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
                                    <option>12 Jam</option>
                                    <option>1 Hari</option>
                                    <option>2 Hari</option>
                                    <option>3 Hari</option>
                                    <option>1 Minggu</option>
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
                            <a href="https://wa.me/6283156408078?text=Halo%20ASR%20GO%2C%20saya%20ingin%20pesan%20airport%20transfer" class="trvl-btn-search text-decoration-none">
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
            @php
                $travelPrice = $route->travelPrices->first();
                $price = $travelPrice?->price_per_seat ?? $travelPrice?->price ?? 0;
                $duration = $route->estimated_hours ? number_format((float) $route->estimated_hours, 0) . ' jam' : 'Khusus';
                $distance = $route->distance_km ? number_format((float) $route->distance_km, 0) . ' km' : 'Tersedia';
            @endphp
            <div class="trvl-route-card trvl-reveal">
                <div class="trvl-route-card-img" style="background:linear-gradient(135deg,#0f766e 0%,#14b8a6 50%,#5eead4 100%);">🛣️</div>
                <div class="trvl-route-card-body">
                    <div class="trvl-route-origin-dest">
                        <span class="trvl-route-city">{{ $route->origin_city ?? 'Ende' }}</span>
                        <span class="trvl-route-arrow">→</span>
                        <span class="trvl-route-city">{{ $route->destination_city ?? 'Labuan Bajo' }}</span>
                    </div>
                    <div class="trvl-route-meta">
                        <span class="trvl-route-meta-item">⏱️ {{ $duration }}</span>
                        <span class="trvl-route-meta-item">📍 {{ $distance }}</span>
                    </div>
                    <div class="trvl-route-price">Rp {{ number_format($price, 0, ',', '.') }} <span>/ orang</span></div>
                    <a href="{{ route('public.travel') }}" class="trvl-btn-pesan text-decoration-none">Pesan Sekarang</a>
                </div>
            </div>
            @empty
            <div class="trvl-route-card trvl-reveal">
                <div class="trvl-route-card-img" style="background:linear-gradient(135deg,#0f766e 0%,#14b8a6 50%,#5eead4 100%);">🛣️</div>
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


    <!-- ==================== DESTINASI WISATA FLORES ==================== -->
    <section class="trvl-section" id="destinasi" style="background: white;">
        <div class="trvl-container">
            <div class="trvl-section-header-center mb-12 trvl-reveal">
                <span class="trvl-section-badge">🏝️ Jelajahi Flores</span>
                <h2 class="trvl-section-title">Destinasi Wisata Populer</h2>
                <p class="trvl-section-desc">Dari danau tiga warna hingga naga purba — Flores menyimpan keajaiban alam yang menakjubkan</p>
            </div>

            <!-- Featured: Danau Kelimutu -->
            <div class="trvl-reveal mb-8">
                <div class="rounded-2xl overflow-hidden shadow-xl relative group cursor-pointer">
                    <div class="aspect-video relative" style="max-height: 380px;">
                        <img src="https://images.unsplash.com/photo-1609137144813-7d9921338f24?w=1400&q=80" alt="Danau Kelimutu" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        <div class="absolute top-4 left-4">
                            <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-full">⭐ UNGGULAN</span>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <span class="text-white/70 text-sm">📍 Ende, NTT</span>
                            <h3 class="text-2xl font-bold text-white mt-1 mb-2">Danau Kelimutu</h3>
                            <p class="text-white/80 max-w-2xl">Tiga danau kawah dengan warna berbeda yang berubah secara misterius. Sunrise di puncak Kelimutu adalah momen yang tak terlupakan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Destinasi Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <div class="trvl-reveal">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=500&q=80" alt="Rumah Bung Karno" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-blue-600 font-medium">📍 Ende</span>
                            <h4 class="font-bold text-gray-900 mt-1">Rumah Bung Karno</h4>
                            <p class="text-gray-500 text-sm mt-1">Rumah tempat Bung Karno diasingkan 1934-1938. Kini menjadi museum bersejarah.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal trvl-reveal-delay-1">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1570789210967-2cac24afeb00?w=500&q=80" alt="Pulau Komodo" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-blue-600 font-medium">📍 Labuan Bajo</span>
                            <h4 class="font-bold text-gray-900 mt-1">Pulau Komodo</h4>
                            <p class="text-gray-500 text-sm mt-1">Habitat asli komodo, kadal terbesar di dunia. Warisan Alam UNESCO.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal trvl-reveal-delay-2">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=500&q=80" alt="Pink Beach" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-blue-600 font-medium">📍 Labuan Bajo</span>
                            <h4 class="font-bold text-gray-900 mt-1">Pink Beach</h4>
                            <p class="text-gray-500 text-sm mt-1">Salah satu dari 7 pantai berpasir merah muda di dunia.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1528181304800-259b08848526?w=500&q=80" alt="Wae Rebo" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-blue-600 font-medium">📍 Ruteng</span>
                            <h4 class="font-bold text-gray-900 mt-1">Desa Wae Rebo</h4>
                            <p class="text-gray-500 text-sm mt-1">Desa tradisional di atas awan 1.200 mdpl. Penghargaan UNESCO.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal trvl-reveal-delay-1">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=500&q=80" alt="Kampung Bena" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-blue-600 font-medium">📍 Bajawa</span>
                            <h4 class="font-bold text-gray-900 mt-1">Kampung Bena</h4>
                            <p class="text-gray-500 text-sm mt-1">Desa adat Ngada dengan megalit kuno dan rumah tradisional.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal trvl-reveal-delay-2">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=500&q=80" alt="Teluk Maumere" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-blue-600 font-medium">📍 Maumere</span>
                            <h4 class="font-bold text-gray-900 mt-1">Teluk Maumere</h4>
                            <p class="text-gray-500 text-sm mt-1">Surga diving dengan biodiversitas laut tertinggi di Indonesia Timur.</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- CTA -->
            <div class="text-center mt-10 trvl-reveal">
                <a href="{{ route('public.destinasi') }}" class="trvl-btn-primary inline-flex items-center gap-2">
                    Lihat Semua Destinasi
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
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
            @php
                $vehicleName = $service->route?->name ?: ($service->vehicle_type ?? 'Armada Premium');
                $seatCapacity = $service->route?->total_seats ?? 6;
                $price = $service->price_without_driver ?? $service->price_with_driver ?? 350000;
            @endphp
            <div class="trvl-vehicle-card trvl-reveal">
                <div class="trvl-vehicle-card-img">
                    <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=900&q=80" alt="Mobil ASR GO" loading="lazy">
                </div>
                <div class="trvl-vehicle-card-body">
                    <h3 class="trvl-vehicle-name">{{ $vehicleName }}</h3>
                    <div class="trvl-vehicle-specs">
                        <span class="trvl-vehicle-spec">👥 {{ $seatCapacity }} Kursi</span>
                        <span class="trvl-vehicle-spec">❄️ AC</span>
                    </div>
                    <div class="trvl-vehicle-price">Rp {{ number_format($price, 0, ',', '.') }} <span>/ hari</span></div>
                    <a href="{{ route('public.rental') }}" class="trvl-btn-pesan text-decoration-none">Sewa Sekarang</a>
                </div>
            </div>
            @empty
            <div class="trvl-vehicle-card trvl-reveal">
                <div class="trvl-vehicle-card-img" style="background:linear-gradient(135deg,#1d4ed8 0%,#2563eb 50%,#60a5fa 100%);">🚐</div>
                <div class="trvl-vehicle-card-body">
                    <h3 class="trvl-vehicle-name">Toyota Avanza</h3>
                    <div class="trvl-vehicle-specs"><span class="trvl-vehicle-spec">👥 6 Kursi</span><span class="trvl-vehicle-spec">❄️ AC</span></div>
                    <div class="trvl-vehicle-price">Rp 350.000 <span>/ hari</span></div>
                    <a href="{{ route('public.rental') }}" class="trvl-btn-pesan text-decoration-none">Sewa Sekarang</a>
                </div>
            </div>
            <div class="trvl-vehicle-card trvl-reveal trvl-reveal-delay-1">
                <div class="trvl-vehicle-card-img">
                    <img src="https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=900&q=80" alt="Toyota Innova ASR GO" loading="lazy">
                </div>
                <div class="trvl-vehicle-card-body">
                    <h3 class="trvl-vehicle-name">Toyota Innova</h3>
                    <div class="trvl-vehicle-specs"><span class="trvl-vehicle-spec">👥 7 Kursi</span><span class="trvl-vehicle-spec">❄️ AC</span></div>
                    <div class="trvl-vehicle-price">Rp 500.000 <span>/ hari</span></div>
                    <a href="{{ route('public.rental') }}" class="trvl-btn-pesan text-decoration-none">Sewa Sekarang</a>
                </div>
            </div>
            <div class="trvl-vehicle-card trvl-reveal trvl-reveal-delay-2">
                <div class="trvl-vehicle-card-img">
                    <img src="https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&w=900&q=80" alt="Toyota Hiace ASR GO" loading="lazy">
                </div>
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

<!-- ==================== FITUR APLIKASI ==================== -->
<section class="trvl-section" id="tampilan" style="background:#fff;">
    <div class="trvl-container">
        <div class="trvl-section-header-center mb-8 trvl-reveal">
            <span class="trvl-section-badge" style="background:#f0fdf4;color:#059669;border-color:#a7f3d0;">📱 Fitur Aplikasi</span>
            <h2 class="trvl-section-title" style="color:#0f172a;">Sistem Booking Online ASR GO</h2>
            <p class="trvl-section-desc">Kelola perjalanan dan pembayaran dalam satu platform terintegrasi.</p>
        </div>
        <div class="trvl-reveal">
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px;">
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;text-align:left;">
                    <div style="font-size:28px;margin-bottom:8px;">🚗</div>
                    <h4 style="font-weight:700;color:#0f172a;margin:0 0 6px 0;">Travel & Rental</h4>
                    <p style="color:#64748b;font-size:0.9rem;margin:0;">Pesan tiket travel antar kota atau rental mobil dengan/tanpa sopir secara online.</p>
                </div>
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;text-align:left;">
                    <div style="font-size:28px;margin-bottom:8px;">💳</div>
                    <h4 style="font-weight:700;color:#0f172a;margin:0 0 6px 0;">Pembayaran Mudah</h4>
                    <p style="color:#64748b;font-size:0.9rem;margin:0;">Midtransfer dengan berbagai metode pembayaran. Status pembayaran real-time.</p>
                </div>
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;text-align:left;">
                    <div style="font-size:28px;margin-bottom:8px;">📊</div>
                    <h4 style="font-weight:700;color:#0f172a;margin:0 0 6px 0;">Dashboard & Laporan</h4>
                    <p style="color:#64748b;font-size:0.9rem;margin:0;">Dashboard statistik untuk admin, driver, dan partner. Export PDF & Excel.</p>
                </div>
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;text-align:left;">
                    <div style="font-size:28px;margin-bottom:8px;">💰</div>
                    <h4 style="font-weight:700;color:#0f172a;margin:0 0 6px 0;">Revenue Sharing</h4>
                    <p style="color:#64748b;font-size:0.9rem;margin:0;">Bagi hasil otomatis 30/50/20 untuk admin, mitra, dan sopir.</p>
                </div>
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;text-align:left;">
                    <div style="font-size:28px;margin-bottom:8px;">🗺️</div>
                    <h4 style="font-weight:700;color:#0f172a;margin:0 0 6px 0;">Tracking Real-time</h4>
                    <p style="color:#64748b;font-size:0.9rem;margin:0;">Pantau lokasi armada dan status perjalanan secara real-time.</p>
                </div>
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;text-align:left;">
                    <div style="font-size:28px;margin-bottom:8px;">🎫</div>
                    <h4 style="font-weight:700;color:#0f172a;margin:0 0 6px 0;">Tiket & QR Code</h4>
                    <p style="color:#64748b;font-size:0.9rem;margin:0;">Dapatkan tiket digital dengan QR code untuk checkin.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== PERBANDINGAN ==================== -->
<section class="trvl-section" style="background:#f8fafc;">
    <div class="trvl-container">
        <div class="trvl-section-header-center mb-8 trvl-reveal">
            <span class="trvl-section-badge" style="background:#eff6ff;color:#2563eb;border-color:#bfdbfe;">📊 Perbandingan ASR GO</span>
            <h2 class="trvl-section-title">ASR GO vs Trac GO</h2>
            <p class="trvl-section-desc">Kami hadir dengan layanan yang lebih lokal, fleksibel, dan dekat dengan kebutuhan perjalanan di Flores.</p>
        </div>
        <div class="trvl-reveal overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-900 text-white">
                    <tr>
                        <th class="px-4 py-3">Fitur</th>
                        <th class="px-4 py-3">ASR GO</th>
                        <th class="px-4 py-3">Trac GO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100">
                        <td class="px-4 py-3 font-semibold">Layanan lokal</td>
                        <td class="px-4 py-3">Fokus ke Pulau Flores, sangat memahami rute dan kebutuhan pelanggan setempat.</td>
                        <td class="px-4 py-3">Lebih umum dan tidak selalu menyesuaikan kebutuhan wilayah lokal.</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="px-4 py-3 font-semibold">Ketersediaan armada</td>
                        <td class="px-4 py-3">Tersedia pilihan Avanza, Innova, Hiace, dan kendaraan rental yang siap dipakai.</td>
                        <td class="px-4 py-3">Biasanya lebih banyak opsi besar, namun kurang personal.</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="px-4 py-3 font-semibold">Kemudahan booking</td>
                        <td class="px-4 py-3">Booking cepat via WhatsApp, website, dan layanan customer support yang responsif.</td>
                        <td class="px-4 py-3">Mudah, tetapi sering lebih terstruktur dan kurang fleksibel untuk kebutuhan khusus.</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 font-semibold">Kelebihan utama</td>
                        <td class="px-4 py-3">Lebih dekat dengan pelanggan, harga transparan, dan pelayanan yang fleksibel untuk perjalanan daerah.</td>
                        <td class="px-4 py-3">Sudah terkenal secara luas, namun tidak selalu unggul dalam layanan personal.</td>
                    </tr>
                </tbody>
            </table>
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
                <a href="https://wa.me/6283156408078?text=Halo%20ASR%20GO%2C%20saya%20ingin%20bertanya%20tentang%20layanan" class="trvl-btn-cta-outline text-decoration-none">
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
                    <a href="https://wa.me/6283156408078?text=Halo%20ASR%20GO%2C%20saya%20ingin%20bertanya%20tentang%20layanan" class="trvl-footer-link">📱 WhatsApp: +62 831-5640-8078</a>
                    <a href="#" class="trvl-footer-link">📍 IzalhadjiTravel</a>
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
