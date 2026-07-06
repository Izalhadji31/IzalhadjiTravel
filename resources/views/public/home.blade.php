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

        <!-- Service Cards -->
        <div class="max-w-5xl mx-auto mt-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Rental Card -->
                <a href="{{ route('public.vehicles') }}" class="block p-5 rounded-2xl transition-all duration-300 hover:-translate-y-1" style="background:white; border:none; box-shadow:0 4px 20px rgba(0,0,0,0.15);">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3" style="background:#e8f4fd;">
                        <svg class="w-5 h-5" fill="none" stroke="#0064d2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                    <h3 class="font-bold text-base mb-1" style="color:#1a1a2e;">{{ __('services.tab_rental') }}</h3>
                    <p class="text-sm" style="color:#6c757d;">Mobil Avanza, Innova, Hiace — lepas kunci atau dengan sopir</p>
                </a>
                <!-- Travel Card -->
                <a href="{{ route('public.travel') }}" class="block p-5 rounded-2xl transition-all duration-300 hover:-translate-y-1" style="background:white; border:none; box-shadow:0 4px 20px rgba(0,0,0,0.15);">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3" style="background:#cffafe;">
                        <svg class="w-5 h-5" fill="none" stroke="#0e7490" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </div>
                    <h3 class="font-bold text-base mb-1" style="color:#1a1a2e;">{{ __('services.tab_travel') }}</h3>
                    <p class="text-sm" style="color:#6c757d;">Rute Ende-Mbay, Ende-Bajawa, Ende-Maumere, dan lainnya</p>
                </a>
                <!-- Airport Card -->
                <a href="{{ route('public.airport') }}" class="block p-5 rounded-2xl transition-all duration-300 hover:-translate-y-1" style="background:white; border:none; box-shadow:0 4px 20px rgba(0,0,0,0.15);">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3" style="background:#fed7aa;">
                        <svg class="w-5 h-5" fill="none" stroke="#d97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0L7 10m5-5l5 5"/></svg>
                    </div>
                    <h3 class="font-bold text-base mb-1" style="color:#1a1a2e;">{{ __('services.tab_airport') }}</h3>
                    <p class="text-sm" style="color:#6c757d;">Agya Rp30rb, Avanza Rp50rb, Innova Rp100rb, Hiace Rp150rb — tergantung mobil</p>
                </a>
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
                $kabupatenIcons = [
                    'ende' => ['initial' => 'E', 'gradient' => 'linear-gradient(135deg,#1e40af 0%,#3b82f6 50%,#93c5fd 100%)'],
                    'labuan bajo' => ['initial' => 'LB', 'gradient' => 'linear-gradient(135deg,#065f46 0%,#10b981 50%,#6ee7b7 100%)'],
                    'maumere' => ['initial' => 'M', 'gradient' => 'linear-gradient(135deg,#0e7490 0%,#06b6d4 50%,#67e8f9 100%)'],
                    'ruteng' => ['initial' => 'R', 'gradient' => 'linear-gradient(135deg,#854d0e 0%,#eab308 50%,#fde047 100%)'],
                    'bajawa' => ['initial' => 'B', 'gradient' => 'linear-gradient(135deg,#7c2d12 0%,#d97706 50%,#fbbf24 100%)'],
                    'larantuka' => ['initial' => 'L', 'gradient' => 'linear-gradient(135deg,#831843 0%,#db2777 50%,#f472b6 100%)'],
                    'borong' => ['initial' => 'BR', 'gradient' => 'linear-gradient(135deg,#451a03 0%,#9a3412 50%,#ea580c 100%)'],
                    'default' => ['initial' => 'E', 'gradient' => 'linear-gradient(135deg,#0f766e 0%,#14b8a6 50%,#5eead4 100%)'],
                ];
                $originKey = strtolower($route->origin_city ?? '');
                $iconData = $kabupatenIcons[$originKey] ?? $kabupatenIcons['default'];
            @endphp
            <div class="trvl-route-card trvl-reveal">
                <div class="trvl-route-card-img" style="background:{{ $iconData['gradient'] }}; display:flex; align-items:center; justify-content:center;">
                    <span style="font-size:2.8rem; font-weight:800; color:rgba(255,255,255,0.25); letter-spacing:-2px; line-height:1;">{{ $iconData['initial'] }}</span>
                </div>
                <div class="trvl-route-card-body">
                    <div class="trvl-route-origin-dest">
                        <span class="trvl-route-city">{{ $route->origin_city ?? 'Ende' }}</span>
                        <span class="trvl-route-arrow">→</span>
                        <span class="trvl-route-city">{{ $route->destination_city ?? 'Labuan Bajo' }}</span>
                    </div>
                    <div class="trvl-route-meta">
                        <span class="trvl-route-meta-item">{{ __('general.duration') }}: {{ $duration }}</span>
                        <span class="trvl-route-meta-item">{{ __('general.distance') }}: {{ $distance }}</span>
                    </div>
                    <div class="trvl-route-price">Rp {{ number_format($price, 0, ',', '.') }} <span>{{ __('home.routes_per_person') }}</span></div>
                    <a href="{{ route('public.travel') }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.routes_book') }}</a>
                </div>
            </div>
            @empty
            <div class="trvl-route-card trvl-reveal">
                <div class="trvl-route-card-img" style="background:linear-gradient(135deg,#065f46 0%,#10b981 50%,#6ee7b7 100%); display:flex; align-items:center; justify-content:center;">
                    <span style="font-size:2.8rem; font-weight:800; color:rgba(255,255,255,0.25); letter-spacing:-2px; line-height:1;">E</span>
                </div>
                <div class="trvl-route-card-body">
                    <div class="trvl-route-origin-dest"><span class="trvl-route-city">Ende</span><span class="trvl-route-arrow">→</span><span class="trvl-route-city">Labuan Bajo</span></div>
                    <div class="trvl-route-meta"><span class="trvl-route-meta-item">{{ __('general.duration') }}: 8 jam</span><span class="trvl-route-meta-item">{{ __('general.distance') }}: 350 km</span></div>
                    <div class="trvl-route-price">Rp 350.000 <span>{{ __('home.routes_per_person') }}</span></div>
                    <a href="{{ route('public.travel') }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.routes_book') }}</a>
                </div>
            </div>
            <div class="trvl-route-card trvl-reveal trvl-reveal-delay-1">
                <div class="trvl-route-card-img" style="background:linear-gradient(135deg,#0e7490 0%,#06b6d4 50%,#67e8f9 100%); display:flex; align-items:center; justify-content:center;">
                    <span style="font-size:2.8rem; font-weight:800; color:rgba(255,255,255,0.25); letter-spacing:-2px; line-height:1;">E</span>
                </div>
                <div class="trvl-route-card-body">
                    <div class="trvl-route-origin-dest"><span class="trvl-route-city">Ende</span><span class="trvl-route-arrow">→</span><span class="trvl-route-city">Maumere</span></div>
                    <div class="trvl-route-meta"><span class="trvl-route-meta-item">{{ __('general.duration') }}: 5 jam</span><span class="trvl-route-meta-item">{{ __('general.distance') }}: 200 km</span></div>
                    <div class="trvl-route-price">Rp 250.000 <span>{{ __('home.routes_per_person') }}</span></div>
                    <a href="{{ route('public.travel') }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.routes_book') }}</a>
                </div>
            </div>
            <div class="trvl-route-card trvl-reveal trvl-reveal-delay-2">
                <div class="trvl-route-card-img" style="background:linear-gradient(135deg,#451a03 0%,#9a3412 50%,#ea580c 100%); display:flex; align-items:center; justify-content:center;">
                    <span style="font-size:2.8rem; font-weight:800; color:rgba(255,255,255,0.25); letter-spacing:-2px; line-height:1;">E</span>
                </div>
                <div class="trvl-route-card-body">
                    <div class="trvl-route-origin-dest"><span class="trvl-route-city">Ende</span><span class="trvl-route-arrow">→</span><span class="trvl-route-city">Kelimutu</span></div>
                    <div class="trvl-route-meta"><span class="trvl-route-meta-item">{{ __('general.duration') }}: 3 jam</span><span class="trvl-route-meta-item">{{ __('general.distance') }}: 100 km</span></div>
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

            <!-- Cities as Destination Containers -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Ende -->
                <div class="trvl-route-card group trvl-reveal">
                    <div class="h-56 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1563794146998-7245e6e5e9fb?w=500&q=80" alt="Ende" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h4 class="font-bold text-white text-lg">Ende</h4>
                            <p class="text-white/80 text-sm">Kota Pancasila</p>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Danau Kelimutu</p>
                            <p class="text-xs text-gray-500">Danau 3 warna, ikon Flores</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Rumah Bung Karno</p>
                            <p class="text-xs text-gray-500">Museum pengasingan Bung Karno 1934-1938</p>
                        </div>
                    </div>
                </div>

                <!-- Labuan Bajo -->
                <div class="trvl-route-card group trvl-reveal trvl-reveal-delay-1">
                    <div class="h-56 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1519722407087-d0f2c891224a?w=500&q=80" alt="Labuan Bajo" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h4 class="font-bold text-white text-lg">Labuan Bajo</h4>
                            <p class="text-white/80 text-sm">Gerbang Komodo</p>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Pulau Komodo</p>
                            <p class="text-xs text-gray-500">Habitat asli komodo, Warisan UNESCO</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Pink Beach</p>
                            <p class="text-xs text-gray-500">1 dari 7 pantai pink di dunia</p>
                        </div>
                    </div>
                </div>

                <!-- Maumere -->
                <div class="trvl-route-card group trvl-reveal trvl-reveal-delay-2">
                    <div class="h-56 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=500&q=80" alt="Maumere" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h4 class="font-bold text-white text-lg">Maumere</h4>
                            <p class="text-white/80 text-sm">Surga Bawah Laut</p>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Teluk Maumere</p>
                            <p class="text-xs text-gray-500">Spot diving kelas dunia</p>
                        </div>
                    </div>
                </div>

                <!-- Ruteng -->
                <div class="trvl-route-card group trvl-reveal">
                    <div class="h-56 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&q=80" alt="Ruteng" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h4 class="font-bold text-white text-lg">Ruteng</h4>
                            <p class="text-white/80 text-sm">Kota Dingin</p>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Desa Wae Rebo</p>
                            <p class="text-xs text-gray-500">Desa di atas awan, 1.200 mdpl</p>
                        </div>
                    </div>
                </div>

                <!-- Bajawa -->
                <div class="trvl-route-card group trvl-reveal trvl-reveal-delay-1">
                    <div class="h-56 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1566837945700-30057527ade0?w=500&q=80" alt="Bajawa" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h4 class="font-bold text-white text-lg">Bajawa</h4>
                            <p class="text-white/80 text-sm">Kota Adat</p>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Kampung Bena</p>
                            <p class="text-xs text-gray-500">Desa adat Ngada dengan megalit kuno</p>
                        </div>
                    </div>
                </div>

                <!-- Larantuka -->
                <div class="trvl-route-card group trvl-reveal trvl-reveal-delay-2">
                    <div class="h-56 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1545569341-9eb8b30979d9?w=500&q=80" alt="Larantuka" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h4 class="font-bold text-white text-lg">Larantuka</h4>
                            <p class="text-white/80 text-sm">Kota Tradisi</p>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Semana Santa</p>
                            <p class="text-xs text-gray-500">Tradisi Paskah berusia ratusan tahun</p>
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

    <!-- ==================== ARMADA ==================== -->
