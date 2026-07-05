@extends('layouts.public')

@section('title', __('nav.home'))

@section('content')
<!-- ==================== HERO ==================== -->
<section class="trvl-hero relative" id="layanan">
    <div class="trvl-hero-orb trvl-hero-orb-1"></div>
    <div class="trvl-hero-orb trvl-hero-orb-2"></div>

    <div class="trvl-container relative z-10 trvl-hero-content">
        <div class="text-center">
            <div class="trvl-hero-badge">
                <span class="pulse-dot"></span>
                {{ __('hero.badge') }}
            </div>
            <h1 class="trvl-hero-title">
                {!! __('hero.title') !!}
            </h1>
            <p class="trvl-hero-subtitle mx-auto">
                {{ __('hero.subtitle') }}
            </p>
        </div>

        <!-- Service Tabs -->
        <div class="trvl-service-tabs" id="service-tabs">
            <button class="trvl-service-tab active" onclick="switchTab('rental', this)" id="tab-rental">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                {{ __('services.tab_rental') }}
            </button>
            <button class="trvl-service-tab inactive" onclick="switchTab('travel', this)" id="tab-travel">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                {{ __('services.tab_travel') }}
            </button>
            <button class="trvl-service-tab inactive" onclick="switchTab('airport', this)" id="tab-airport">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0L7 10m5-5l5 5"/></svg>
                {{ __('services.tab_airport') }}
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
                                <p class="trvl-field-label" style="margin:0;">{{ __('booking.rental_title') }}</p>
                                <h2 class="text-base font-bold text-gray-900">{{ __('booking.rental_subtitle') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="trvl-booking-body">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="trvl-field-label">{{ __('booking.pickup_location') }}</label>
                                <input type="text" value="Ende" readonly class="trvl-form-field" aria-label="{{ __('booking.pickup_location') }}">
                            </div>
                            <div>
                                <label class="trvl-field-label">{{ __('booking.start_date') }}</label>
                                <input type="date" value="{{ date('Y-m-d') }}" class="trvl-form-field">
                            </div>
                            <div>
                                <label class="trvl-field-label">{{ __('booking.pickup_time') }}</label>
                                <input type="time" value="08:00" class="trvl-form-field">
                            </div>
                            <div>
                                <label class="trvl-field-label">{{ __('booking.duration') }}</label>
                                <select class="trvl-form-field">
                                    <option>{{ __('rental.duration_12h') }}</option>
                                    <option>{{ __('rental.duration_1d') }}</option>
                                    <option>{{ __('rental.duration_2d') }}</option>
                                    <option>{{ __('rental.duration_3d') }}</option>
                                    <option>{{ __('rental.duration_1w') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="trvl-info-panel flex items-center gap-2 flex-1">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span style="color:#1e40af; font-weight:500;">{{ __('booking.rental_info') }}</span>
                            </div>
                            <a href="{{ route('public.vehicles') }}" class="trvl-btn-search flex-shrink-0 text-decoration-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                {{ __('booking.search_vehicle') }}
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
                                <p class="trvl-field-label" style="margin:0;">{{ __('booking.travel_title') }}</p>
                                <h2 class="text-base font-bold text-gray-900">{{ __('booking.travel_subtitle') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="trvl-booking-body">
                        <div class="trvl-info-panel flex items-center gap-2">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span style="color:#1e40af; font-weight:500; font-size:0.875rem;">{{ __('booking.travel_info') }}</span>
                        </div>
                        <div class="mt-6 flex justify-center">
                            <a href="{{ route('public.travel') }}" class="trvl-btn-search text-decoration-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                {{ __('booking.view_routes') }}
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
                                <p class="trvl-field-label" style="margin:0;">{{ __('booking.airport_title') }}</p>
                                <h2 class="text-base font-bold text-gray-900">{{ __('booking.airport_subtitle') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="trvl-booking-body">
                        <div class="trvl-info-panel mb-4">
                            <div class="flex flex-wrap gap-x-6 gap-y-1 text-xs font-medium" style="color:#1e40af;">
                                <span>✅ {{ __('booking.airport_info_1') }}</span>
                                <span>✅ {{ __('booking.airport_info_2') }}</span>
                                <span>✅ {{ __('booking.airport_info_3') }}</span>
                                <span>✅ {{ __('booking.airport_info_4') }}</span>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <a href="https://wa.me/6283156408078?text=Halo%20ASR%20GO%2C%20saya%20ingin%20pesan%20airport%20transfer" class="trvl-btn-search text-decoration-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                {{ __('booking.book_airport') }}
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
            <p style="font-size:0.75rem; font-weight:600; color:#6c757d; text-transform:uppercase; letter-spacing:0.08em;">{{ __('home.trust_title') }}</p>
        </div>
        <div class="flex flex-wrap justify-center items-center gap-4 md:gap-6">
            <div class="trvl-trust-badge">{{ __('home.trust_kemenparekraf') }}</div>
            <div class="trvl-trust-badge">{{ __('home.trust_aman') }}</div>
            <div class="trvl-trust-badge">{{ __('home.trust_rating') }}</div>
            <div class="trvl-trust-badge">{{ __('home.trust_pelanggan') }}</div>
            <div class="trvl-trust-badge">{{ __('home.trust_24jam') }}</div>
        </div>
    </div>
</section>

<!-- ==================== STATS ==================== -->
<section class="trvl-stats-section" id="stats-section">
    <div class="trvl-container">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-0 trvl-stats-grid rounded-2xl shadow-sm overflow-hidden">
            <div class="trvl-stat-card trvl-stat-card-border">
                <p class="trvl-stat-number">10K+</p>
                <p class="trvl-stat-label">{{ __('home.stats_passengers') }}</p>
            </div>
            <div class="trvl-stat-card trvl-stat-card-border">
                <p class="trvl-stat-number">{{ count($travelRoutes ?? []) }}</p>
                <p class="trvl-stat-label">{{ __('home.stats_routes') }}</p>
            </div>
            <div class="trvl-stat-card trvl-stat-card-border">
                <p class="trvl-stat-number">6</p>
                <p class="trvl-stat-label">{{ __('home.stats_airports') }}</p>
            </div>
            <div class="trvl-stat-card">
                <p class="trvl-stat-number">98%</p>
                <p class="trvl-stat-label">{{ __('home.stats_ontime') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- ==================== MENGAPA PILIH ASR GO ==================== -->
<section class="trvl-section trvl-section-bg" id="keunggulan">
    <div class="trvl-container">
        <div class="trvl-section-header-center mb-12 trvl-reveal">
            <span class="trvl-section-badge">{{ __('home.features_badge') }}</span>
            <h2 class="trvl-section-title">{{ __('home.features_title') }}</h2>
            <p class="trvl-section-desc">{{ __('home.features_desc') }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="trvl-feature-card trvl-reveal trvl-reveal-delay-1">
                <div class="trvl-feature-icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
                <h3 class="trvl-feature-title">{{ __('home.feature_safe_title') }}</h3>
                <p class="trvl-feature-desc">{{ __('home.feature_safe_desc') }}</p>
            </div>
            <div class="trvl-feature-card trvl-reveal trvl-reveal-delay-2">
                <div class="trvl-feature-icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <h3 class="trvl-feature-title">{{ __('home.feature_price_title') }}</h3>
                <p class="trvl-feature-desc">{{ __('home.feature_price_desc') }}</p>
            </div>
            <div class="trvl-feature-card trvl-reveal trvl-reveal-delay-3">
                <div class="trvl-feature-icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <h3 class="trvl-feature-title">{{ __('home.feature_coverage_title') }}</h3>
                <p class="trvl-feature-desc">{{ __('home.feature_coverage_desc') }}</p>
            </div>
            <div class="trvl-feature-card trvl-reveal trvl-reveal-delay-1">
                <div class="trvl-feature-icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <h3 class="trvl-feature-title">{{ __('home.feature_ontime_title') }}</h3>
                <p class="trvl-feature-desc">{{ __('home.feature_ontime_desc') }}</p>
            </div>
            <div class="trvl-feature-card trvl-reveal trvl-reveal-delay-2">
                <div class="trvl-feature-icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg></div>
                <h3 class="trvl-feature-title">{{ __('home.feature_fleet_title') }}</h3>
                <p class="trvl-feature-desc">{{ __('home.feature_fleet_desc') }}</p>
            </div>
            <div class="trvl-feature-card trvl-reveal trvl-reveal-delay-3">
                <div class="trvl-feature-icon"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
                <h3 class="trvl-feature-title">{{ __('home.feature_24h_title') }}</h3>
                <p class="trvl-feature-desc">{{ __('home.feature_24h_desc') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- ==================== RUTE POPULER ==================== -->
<section class="trvl-section" id="rute">
    <div class="trvl-container">
        <div class="trvl-section-header-center mb-12 trvl-reveal">
            <span class="trvl-section-badge">{{ __('home.routes_badge') }}</span>
            <h2 class="trvl-section-title">{{ __('home.routes_title') }}</h2>
            <p class="trvl-section-desc">{{ __('home.routes_desc') }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse(($travelRoutes ?? []) as $route)
            @php
                $travelPrice = $route->travelPrices->first();
                $price = $travelPrice?->price_per_seat ?? $travelPrice?->price ?? 0;
                $duration = $route->estimated_hours ? number_format((float) $route->estimated_hours, 0) . ' jam' : 'Khusus';
                $distance = $route->distance_km ? number_format((float) $route->distance_km, 0) . ' km' : 'Tersedia';
                $routeImages = [
                    'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=600&q=80',
                    'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=600&q=80',
                    'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=600&q=80',
                    'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=600&q=80',
                    'https://images.unsplash.com/photo-1530789253388-582c4f0b2f1c?auto=format&fit=crop&w=600&q=80',
                    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=600&q=80',
                ];
                $routeImg = $routeImages[$loop->index % count($routeImages)];
            @endphp
            <div class="trvl-route-card trvl-reveal">
                <div class="trvl-route-card-img" style="overflow:hidden;">
                    <img src="{{ $routeImg }}" alt="{{ $route->origin_city }} - {{ $route->destination_city }}" style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s;" class="group-hover:scale-110">
                </div>
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
                    <div class="trvl-route-price">Rp {{ number_format($price, 0, ',', '.') }} <span>{{ __('home.routes_per_person') }}</span></div>
                    <a href="{{ route('public.travel') }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.routes_book') }}</a>
                </div>
            </div>
            @empty
            <div class="trvl-route-card trvl-reveal">
                <div class="trvl-route-card-img" style="overflow:hidden;">
                    <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=600&q=80" alt="Ende - Labuan Bajo" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div class="trvl-route-card-body">
                    <div class="trvl-route-origin-dest"><span class="trvl-route-city">Ende</span><span class="trvl-route-arrow">→</span><span class="trvl-route-city">Labuan Bajo</span></div>
                    <div class="trvl-route-meta"><span class="trvl-route-meta-item">⏱️ 8 jam</span><span class="trvl-route-meta-item">📍 350 km</span></div>
                    <div class="trvl-route-price">Rp 350.000 <span>{{ __('home.routes_per_person') }}</span></div>
                    <a href="{{ route('public.travel') }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.routes_book') }}</a>
                </div>
            </div>
            <div class="trvl-route-card trvl-reveal trvl-reveal-delay-1">
                <div class="trvl-route-card-img" style="overflow:hidden;">
                    <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=600&q=80" alt="Ende - Maumere" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div class="trvl-route-card-body">
                    <div class="trvl-route-origin-dest"><span class="trvl-route-city">Ende</span><span class="trvl-route-arrow">→</span><span class="trvl-route-city">Maumere</span></div>
                    <div class="trvl-route-meta"><span class="trvl-route-meta-item">⏱️ 5 jam</span><span class="trvl-route-meta-item">📍 200 km</span></div>
                    <div class="trvl-route-price">Rp 250.000 <span>{{ __('home.routes_per_person') }}</span></div>
                    <a href="{{ route('public.travel') }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.routes_book') }}</a>
                </div>
            </div>
            <div class="trvl-route-card trvl-reveal trvl-reveal-delay-2">
                <div class="trvl-route-card-img" style="overflow:hidden;">
                    <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=600&q=80" alt="Ende - Kelimutu" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div class="trvl-route-card-body">
                    <div class="trvl-route-origin-dest"><span class="trvl-route-city">Ende</span><span class="trvl-route-arrow">→</span><span class="trvl-route-city">Kelimutu</span></div>
                    <div class="trvl-route-meta"><span class="trvl-route-meta-item">⏱️ 3 jam</span><span class="trvl-route-meta-item">📍 100 km</span></div>
                    <div class="trvl-route-price">Rp 200.000 <span>{{ __('home.routes_per_person') }}</span></div>
                    <a href="{{ route('public.travel') }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.routes_book') }}</a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>


    <!-- ==================== DESTINASI WISATA FLORES ==================== -->
    <section class="trvl-section trvl-section-white-bg" id="destinasi">
        <div class="trvl-container">
            <div class="trvl-section-header-center mb-12 trvl-reveal">
                <span class="trvl-section-badge">{{ __('home.destinations_badge') }}</span>
                <h2 class="trvl-section-title">{{ __('home.destinations_title') }}</h2>
                <p class="trvl-section-desc">{{ __('home.destinations_desc') }}</p>
            </div>

            <!-- Featured: Danau Kelimutu -->
            <div class="trvl-reveal mb-8">
                <div class="rounded-2xl overflow-hidden shadow-xl relative group cursor-pointer">
                    <div class="aspect-video relative" style="max-height: 380px;">
                        <img src="https://images.unsplash.com/photo-1609137144813-7d9921338f24?w=1400&q=80" alt="Danau Kelimutu" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        <div class="absolute top-4 left-4">
                            <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-full">{{ __('home.destinations_featured_badge') }}</span>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <span class="text-white/70 text-sm">📍 Ende, NTT</span>
                            <h3 class="text-2xl font-bold text-white mt-1 mb-2">Danau Kelimutu</h3>
                            <p class="text-white/80 max-w-2xl">{{ __('home.destinations_kelimutu_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Destinasi Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <div class="trvl-reveal">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                            <div class="h-48 overflow-hidden relative">
                                <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=500&q=80" alt="Rumah Bung Karno" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                            </div>
                            <div class="trvl-route-card-body">
                                <span class="text-xs text-amber-600 font-medium">📍 Ende</span>
                            <h4 class="font-bold text-gray-900 mt-1">Rumah Bung Karno</h4>
                            <p class="text-gray-500 text-sm mt-1">Rumah tempat Bung Karno diasingkan 1934-1938. Kini menjadi museum bersejarah.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal trvl-reveal-delay-1">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1570789210967-2cac24afeb00?w=500&q=80" alt="Pulau Komodo" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-amber-600 font-medium">📍 Labuan Bajo</span>
                            <h4 class="font-bold text-gray-900 mt-1">Pulau Komodo</h4>
                            <p class="text-gray-500 text-sm mt-1">Habitat asli komodo, kadal terbesar di dunia. Warisan Alam UNESCO.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal trvl-reveal-delay-2">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=500&q=80" alt="Pink Beach" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-amber-600 font-medium">📍 Labuan Bajo</span>
                            <h4 class="font-bold text-gray-900 mt-1">Pink Beach</h4>
                            <p class="text-gray-500 text-sm mt-1">Salah satu dari 7 pantai berpasir merah muda di dunia.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1528181304800-259b08848526?w=500&q=80" alt="Wae Rebo" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-amber-600 font-medium">📍 Ruteng</span>
                            <h4 class="font-bold text-gray-900 mt-1">Desa Wae Rebo</h4>
                            <p class="text-gray-500 text-sm mt-1">Desa tradisional di atas awan 1.200 mdpl. Penghargaan UNESCO.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal trvl-reveal-delay-1">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=500&q=80" alt="Kampung Bena" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-amber-600 font-medium">📍 Bajawa</span>
                            <h4 class="font-bold text-gray-900 mt-1">Kampung Bena</h4>
                            <p class="text-gray-500 text-sm mt-1">Desa adat Ngada dengan megalit kuno dan rumah tradisional.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal trvl-reveal-delay-2">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=500&q=80" alt="Teluk Maumere" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-amber-600 font-medium">📍 Maumere</span>
                            <h4 class="font-bold text-gray-900 mt-1">Teluk Maumere</h4>
                            <p class="text-gray-500 text-sm mt-1">Surga diving dengan biodiversitas laut tertinggi di Indonesia Timur.</p>
                        </div>
                    </div>
                </div>

            </div>

<!-- Kota-kota di Flores -->
<div class="mt-16">
    <div class="trvl-section-header-center mb-8 trvl-reveal">
        <span class="trvl-section-badge" style="background:#fef3c7;color:#92400e;border-color:#fde68a;">{{ __('home.cities_badge') }}</span>
        <h2 class="trvl-section-title">{{ __('home.cities_title') }}</h2>
        <p class="trvl-section-desc">{{ __('home.cities_desc') }}</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Ende -->
        <div class="trvl-route-card group trvl-reveal">
            <div class="h-48 overflow-hidden relative">
                <img src="https://images.unsplash.com/photo-1609137144813-7d9921338f24?w=500&q=80" alt="Ende" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <h4 class="font-bold text-white text-lg">Ende</h4>
                    <p class="text-white/80 text-sm">{{ __('home.cities_ende_sub') }}</p>
                </div>
            </div>
            <div class="p-4">
                <p class="text-sm" style="color:var(--trvl-gray-600);">{{ __('home.cities_ende_desc') }}</p>
            </div>
        </div>
        <!-- Labuan Bajo -->
        <div class="trvl-route-card group trvl-reveal trvl-reveal-delay-1">
            <div class="h-48 overflow-hidden relative">
                <img src="https://images.unsplash.com/photo-1570789210967-2cac24afeb00?w=500&q=80" alt="Labuan Bajo" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <h4 class="font-bold text-white text-lg">Labuan Bajo</h4>
                    <p class="text-white/80 text-sm">{{ __('home.cities_labuanbajo_sub') }}</p>
                </div>
            </div>
            <div class="p-4">
                <p class="text-sm" style="color:var(--trvl-gray-600);">{{ __('home.cities_labuanbajo_desc') }}</p>
            </div>
        </div>
        <!-- Maumere -->
        <div class="trvl-route-card group trvl-reveal trvl-reveal-delay-2">
            <div class="h-48 overflow-hidden relative">
                <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=500&q=80" alt="Maumere" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <h4 class="font-bold text-white text-lg">Maumere</h4>
                    <p class="text-white/80 text-sm">{{ __('home.cities_maumere_sub') }}</p>
                </div>
            </div>
            <div class="p-4">
                <p class="text-sm" style="color:var(--trvl-gray-600);">{{ __('home.cities_maumere_desc') }}</p>
            </div>
        </div>
        <!-- Ruteng -->
        <div class="trvl-route-card group trvl-reveal">
            <div class="h-48 overflow-hidden relative">
                <img src="https://images.unsplash.com/photo-1528181304800-259b08848526?w=500&q=80" alt="Ruteng" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <h4 class="font-bold text-white text-lg">Ruteng</h4>
                    <p class="text-white/80 text-sm">{{ __('home.cities_ruteng_sub') }}</p>
                </div>
            </div>
            <div class="p-4">
                <p class="text-sm" style="color:var(--trvl-gray-600);">{{ __('home.cities_ruteng_desc') }}</p>
            </div>
        </div>
        <!-- Bajawa -->
        <div class="trvl-route-card group trvl-reveal trvl-reveal-delay-1">
            <div class="h-48 overflow-hidden relative">
                <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=500&q=80" alt="Bajawa" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <h4 class="font-bold text-white text-lg">Bajawa</h4>
                    <p class="text-white/80 text-sm">{{ __('home.cities_bajawa_sub') }}</p>
                </div>
            </div>
            <div class="p-4">
                <p class="text-sm" style="color:var(--trvl-gray-600);">{{ __('home.cities_bajawa_desc') }}</p>
            </div>
        </div>
        <!-- Larantuka -->
        <div class="trvl-route-card group trvl-reveal trvl-reveal-delay-2">
            <div class="h-48 overflow-hidden relative">
                <img src="https://images.unsplash.com/photo-1545569341-9eb8b30979d9?w=500&q=80" alt="Larantuka" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <h4 class="font-bold text-white text-lg">Larantuka</h4>
                    <p class="text-white/80 text-sm">{{ __('home.cities_larantuka_sub') }}</p>
                </div>
            </div>
            <div class="p-4">
                <p class="text-sm" style="color:var(--trvl-gray-600);">{{ __('home.cities_larantuka_desc') }}</p>
            </div>
        </div>
    </div>
</div>

            <!-- CTA -->
            <div class="text-center mt-10 trvl-reveal">
                <a href="{{ route('public.destinasi') }}" class="trvl-btn-primary inline-flex items-center gap-2">
                    {{ __('home.destinations_see_all') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ==================== KOTA DI FLORES ==================== -->
    <section class="trvl-section trvl-section-bg" id="kota">
        <div class="trvl-container">
            <div class="trvl-section-header-center mb-12 trvl-reveal">
                <span class="trvl-section-badge">🏙️ Kota di Flores</span>
                <h2 class="trvl-section-title">Jelajahi Kota-Kota Flores</h2>
                <p class="trvl-section-desc">Setiap kota di Flores memiliki cerita dan pesona tersendiri — dari pesisir hingga pegunungan.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <div class="trvl-reveal">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1563794146998-7245e6e5e9fb?w=500&q=80" alt="Ende" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-amber-600 font-medium">📍 Ende</span>
                            <h4 class="font-bold text-gray-900 mt-1">Ibu Kota Flores</h4>
                            <p class="text-gray-500 text-sm mt-1">Ibu kota Flores, pusat pemerintahan dan sejarah proklamasi — tempat Bung Karno diasingkan 1934-1938.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal trvl-reveal-delay-1">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1519722407087-d0f2c891224a?w=500&q=80" alt="Labuan Bajo" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-amber-600 font-medium">📍 Labuan Bajo</span>
                            <h4 class="font-bold text-gray-900 mt-1">Gerbang Komodo</h4>
                            <p class="text-gray-500 text-sm mt-1">Gerbang menuju Taman Nasional Komodo, destinasi wisata super prioritas dengan pemandangan sunset ikonik.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal trvl-reveal-delay-2">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=500&q=80" alt="Maumere" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-amber-600 font-medium">📍 Maumere</span>
                            <h4 class="font-bold text-gray-900 mt-1">Surga Diving</h4>
                            <p class="text-gray-500 text-sm mt-1">Surga diving dengan biodiversitas laut tertinggi di Indonesia Timur, spot snorkeling dan penyelaman kelas dunia.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&q=80" alt="Ruteng" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-amber-600 font-medium">📍 Ruteng</span>
                            <h4 class="font-bold text-gray-900 mt-1">Kota Dingin Pegunungan</h4>
                            <p class="text-gray-500 text-sm mt-1">Kota dingin dengan pemandangan perbukitan hijau dan gerbang menuju Desa Wae Rebo di atas awan.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal trvl-reveal-delay-1">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1566837945700-30057527ade0?w=500&q=80" alt="Bajawa" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-amber-600 font-medium">📍 Bajawa</span>
                            <h4 class="font-bold text-gray-900 mt-1">Kota Adat Megalit</h4>
                            <p class="text-gray-500 text-sm mt-1">Kota adat dengan megalit kuno dan rumah tradisional Ngada, kaya akan budaya dan pemandian air panas alami.</p>
                        </div>
                    </div>
                </div>

                <div class="trvl-reveal trvl-reveal-delay-2">
                    <div class="trvl-route-card group" style="overflow: hidden;">
                        <div class="h-48 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1559827291-baf8aa67db71?w=500&q=80" alt="Larantuka" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                        </div>
                        <div class="trvl-route-card-body">
                            <span class="text-xs text-amber-600 font-medium">📍 Larantuka</span>
                            <h4 class="font-bold text-gray-900 mt-1">Kota Tradisi Paskah</h4>
                            <p class="text-gray-500 text-sm mt-1">Kota dengan tradisi Paskah unik — Semana Santa — yang telah berlangsung selama ratusan tahun dan mendunia.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==================== ARMADA ==================== -->
<section class="trvl-section trvl-section-bg" id="armada">
    <div class="trvl-container">
        <div class="trvl-section-header-center mb-12 trvl-reveal">
            <span class="trvl-section-badge">{{ __('home.fleet_badge') }}</span>
            <h2 class="trvl-section-title">{{ __('home.fleet_title') }}</h2>
            <p class="trvl-section-desc">{{ __('home.fleet_desc') }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse(($rentalServices ?? []) as $service)
            @php
                $vehicleName = $service->route?->name ?: ($service->vehicle_type ?? 'Armada Premium');
                $seatCapacity = $service->route?->total_seats ?? 6;
                $price = $service->price_without_driver ?? $service->price_with_driver ?? 350000;
                $carImages = [
                    'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=900&q=80',
                ];
                $carImage = $carImages[$loop->index % count($carImages)];
            @endphp
            <div class="trvl-vehicle-card trvl-reveal">
                <div class="trvl-vehicle-card-img">
                    <img src="{{ $carImage }}" alt="{{ $vehicleName }} - ASR GO" loading="lazy">
                </div>
                <div class="trvl-vehicle-card-body">
                    <h3 class="trvl-vehicle-name">{{ $vehicleName }}</h3>
                    <div class="trvl-vehicle-specs">
                        <span class="trvl-vehicle-spec">👥 {{ $seatCapacity }} Kursi</span>
                        <span class="trvl-vehicle-spec">❄️ AC</span>
                    </div>
                    <div class="trvl-vehicle-price">Rp {{ number_format($price, 0, ',', '.') }} <span>{{ __('home.fleet_per_day') }}</span></div>
                    <a href="{{ route('public.rental') }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.fleet_book') }}</a>
                </div>
            </div>
            @empty
            <div class="trvl-vehicle-card trvl-reveal">
                <div class="trvl-vehicle-card-img" style="background:linear-gradient(135deg,#1d4ed8 0%,#2563eb 50%,#60a5fa 100%);">🚐</div>
                <div class="trvl-vehicle-card-body">
                    <h3 class="trvl-vehicle-name">Toyota Avanza</h3>
                    <div class="trvl-vehicle-specs"><span class="trvl-vehicle-spec">👥 6 Kursi</span><span class="trvl-vehicle-spec">❄️ AC</span></div>
                    <div class="trvl-vehicle-price">Rp 350.000 <span>{{ __('home.fleet_per_day') }}</span></div>
                    <a href="{{ route('public.rental') }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.fleet_book') }}</a>
                </div>
            </div>
            <div class="trvl-vehicle-card trvl-reveal trvl-reveal-delay-1">
                <div class="trvl-vehicle-card-img">
                    <img src="https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=900&q=80" alt="Toyota Innova ASR GO" loading="lazy">
                </div>
                <div class="trvl-vehicle-card-body">
                    <h3 class="trvl-vehicle-name">Toyota Innova</h3>
                    <div class="trvl-vehicle-specs"><span class="trvl-vehicle-spec">👥 7 Kursi</span><span class="trvl-vehicle-spec">❄️ AC</span></div>
                    <div class="trvl-vehicle-price">Rp 500.000 <span>{{ __('home.fleet_per_day') }}</span></div>
                    <a href="{{ route('public.rental') }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.fleet_book') }}</a>
                </div>
            </div>
            <div class="trvl-vehicle-card trvl-reveal trvl-reveal-delay-2">
                <div class="trvl-vehicle-card-img">
                    <img src="https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&w=900&q=80" alt="Toyota Hiace ASR GO" loading="lazy">
                </div>
                <div class="trvl-vehicle-card-body">
                    <h3 class="trvl-vehicle-name">Toyota Hiace</h3>
                    <div class="trvl-vehicle-specs"><span class="trvl-vehicle-spec">👥 12 Kursi</span><span class="trvl-vehicle-spec">❄️ AC</span></div>
                    <div class="trvl-vehicle-price">Rp 750.000 <span>{{ __('home.fleet_per_day') }}</span></div>
                    <a href="{{ route('public.rental') }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.fleet_book') }}</a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ==================== PERBANDINGAN DENGAN TRAC GO ==================== -->
<section class="trvl-section" id="perbandingan" style="background:var(--trvl-bg);">
    <div class="trvl-container">
        <div class="trvl-section-header-center mb-10 trvl-reveal">
            <span class="trvl-section-badge" style="background:#dbeafe;color:#0064d2;">{{ __('home.comparison_badge') }}</span>
            <h2 class="trvl-section-title">{{ __('home.comparison_title') }}</h2>
            <p class="trvl-section-desc">{{ __('home.comparison_desc') }}</p>
        </div>
        <div class="trvl-reveal" style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; border-radius:16px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.08);">
                <thead>
                    <tr style="background:#0064d2; color:white;">
                        <th style="padding:16px 20px; text-align:left; font-size:0.9rem;">{{ __('home.comparison_col_feature') }}</th>
                        <th style="padding:16px 20px; text-align:center; font-size:0.9rem; background:#004ba0;">{{ __('home.comparison_col_asr') }}</th>
                        <th style="padding:16px 20px; text-align:center; font-size:0.9rem;">{{ __('home.comparison_col_trac') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background:var(--trvl-card);">
                        <td style="padding:14px 20px; border-bottom:1px solid var(--trvl-border); font-weight:600; color:var(--trvl-gray-900);">{{ __('comparison.coverage') }}</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:var(--trvl-blue); font-weight:700;">Pulau Flores (lokal)</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:var(--trvl-gray-600);">Nasional (kota besar)</td>
                    </tr>
                    <tr style="background:var(--trvl-gray-100);">
                        <td style="padding:14px 20px; border-bottom:1px solid var(--trvl-border); font-weight:600; color:var(--trvl-gray-900);">{{ __('comparison.service_types') }}</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:var(--trvl-blue); font-weight:700;">Travel + Rental + Airport</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:var(--trvl-gray-600);">Rental Mobil saja</td>
                    </tr>
                    <tr style="background:var(--trvl-card);">
                        <td style="padding:14px 20px; border-bottom:1px solid var(--trvl-border); font-weight:600; color:var(--trvl-gray-900);">{{ __('comparison.book_online') }}</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#00a651; font-weight:700;">✅ Ya, website full-stack</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#00a651; font-weight:700;">✅ Ya</td>
                    </tr>
                    <tr style="background:var(--trvl-gray-100);">
                        <td style="padding:14px 20px; border-bottom:1px solid var(--trvl-border); font-weight:600; color:var(--trvl-gray-900);">{{ __('comparison.digital_payment') }}</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#00a651; font-weight:700;">✅ Midtrans (BCA, GoPay, dll)</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#00a651; font-weight:700;">✅ Ya</td>
                    </tr>
                    <tr style="background:var(--trvl-card);">
                        <td style="padding:14px 20px; border-bottom:1px solid var(--trvl-border); font-weight:600; color:var(--trvl-gray-900);">{{ __('comparison.tracking') }}</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#00a651; font-weight:700;">✅ GPS tracking armada</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#dc2626; font-weight:700;">❌ Tidak ada</td>
                    </tr>
                    <tr style="background:var(--trvl-gray-100);">
                        <td style="padding:14px 20px; border-bottom:1px solid var(--trvl-border); font-weight:600; color:var(--trvl-gray-900);">{{ __('comparison.revenue_sharing') }}</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#00a651; font-weight:700;">✅ 30/50/20 otomatis</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#dc2626; font-weight:700;">❌ Tidak ada</td>
                    </tr>
                    <tr style="background:var(--trvl-card);">
                        <td style="padding:14px 20px; border-bottom:1px solid var(--trvl-border); font-weight:600; color:var(--trvl-gray-900);">{{ __('comparison.without_driver') }}</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#00a651; font-weight:700;">✅ Ya</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#00a651; font-weight:700;">✅ Ya</td>
                    </tr>
                    <tr style="background:var(--trvl-gray-100);">
                        <td style="padding:14px 20px; border-bottom:1px solid var(--trvl-border); font-weight:600; color:var(--trvl-gray-900);">{{ __('comparison.with_driver') }}</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#00a651; font-weight:700;">✅ Driver lokal Flores</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#00a651; font-weight:700;">✅ Ya</td>
                    </tr>
                    <tr style="background:var(--trvl-card);">
                        <td style="padding:14px 20px; border-bottom:1px solid var(--trvl-border); font-weight:600; color:var(--trvl-gray-900);">{{ __('comparison.price') }}</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#00a651; font-weight:700;">✅ Mulai Rp 200rb/hari</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#dc2626; font-weight:700;">❌ Mulai Rp 400rb/hari</td>
                    </tr>
                    <tr style="background:var(--trvl-gray-100);">
                        <td style="padding:14px 20px; border-bottom:1px solid var(--trvl-border); font-weight:600; color:var(--trvl-gray-900);">{{ __('comparison.destinations') }}</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#00a651; font-weight:700;">✅ Kelimutu, Komodo, dll</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#dc2626; font-weight:700;">❌ Fokus perkotaan</td>
                    </tr>
                    <tr style="background:var(--trvl-card);">
                        <td style="padding:14px 20px; border-bottom:1px solid var(--trvl-border); font-weight:600; color:var(--trvl-gray-900);">{{ __('comparison.whatsapp') }}</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#00a651; font-weight:700;">✅ CS 24 jam</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:1px solid var(--trvl-border); color:#00a651; font-weight:700;">✅ Ya</td>
                    </tr>
                    <tr style="background:var(--trvl-gray-100);">
                        <td style="padding:14px 20px; border-bottom:0; font-weight:600; color:var(--trvl-gray-900);">{{ __('comparison.insurance') }}</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:0; color:#00a651; font-weight:700;">✅ Termasuk</td>
                        <td style="padding:14px 20px; text-align:center; border-bottom:0; color:#00a651; font-weight:700;">✅ Termasuk</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-6 trvl-reveal">
            <p style="font-size:0.85rem; color:var(--trvl-gray-600);">{{ __('home.comparison_footnote') }}</p>
        </div>
    </div>
</section>

<!-- ==================== PERBANDINGAN ==================== -->
<section class="trvl-section trvl-section-bg" id="perbandingan">
    <div class="trvl-container">
        <div class="trvl-section-header-center mb-12 trvl-reveal">
            <span class="trvl-section-badge">⚖️ {{ __('comparison.title') }}</span>
            <h2 class="trvl-section-title">{{ __('comparison.title') }}</h2>
            <p class="trvl-section-desc">{{ __('comparison.desc') }}</p>
        </div>
        <div class="trvl-reveal" style="overflow-x:auto;">
            <table class="trvl-comparison-table">
                <thead>
                    <tr>
                        <th>{{ __('comparison.col_feature') }}</th>
                        <th class="th-asr">
                            <span class="table-brand">{{ __('comparison.col_asr') }}</span>
                            <span class="table-brand-sub">{{ __('comparison.asr_sub') }}</span>
                        </th>
                        <th class="th-trac">
                            <span class="table-brand">{{ __('comparison.col_trac') }}</span>
                            <span class="table-brand-sub">{{ __('comparison.trac_sub') }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="tr-highlight">
                        <td class="td-label">{{ __('comparison.coverage') }}</td>
                        <td class="td-asr">📍 Pulau Flores (lokal)</td>
                        <td class="td-trac">🏙️ Nasional (kota besar)</td>
                    </tr>
                    <tr>
                        <td class="td-label">{{ __('comparison.service_types') }}</td>
                        <td class="td-asr">✅ Travel + Rental + Airport</td>
                        <td class="td-trac">❌ Rental Mobil saja</td>
                    </tr>
                    <tr class="tr-highlight">
                        <td class="td-label">{{ __('comparison.book_online') }}</td>
                        <td class="td-asr">✅ Ya, website full-stack</td>
                        <td class="td-trac">✅ Ya</td>
                    </tr>
                    <tr>
                        <td class="td-label">{{ __('comparison.digital_payment') }}</td>
                        <td class="td-asr">✅ Midtrans (BCA, GoPay, dll)</td>
                        <td class="td-trac">✅ Ya</td>
                    </tr>
                    <tr class="tr-highlight">
                        <td class="td-label">{{ __('comparison.tracking') }}</td>
                        <td class="td-asr">✅ GPS tracking armada</td>
                        <td class="td-trac">❌ Tidak</td>
                    </tr>
                    <tr>
                        <td class="td-label">{{ __('comparison.revenue_sharing') }}</td>
                        <td class="td-asr">✅ 30/50/20 otomatis</td>
                        <td class="td-trac">❌ Tidak (sewa langsung)</td>
                    </tr>
                    <tr class="tr-highlight">
                        <td class="td-label">{{ __('comparison.without_driver') }}</td>
                        <td class="td-asr">✅ Ya</td>
                        <td class="td-trac">✅ Ya</td>
                    </tr>
                    <tr>
                        <td class="td-label">{{ __('comparison.with_driver') }}</td>
                        <td class="td-asr">✅ Ya, driver lokal Flores</td>
                        <td class="td-trac">✅ Ya</td>
                    </tr>
                    <tr class="tr-highlight">
                        <td class="td-label">{{ __('comparison.price') }}</td>
                        <td class="td-asr">✅ Lebih terjangkau (mulai Rp200rb)</td>
                        <td class="td-trac">❌ Lebih mahal (mulai Rp400rb)</td>
                    </tr>
                    <tr>
                        <td class="td-label">{{ __('comparison.destinations') }}</td>
                        <td class="td-asr">✅ Danau Kelimutu, Komodo, Pink Beach, dll</td>
                        <td class="td-trac">❌ Fokus perkotaan</td>
                    </tr>
                    <tr class="tr-highlight">
                        <td class="td-label">{{ __('comparison.whatsapp') }}</td>
                        <td class="td-asr">✅ CS 24 jam via WhatsApp</td>
                        <td class="td-trac">✅ Ya</td>
                    </tr>
                    <tr>
                        <td class="td-label">{{ __('comparison.insurance') }}</td>
                        <td class="td-asr">✅ Termasuk</td>
                        <td class="td-trac">✅ Termasuk</td>
                    </tr>
                    <tr class="tr-highlight">
                        <td class="td-label">{{ __('comparison.airport_service') }}</td>
                        <td class="td-asr">✅ 6 Bandara di Flores</td>
                        <td class="td-trac">❌ Terbatas</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-8 trvl-reveal">
            <p style="color:#64748b; font-size:0.9rem;">
                {!! __('home.comparison_conclusion') !!}
            </p>
        </div>
    </div>
</section>

<!-- ==================== CTA ==================== -->
<section class="trvl-cta-section py-20">
    <div class="trvl-container relative z-10">
        <div class="text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">{{ __('cta.section_title') }}</h2>
            <p style="color:rgba(191,219,254,0.9); margin-bottom:2rem; max-width:32rem; margin-left:auto; margin-right:auto;">{{ __('cta.section_desc') }}</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#layanan" class="trvl-btn-cta-white text-decoration-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    {{ __('cta.book') }}
                </a>
                <a href="https://wa.me/6283156408078?text=Halo%20ASR%20GO%2C%20saya%20ingin%20bertanya%20tentang%20layanan" class="trvl-btn-cta-outline text-decoration-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ __('cta.contact') }}
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
                <p class="text-sm" style="color:#64748b;">{{ __('footer.company_desc') }}</p>
            </div>
            <div>
                <p class="trvl-footer-heading">{{ __('footer.information_heading') }}</p>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('public.blog') }}" class="trvl-footer-link">{{ __('footer.blog') }}</a>
                    <a href="{{ route('public.destinasi') }}" class="trvl-footer-link">{{ __('footer.destinations') }}</a>
                    <a href="{{ route('public.travel') }}" class="trvl-footer-link">{{ __('footer.travel') }}</a>
                </div>
            </div>
            <div>
                <p class="trvl-footer-heading">{{ __('footer.company_heading') }}</p>
                <div class="flex flex-col gap-2">
                    <a href="#" class="trvl-footer-link">{{ __('footer.about') }}</a>
                    <a href="#" class="trvl-footer-link">{{ __('footer.terms') }}</a>
                    <a href="#" class="trvl-footer-link">{{ __('footer.privacy') }}</a>
                </div>
            </div>
            <div>
                <p class="trvl-footer-heading">{{ __('footer.contact_heading') }}</p>
                <div class="flex flex-col gap-2">
                    <a href="https://wa.me/6283156408078?text=Halo%20ASR%20GO%2C%20saya%20ingin%20bertanya%20tentang%20layanan" class="trvl-footer-link">{{ __('footer.whatsapp') }}</a>
                    <a href="#" class="trvl-footer-link">{{ __('footer.location') }}</a>
                    <a href="#" class="trvl-footer-link">{{ __('footer.email') }}</a>
                </div>
            </div>
        </div>
        <div style="border-top:1px solid #1e293b; margin-top:2rem; padding-top:2rem; text-align:center;">
            <p class="text-sm" style="color:#64748b;">{{ __('footer.copyright') }}</p>
        </div>
    </div>
</footer>
<style>
.dark .trvl-stats-section { background: var(--trvl-bg) !important; }
.dark .trvl-stats-section .trvl-stat-card { background: var(--trvl-card) !important; }
.dark .trvl-stats-section .trvl-stat-number { color: var(--trvl-gray-800); }
.dark .trvl-stats-section .trvl-stat-label { color: var(--trvl-gray-600); }
.dark .trvl-stats-section [style*="background:white"] { background: var(--trvl-card) !important; }
.dark .trvl-stats-section [style*="background-color:white"] { background-color: var(--trvl-card) !important; }
.dark .trvl-stats-section [style*="border-color:#e9ecef"] { border-color: var(--trvl-border) !important; }
.dark .trvl-stats-section [style*="border-color: #e9ecef"] { border-color: var(--trvl-border) !important; }
.dark .trvl-stats-section [style*="border-right:1px solid #e9ecef"] { border-right-color: var(--trvl-border) !important; }
</style>
@endsection
