@extends('layouts.public')

@section('title', __('nav.home'))

@section('content')
<!-- ==================== HERO ==================== -->
<section class="trvl-hero relative" id="layanan">
    <div class="trvl-hero-orb trvl-hero-orb-1"></div>
    <div class="trvl-hero-orb trvl-hero-orb-2"></div>

    <div class="trvl-container relative z-10 trvl-hero-content">
        <div class="text-center">
            <div class="trvl-hero-badge mt-8 md:mt-12">
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

        <!-- TRACtoGO-style Tabbed Booking Widget -->
        <div class="max-w-5xl mx-auto mt-8 relative z-20">
            <!-- Tabs Header -->
            <div class="flex space-x-2 bg-black/20 p-1.5 rounded-t-2xl max-w-fit mx-auto md:mx-0">
                <button type="button" onclick="switchHomeTab('travel', this)" class="home-tab-btn flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm text-white transition-all duration-300 bg-blue-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    {{ __('home.travel_card_title') }}
                </button>
                <button type="button" onclick="switchHomeTab('rental', this)" class="home-tab-btn flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm text-white/80 transition-all duration-300 hover:bg-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    {{ __('home.rental_card_title') }}
                </button>
                <button type="button" onclick="switchHomeTab('airport', this)" class="home-tab-btn flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm text-white/80 transition-all duration-300 hover:bg-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0L7 10m5-5l5 5"/></svg>
                    {{ __('home.airport_card_title') }}
                </button>
            </div>

            <!-- Tabs Body -->
            <div class="bg-white dark:bg-slate-900 rounded-b-2xl rounded-tr-2xl p-6 shadow-2xl border border-gray-100 dark:border-slate-800 text-left">
                <!-- Travel Tab Panel -->
                <div id="home-panel-travel" class="home-panel">
                    <form method="GET" action="{{ route('public.travel') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('travel.from') }}</label>
                                <select name="origin" class="w-full p-3 border border-gray-200 dark:border-slate-700 rounded-xl bg-gray-50 dark:bg-slate-800 dark:text-white text-sm outline-none focus:border-blue-500">
                                    <option value="">{{ __('travel.origin_placeholder') }}</option>
                                    @foreach($origins as $origin)
                                        <option value="{{ $origin }}">{{ $origin }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('travel.to') }}</label>
                                <select name="destination" class="w-full p-3 border border-gray-200 dark:border-slate-700 rounded-xl bg-gray-50 dark:bg-slate-800 dark:text-white text-sm outline-none focus:border-blue-500">
                                    <option value="">{{ __('travel.destination_placeholder') }}</option>
                                    @foreach($destinations as $destination)
                                        <option value="{{ $destination }}">{{ $destination }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('travel.date') }}</label>
                                <input type="date" name="date" class="w-full p-3 border border-gray-200 dark:border-slate-700 rounded-xl bg-gray-50 dark:bg-slate-800 dark:text-white text-sm outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20 border-none cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                                    {{ __('travel.search') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Rental Tab Panel -->
                <div id="home-panel-rental" class="home-panel hidden">
                    <form method="GET" action="{{ route('public.rental') }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('rental.vehicle_type') }}</label>
                                <select name="vehicle_type" class="w-full p-3 border border-gray-200 dark:border-slate-700 rounded-xl bg-gray-50 dark:bg-slate-800 dark:text-white text-sm outline-none focus:border-blue-500">
                                    <option value="">{{ __('rental.vehicle_type_all') }}</option>
                                    @foreach($vehicleTypes as $type)
                                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('rental.min_seats') }}</label>
                                <input type="number" name="min_capacity" placeholder="Contoh: 6" class="w-full p-3 border border-gray-200 dark:border-slate-700 rounded-xl bg-gray-50 dark:bg-slate-800 dark:text-white text-sm outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20 border-none cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                                    {{ __('travel.search') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Airport Tab Panel -->
                <div id="home-panel-airport" class="home-panel hidden">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-1">{{ __('home.airport_card_title') }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('home.airport_card_desc') }}</p>
                        </div>
                        <a href="{{ route('public.airport') }}" class="px-8 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition-all duration-300 flex items-center gap-2 shadow-lg shadow-amber-500/20 text-decoration-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0L7 10m5-5l5 5"/></svg>
                            {{ __('home.routes_book') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function switchHomeTab(tab, btn) {
                document.querySelectorAll('.home-tab-btn').forEach(t => {
                    t.classList.remove('bg-blue-600');
                    t.classList.add('hover:bg-white/10');
                    t.classList.remove('text-white');
                    t.classList.add('text-white/80');
                });
                btn.classList.add('bg-blue-600');
                btn.classList.remove('hover:bg-white/10');
                btn.classList.remove('text-white/80');
                btn.classList.add('text-white');

                document.querySelectorAll('.home-panel').forEach(p => {
                    p.classList.add('hidden');
                });
                document.getElementById('home-panel-' + tab).classList.remove('hidden');
            }
        </script>



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
                $travelPrice = data_get($route, 'travelPrices')?->first();
                $price = $travelPrice?->price_per_seat ?? $travelPrice?->price ?? 0;
                $duration = data_get($route, 'estimated_hours') ? number_format((float) data_get($route, 'estimated_hours'), 0) . ' jam' : 'Khusus';
                $distance = data_get($route, 'distance_km') ? number_format((float) data_get($route, 'distance_km'), 0) . ' km' : 'Tersedia';
                $kabupatenIcons = [
                    'ende' => ['initial' => 'E', 'gradient' => 'linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #93c5fd 100%)'],
                    'labuan bajo' => ['initial' => 'LB', 'gradient' => 'linear-gradient(135deg, #065f46 0%, #10b981 50%, #6ee7b7 100%)'],
                    'maumere' => ['initial' => 'M', 'gradient' => 'linear-gradient(135deg, #0e7490 0%, #06b6d4 50%, #67e8f9 100%)'],
                    'ruteng' => ['initial' => 'R', 'gradient' => 'linear-gradient(135deg, #854d0e 0%, #eab308 50%, #fde047 100%)'],
                    'bajawa' => ['initial' => 'B', 'gradient' => 'linear-gradient(135deg, #7c2d12 0%, #d97706 50%, #fbbf24 100%)'],
                    'larantuka' => ['initial' => 'L', 'gradient' => 'linear-gradient(135deg, #831843 0%, #db2777 50%, #f472b6 100%)'],
                    'borong' => ['initial' => 'BR', 'gradient' => 'linear-gradient(135deg, #451a03 0%, #9a3412 50%, #ea580c 100%)'],
                    'default' => ['initial' => 'E', 'gradient' => 'linear-gradient(135deg, #0f766e 0%, #14b8a6 50%, #5eead4 100%)'],
                ];
                $originKey = strtolower((string) data_get($route, 'origin_city', ''));
                $iconData = $kabupatenIcons[$originKey] ?? $kabupatenIcons['default'];
            @endphp
            <div class="trvl-route-card trvl-reveal">
                <div class="trvl-route-card-img"
                     @style([
                         'background:' . $iconData['gradient'],
                         'display:flex',
                         'align-items:center',
                         'justify-content:center',
                     ])>
                    <span style="font-size:2.8rem; font-weight:800; color:rgba(255,255,255,0.25); letter-spacing:-2px; line-height:1;">{{ $iconData['initial'] }}</span>
                </div>
                <div class="trvl-route-card-body">
                    <div class="trvl-route-origin-dest">
                        <span class="trvl-route-city">{{ data_get($route, 'origin_city', 'Ende') }}</span>
                        <span class="trvl-route-arrow">→</span>
                        <span class="trvl-route-city">{{ data_get($route, 'destination_city', 'Labuan Bajo') }}</span>
                    </div>
                    <div class="trvl-route-meta">
                        <span class="trvl-route-meta-item">{{ __('general.duration') }}: {{ $duration }}</span>
                        <span class="trvl-route-meta-item">{{ __('general.distance') }}: {{ $distance }}</span>
                    </div>
                    <div class="trvl-route-price">Rp {{ number_format($price, 0, ',', '.') }} <span>{{ __('home.routes_per_person') }}</span></div>
                    <a href="{{ auth()->check() && data_get($route, 'id') ? route('bookings.travel.create', ['route_id' => data_get($route, 'id')]) : route('public.travel', array_filter(['origin' => data_get($route, 'origin_city'), 'destination' => data_get($route, 'destination_city')])) }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.routes_book') }}</a>
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
                    <a href="{{ route('public.travel', ['origin' => 'Ende', 'destination' => 'Labuan Bajo']) }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.routes_book') }}</a>
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
                    <a href="{{ route('public.travel', ['origin' => 'Ende', 'destination' => 'Maumere']) }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.routes_book') }}</a>
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
                    <a href="{{ route('public.travel', ['origin' => 'Ende', 'destination' => 'Kelimutu']) }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.routes_book') }}</a>
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
                        <img src="{{ asset('images/destinations/danau-kelimutu.jpg') }}" alt="Ende" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h4 class="font-bold text-white text-lg">Ende</h4>
                            <p class="text-white/80 text-sm">Kota Pancasila</p>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Danau Kelimutu</p>
                            <p class="text-xs text-gray-500">Danau tiga warna ikonik Flores</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Rumah Bung Karno</p>
                            <p class="text-xs text-gray-500">Museum pengasingan Bung Karno 1934 hingga 1938</p>
                        </div>
                    </div>
                </div>

                <!-- Labuan Bajo -->
                <div class="trvl-route-card group trvl-reveal trvl-reveal-delay-1">
                    <div class="h-56 overflow-hidden relative">
                        <img src="{{ asset('images/destinations/pulau-komodo.avif') }}" alt="Labuan Bajo" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h4 class="font-bold text-white text-lg">Labuan Bajo</h4>
                            <p class="text-white/80 text-sm">Gerbang Komodo</p>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Pulau Komodo</p>
                            <p class="text-xs text-gray-500">Habitat asli komodo di cagar UNESCO</p>
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
                        <img src="{{ asset('images/destinations/teluk-maumere.jpg') }}" alt="Maumere" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
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
                        <img src="{{ asset('images/destinations/wae-rebo.jpg') }}" alt="Ruteng" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h4 class="font-bold text-white text-lg">Ruteng</h4>
                            <p class="text-white/80 text-sm">Kota Dingin</p>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Desa Wae Rebo</p>
                            <p class="text-xs text-gray-500">Desa di atas awan pada ketinggian 1.200 mdpl</p>
                        </div>
                    </div>
                </div>

                <!-- Bajawa -->
                <div class="trvl-route-card group trvl-reveal trvl-reveal-delay-1">
                    <div class="h-56 overflow-hidden relative">
                        <img src="{{ asset('images/destinations/kampung-bena.jpg') }}" alt="Bajawa" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
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
                        <img src="{{ asset('images/destinations/benteng-lohayong.jpg') }}" alt="Larantuka" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
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
                $carImages = [
                    'https://images.unsplash.com/photo-1543465077-db45b34b70a4?w=600&q=80',
                    'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=600&q=80',
                    'https://images.unsplash.com/photo-1568844293986-8d0400bd4745?w=600&q=80',
                    'https://images.unsplash.com/photo-1550353127-b0da98aeaa0e?w=600&q=80',
                    'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=600&q=80',
                    'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=600&q=80',
                    'https://images.unsplash.com/photo-1553440569-bcc63803a83d?w=600&q=80',
                    'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=600&q=80',
                ];
                $armada = [
                    ['nama' => 'Toyota Avanza (New)', 'kursi' => 6, 'transmisi' => 'Manual', 'harga' => 350000, 'tahun' => 2019, 'plat' => 'EB 1234 AB', 'img' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Avanza (All New)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 400000, 'tahun' => 2022, 'plat' => 'EB 5678 CD', 'img' => 'https://images.unsplash.com/photo-1543465077-db45b34b70a4?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Rush (S)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 450000, 'tahun' => 2020, 'plat' => 'EB 9012 EF', 'img' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Rush (GR)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 500000, 'tahun' => 2022, 'plat' => 'EB 3456 GH', 'img' => 'https://images.unsplash.com/photo-1550353127-b0da98aeaa0e?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Innova (G)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 500000, 'tahun' => 2020, 'plat' => 'EB 7890 IJ', 'img' => 'https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Innova (Reborn)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 600000, 'tahun' => 2022, 'plat' => 'EB 2345 KL', 'img' => 'https://images.unsplash.com/photo-1568844293986-8d0400bd4745?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Innova (Venturer)', 'kursi' => 7, 'transmisi' => 'Automatic', 'harga' => 750000, 'tahun' => 2023, 'plat' => 'EB 6789 MN', 'img' => 'https://images.unsplash.com/photo-1550353127-b0da98aeaa0e?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Hiace (Premio)', 'kursi' => 12, 'transmisi' => 'Manual', 'harga' => 800000, 'tahun' => 2020, 'plat' => 'EB 0123 OP', 'img' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Hiace (Royale)', 'kursi' => 12, 'transmisi' => 'Manual', 'harga' => 1000000, 'tahun' => 2022, 'plat' => 'EB 1122 QR', 'img' => 'https://images.unsplash.com/photo-1583267746897-2cf415887172?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Honda Brio (Satya)', 'kursi' => 4, 'transmisi' => 'Manual', 'harga' => 250000, 'tahun' => 2021, 'plat' => 'EB 3344 ST', 'img' => 'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Honda Brio (RS)', 'kursi' => 4, 'transmisi' => 'Automatic', 'harga' => 300000, 'tahun' => 2023, 'plat' => 'EB 5566 UV', 'img' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Honda Mobilio (E)', 'kursi' => 6, 'transmisi' => 'Manual', 'harga' => 350000, 'tahun' => 2020, 'plat' => 'EB 7788 WX', 'img' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Honda Mobilio (RS)', 'kursi' => 6, 'transmisi' => 'Manual', 'harga' => 400000, 'tahun' => 2022, 'plat' => 'EB 9900 YZ', 'img' => 'https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Daihatsu Grand Max (Blind Van)', 'kursi' => 2, 'transmisi' => 'Manual', 'harga' => 300000, 'tahun' => 2020, 'plat' => 'EB 1112 AB', 'img' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Daihatsu Grand Max (Pickup)', 'kursi' => 2, 'transmisi' => 'Manual', 'harga' => 350000, 'tahun' => 2021, 'plat' => 'EB 1314 CD', 'img' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Daihatsu Grand Max (Minibus)', 'kursi' => 8, 'transmisi' => 'Manual', 'harga' => 400000, 'tahun' => 2022, 'plat' => 'EB 1516 EF', 'img' => 'https://images.unsplash.com/photo-1543465077-db45b34b70a4?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Hilux (E)', 'kursi' => 4, 'transmisi' => 'Manual', 'harga' => 600000, 'tahun' => 2021, 'plat' => 'EB 1718 GH', 'img' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Hilux (V)', 'kursi' => 4, 'transmisi' => 'Manual', 'harga' => 700000, 'tahun' => 2023, 'plat' => 'EB 1920 IJ', 'img' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Daihatsu Terios (X)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 400000, 'tahun' => 2020, 'plat' => 'EB 2122 KL', 'img' => 'https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Daihatsu Terios (R)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 450000, 'tahun' => 2022, 'plat' => 'EB 2324 MN', 'img' => 'https://images.unsplash.com/photo-1568844293986-8d0400bd4745?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Suzuki Ertiga (GX)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 350000, 'tahun' => 2020, 'plat' => 'EB 2526 OP', 'img' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Suzuki Ertiga (Sport)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 400000, 'tahun' => 2022, 'plat' => 'EB 2728 QR', 'img' => 'https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Mitsubishi Xpander (GLS)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 450000, 'tahun' => 2021, 'plat' => 'EB 2930 ST', 'img' => 'https://images.unsplash.com/photo-1568844293986-8d0400bd4745?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Mitsubishi Xpander (Ultimate)', 'kursi' => 7, 'transmisi' => 'Automatic', 'harga' => 550000, 'tahun' => 2023, 'plat' => 'EB 3132 UV', 'img' => 'https://images.unsplash.com/photo-1550353127-b0da98aeaa0e?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Fortuner (SRV)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 1000000, 'tahun' => 2021, 'plat' => 'EB 3334 WX', 'img' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Fortuner (VRZ)', 'kursi' => 7, 'transmisi' => 'Automatic', 'harga' => 1300000, 'tahun' => 2023, 'plat' => 'EB 3536 YZ', 'img' => 'https://images.unsplash.com/photo-1550353127-b0da98aeaa0e?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Honda HR-V (E)', 'kursi' => 5, 'transmisi' => 'Automatic', 'harga' => 700000, 'tahun' => 2021, 'plat' => 'EB 3738 AB', 'img' => 'https://images.unsplash.com/photo-1568844293986-8d0400bd4745?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Honda HR-V (SE)', 'kursi' => 5, 'transmisi' => 'Automatic', 'harga' => 800000, 'tahun' => 2023, 'plat' => 'EB 3940 CD', 'img' => 'https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Mitsubishi Pajero Sport (Dakar)', 'kursi' => 7, 'transmisi' => 'Automatic', 'harga' => 1400000, 'tahun' => 2023, 'plat' => 'EB 4142 EF', 'img' => 'https://images.unsplash.com/photo-1550353127-b0da98aeaa0e?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Isuzu Elf (NLR)', 'kursi' => 15, 'transmisi' => 'Manual', 'harga' => 900000, 'tahun' => 2021, 'plat' => 'EB 4344 GH', 'img' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Calya (E)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 300000, 'tahun' => 2020, 'plat' => 'EB 4546 IJ', 'img' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Daihatsu Sigra (X)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 300000, 'tahun' => 2021, 'plat' => 'EB 4748 KL', 'img' => 'https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Toyota Agya (G)', 'kursi' => 4, 'transmisi' => 'Manual', 'harga' => 200000, 'tahun' => 2022, 'plat' => 'EB 4950 MN', 'img' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=900&q=80'],
                    ['nama' => 'Nissan Livina (High)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 400000, 'tahun' => 2020, 'plat' => 'EB 5152 OP', 'img' => 'https://images.unsplash.com/photo-1543465077-db45b34b70a4?auto=format&fit=crop&w=900&q=80'],
                ];
                $showAll = request()->has('show_all');
                $displayArmada = $showAll ? $armada : array_slice($armada, 0, 3);
            @endphp
            @foreach($displayArmada as $kendaraan)
            <div class="trvl-vehicle-card trvl-reveal @if($loop->index > 0) trvl-reveal-delay-{{ min($loop->index, 3) }} @endif">
                <div class="trvl-vehicle-card-img">
                    <img src="{{ $carImages[$loop->index % 8] }}" alt="{{ $kendaraan['nama'] }}" loading="lazy">
                </div>
                <div class="trvl-vehicle-card-body">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="trvl-vehicle-name" style="margin:0;">{{ $kendaraan['nama'] }}</h3>
                        <span class="text-[0.55rem] font-semibold px-2 py-0.5 rounded-full" style="background:#e8f4fd; color:#0064d2;">{{ $kendaraan['transmisi'] }}</span>
                    </div>
                    <p class="text-xs" style="color:#6c757d; margin-bottom:0.5rem;">{{ $kendaraan['plat'] }}</p>
                    <div class="trvl-vehicle-specs">
                        <span class="trvl-vehicle-spec">{{ $kendaraan['kursi'] }} {{ __('rental.seats') }}</span>
                        <span class="trvl-vehicle-spec">{{ __('rental.ac') }}</span>
                    </div>
                    <div class="trvl-vehicle-price">Rp {{ number_format($kendaraan['harga'], 0, ',', '.') }} <span>{{ __('home.fleet_per_day') }}</span></div>
                    <a href="{{ route('public.rental') }}" class="trvl-btn-pesan text-decoration-none">{{ __('home.fleet_book') }}</a>
                </div>
            </div>
            @endforeach
        </div>

        @if(!$showAll)
        <div class="text-center mt-8">
            <a href="{{ route('public.rental') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 hover:-translate-y-0.5" style="background:#0064d2; color:white; box-shadow:0 4px 14px rgba(0,100,210,0.3);">
                {{ __('home.fleet_see_all') }}
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
                <a href="tel:+6283156408078" class="trvl-btn-cta-outline text-decoration-none">
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