<section class="trvl-section trvl-section-bg" id="armada">
    <div class="trvl-container">
        <div class="trvl-section-header-center mb-12 trvl-reveal">
            <span class="trvl-section-badge">{{ __('home.fleet_badge') }}</span>
            <h2 class="trvl-section-title">{{ __('home.fleet_title') }}</h2>
            <p class="trvl-section-desc">{{ __('home.fleet_desc') }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $armada = [
                    ['nama' => 'Toyota Avanza', 'kursi' => 6, 'transmisi' => 'Manual', 'harga' => 350000, 'plat' => 'EB 1234 AB', 'img' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Rush', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 450000, 'plat' => 'EB 5678 CD', 'img' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Hiace', 'kursi' => 12, 'transmisi' => 'Manual', 'harga' => 750000, 'plat' => 'EB 9012 EF', 'img' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Innova', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 500000, 'plat' => 'EB 3456 GH', 'img' => 'https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Honda Brio', 'kursi' => 4, 'transmisi' => 'Manual', 'harga' => 250000, 'plat' => 'EB 7890 IJ', 'img' => 'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Honda Mobilio', 'kursi' => 6, 'transmisi' => 'Manual', 'harga' => 350000, 'plat' => 'EB 2345 KL', 'img' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Daihatsu Grand Max', 'kursi' => 8, 'transmisi' => 'Manual', 'harga' => 400000, 'plat' => 'EB 6789 MN', 'img' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Hilux', 'kursi' => 4, 'transmisi' => 'Manual', 'harga' => 600000, 'plat' => 'EB 0123 OP', 'img' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Daihatsu Terios', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 400000, 'plat' => 'EB 1122 QR', 'img' => 'https://images.unsplash.com/photo-1543465077-db45b34b70a4?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Suzuki Ertiga', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 350000, 'plat' => 'EB 3344 ST', 'img' => 'https://images.unsplash.com/photo-1550355291-bedd4e5a8e4c?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Mitsubishi Xpander', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 450000, 'plat' => 'EB 5566 UV', 'img' => 'https://images.unsplash.com/photo-1568844293986-8d0400bd4745?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Suzuki Carry', 'kursi' => 2, 'transmisi' => 'Manual', 'harga' => 200000, 'plat' => 'EB 7788 WX', 'img' => 'https://images.unsplash.com/photo-1583267746897-2cf415887172?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Fortuner', 'kursi' => 7, 'transmisi' => 'Automatic', 'harga' => 1000000, 'plat' => 'EB 9900 YZ', 'img' => 'https://images.unsplash.com/photo-1550353127-b0da98aeaa0e?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Honda HR-V', 'kursi' => 5, 'transmisi' => 'Automatic', 'harga' => 700000, 'plat' => 'EB 1112 AB', 'img' => 'https://images.unsplash.com/photo-1568844293986-8d0400bd4745?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Mitsubishi Pajero Sport', 'kursi' => 7, 'transmisi' => 'Automatic', 'harga' => 1200000, 'plat' => 'EB 1314 CD', 'img' => 'https://images.unsplash.com/photo-1550353127-b0da98aeaa0e?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Calya', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 300000, 'plat' => 'EB 1516 EF', 'img' => 'https://images.unsplash.com/photo-1543465077-db45b34b70a4?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Daihatsu Sigra', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 300000, 'plat' => 'EB 1718 GH', 'img' => 'https://images.unsplash.com/photo-1550355291-bedd4e5a8e4c?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Agya', 'kursi' => 4, 'transmisi' => 'Manual', 'harga' => 200000, 'plat' => 'EB 1920 IJ', 'img' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Nissan Livina', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 400000, 'plat' => 'EB 2122 KL', 'img' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Isuzu Elf', 'kursi' => 15, 'transmisi' => 'Manual', 'harga' => 900000, 'plat' => 'EB 2324 MN', 'img' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&w=900&q=80'],
                ];
                $showAll = request()->has('show_all');
                $displayArmada = $showAll ? $armada : array_slice($armada, 0, 3);
            @endphp
            @foreach($displayArmada as $kendaraan)
            <div class="trvl-vehicle-card trvl-reveal @if($loop->index > 0) trvl-reveal-delay-{{ min($loop->index, 3) }} @endif">
                <div class="trvl-vehicle-card-img">
                    <img src="{{ $kendaraan['img'] }}" alt="{{ $kendaraan['nama'] }}" loading="lazy">
                </div>
                <div class="trvl-vehicle-card-body">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="trvl-vehicle-name" style="margin:0;">{{ $kendaraan['nama'] }}</h3>
                        <span class="text-[0.55rem] font-semibold px-2 py-0.5 rounded-full" style="background:#e8f4fd; color:#0064d2;">{{ $kendaraan['transmisi'] }}</span>
                    </div>
                    <p class="text-xs" style="color:#6c757d; margin-bottom:0.5rem;">{{ $kendaraan['plat'] }}</p>
                    <div class="trvl-vehicle-specs">
                        <span class="trvl-vehicle-spec">{{ $kendaraan['kursi'] }} Kursi</span>
                        <span class="trvl-vehicle-spec">AC</span>
                    </div>
                    <div class="trvl-vehicle-price">Rp {{ number_format($kendaraan['harga'], 0, ',', '.') }} <span>/hari</span></div>
                    <a href="{{ route('public.rental') }}" class="trvl-btn-pesan text-decoration-none">Sewa Sekarang</a>
                </div>
            </div>
            @endforeach
        </div>

        @if(!$showAll)
        <div class="text-center mt-8">
            <a href="{{ route('public.rental') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 hover:-translate-y-0.5" style="background:#0064d2; color:white; box-shadow:0 4px 14px rgba(0,100,210,0.3);">
                Lihat Semua Armada (20 Mobil)
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>
        @endif
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

@section('page-footer')
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
@endsection
