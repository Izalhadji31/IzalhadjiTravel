
@extends('layouts.public')

@section('title', __('travel.title') . ' - ASR GO')

@section('content')
<!-- TRAVEL SEARCH BAR -->
<div class="travel-hero-section" style="padding: 2.5rem 0 2rem;" id="layanan">
    <div class="trvl-container">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: white; letter-spacing: -0.5px;">
                <span style="display:inline-flex; align-items:center; gap:0.4rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 16l4-4 4 4 4-4 4 4 4-4"/><path d="M2 12h20"/><line x1="6" y1="14" x2="6" y2="20"/><line x1="18" y1="14" x2="18" y2="20"/></svg>
                    {{ __('travel.title') }}
                </span>
            </h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 0.25rem; font-weight: 400;">{{ __('travel.subtitle') }}</p>
        </div>
        <form method="GET" action="{{ route('public.travel') }}" style="background: var(--trvl-card); border-radius: 16px; padding: 1.25rem; box-shadow: 0 20px 50px rgba(0,0,0,0.15);">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 0.75rem; align-items: end;">
                <div>
                    <label class="trvl-field-label">{{ __('travel.from') }}</label>
                    <select name="origin" class="trvl-form-field">
                        <option value="">{{ __('travel.origin_placeholder') }}</option>
                        @foreach ($origins as $origin)
                            <option value="{{ $origin }}" {{ request('origin') == $origin ? 'selected' : '' }}>{{ $origin }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="trvl-field-label">{{ __('travel.to') }}</label>
                    <select name="destination" class="trvl-form-field">
                        <option value="">{{ __('travel.destination_placeholder') }}</option>
                        @foreach ($destinations as $destination)
                            <option value="{{ $destination }}" {{ request('destination') == $destination ? 'selected' : '' }}>{{ $destination }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="trvl-field-label">{{ __('travel.date') }}</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="trvl-form-field">
                </div>
                <div>
                    <label class="trvl-field-label">{{ __('travel.passengers') }}</label>
                    <select name="passengers" class="trvl-form-field">
                        <option value="1" {{ request('passengers') == '1' ? 'selected' : '' }}>1 {{ __('travel.passenger_count') }}</option>
                        <option value="2" {{ request('passengers') == '2' ? 'selected' : '' }}>2 {{ __('travel.passenger_count') }}</option>
                        <option value="3" {{ request('passengers') == '3' ? 'selected' : '' }}>3 {{ __('travel.passenger_count') }}</option>
                        <option value="4" {{ request('passengers') == '4' ? 'selected' : '' }}>4 {{ __('travel.passenger_count') }}</option>
                        <option value="5" {{ request('passengers') == '5' ? 'selected' : '' }}>+5 {{ __('travel.passenger_count') }}</option>
                    </select>
                </div>
                <div>
                    <button type="submit" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; background: linear-gradient(135deg, #0064d2 0%, #004ba0 100%); color: white; padding: 0.875rem 1.5rem; border-radius: 10px; font-weight: 700; font-size: 0.9rem; transition: all 0.25s; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(0,100,210,0.35); width: 100%;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        {{ __('travel.search') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div style="background: var(--trvl-bg); padding: 1.5rem 0 3rem;" id="armada">
    <div class="trvl-container">
        <div id="travel-grid" style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">

            <!-- ROUTE LISTING -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding: 0 0.25rem;">
                    <p style="font-size: 0.875rem; color: var(--trvl-gray-600); font-weight: 500;">
                        <span style="font-weight: 700; color: var(--trvl-text);">{{ $routes->total() }}</span> {{ __('travel.filter_date') }}
                    </p>
                    <div style="font-size: 0.82rem; color: var(--trvl-gray-600); display: flex; align-items: center; gap: 0.4rem;">
                        <span>Urutkan:</span>
                        <select style="border: none; background: transparent; font-weight: 600; color: var(--trvl-blue); font-size: 0.82rem; cursor: pointer;">
                            <option>Harga Terendah</option>
                            <option>Keberangkatan Terlama</option>
                            <option>Durasi Terpendek</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @forelse ($routes as $route)
                        <div style="background: var(--trvl-card); border-radius: 14px; border: 1px solid var(--trvl-border); box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden; transition: all 0.3s ease;"
                             onmouseover="this.style.boxShadow='0 4px 20px rgba(0,100,210,0.12)'; this.style.borderColor='#dbeafe';"
                             onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.06)'; this.style.borderColor='var(--trvl-border)';">
                            <div style="display: grid; grid-template-columns: 1fr auto; align-items: center; padding: 1.25rem;">
                                <div style="display: flex; gap: 1.25rem; align-items: center;">
                                    <!-- Route Icon -->
                                    <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #e8f4fd 0%, #f0f6ff 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0064d2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                                    </div>
                                    <!-- Route Info -->
                                    <div>
                                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                            <span style="font-weight: 800; font-size: 0.95rem; color: var(--trvl-text);">{{ $route->origin_city }}</span>
                                            <svg width="20" height="16" viewBox="0 0 24 16" fill="none" stroke="#0064d2" stroke-width="2"><path d="M5 8h14M13 4l4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            <span style="font-weight: 800; font-size: 0.95rem; color: var(--trvl-text);">{{ $route->destination_city }}</span>
                                        </div>
                                        <div style="display: flex; flex-wrap: wrap; gap: 1rem; padding-bottom: 0.5rem;">
                                            <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.78rem; color: var(--trvl-gray-700); font-weight: 500;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                {{ $route->estimated_hours ?? '-' }} {{ __('travel.est_hours') }}
                                            </div>
                                            <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.78rem; color: var(--trvl-gray-700); font-weight: 500;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                                {{ $route->total_seats ?? '28' }} {{ __('rental.seats') }}
                                            </div>
                                            <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.78rem; color: var(--trvl-gray-700); font-weight: 500;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                                {{ ucfirst($route->route_type ?? 'Executive') }}
                                            </div>
                                            <div style="display: inline-flex; align-items: center; gap: 0.3rem;">
                                                <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #00a651;"></span>
                                                <span style="font-size: 0.75rem; color: #00a651; font-weight: 600;">Tersedia</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
                                    @php
                                        $cheapestPrice = $route->travelPrices->first();
                                    @endphp
                                    @if ($cheapestPrice)
                                        <div>
                                            <span style="font-size: 0.7rem; color: var(--trvl-gray-600); font-weight: 500;">mulai dari</span>
                                            <p style="font-size: 1.35rem; font-weight: 800; color: var(--trvl-blue); line-height: 1.1;">Rp {{ number_format($cheapestPrice->price_per_seat, 0, ',', '.') }}</p>
                                            <span style="font-size: 0.7rem; color: var(--trvl-gray-600); font-weight: 400;">/ {{ __('travel.passenger_count') }}</span>
                                        </div>
                                    @else
                                        <span style="font-size: 0.85rem; color: var(--trvl-gray-600); font-weight: 500;">Hubungi CS</span>
                                    @endif
                                    @auth
                                        <a href="{{ route('bookings.travel.create', ['route_id' => $route->id]) }}" 
                                           style="display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem; background: linear-gradient(135deg, #0064d2 0%, #004ba0 100%); color: white; padding: 0.7rem 1.5rem; border-radius: 10px; font-weight: 700; font-size: 0.85rem; text-decoration: none; transition: all 0.25s; box-shadow: 0 4px 14px rgba(0,100,210,0.3);">
                                            {{ __('travel.book') }}
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" 
                                           style="display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem; background: var(--trvl-card); color: var(--trvl-blue); border: 2px solid var(--trvl-blue); padding: 0.65rem 1.5rem; border-radius: 10px; font-weight: 700; font-size: 0.85rem; text-decoration: none; transition: all 0.25s;">
                                            {{ __('travel.book') }}
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                        </a>
                                    @endauth
                                </div>
                            </div>

                            <!-- Schedule Strip -->
                                <div style="background: var(--trvl-gray-100); padding: 0.6rem 1.25rem; border-top: 1px solid var(--trvl-border); display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                                    <div style="display: flex; align-items: center; gap: 0.4rem;">
                                        <span style="font-size: 0.72rem; font-weight: 700; color: var(--trvl-gray-600); text-transform: uppercase; letter-spacing: 0.04em;">Jadwal:</span>
                                        <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
                                            @php
                                                $now = now()->format('H:i');
                                                $times = !empty($route->departure_times) ? $route->departure_times : ['08:00', '14:00', '19:30'];
                                            @endphp
                                            @foreach($times as $time)
                                                @php
                                                    $t = is_string($time) ? $time : ($time->format('H:i') ?? '08:00');
                                                    $available = $t >= $now;
                                                @endphp
                                                <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: {{ $available ? '#dbeafe' : 'var(--trvl-bg)' }}; border: 1px solid {{ $available ? '#93c5fd' : 'var(--trvl-border)' }}; border-radius: 6px; padding: 0.2rem 0.6rem; font-size: 0.75rem; font-weight: 600; color: {{ $available ? '#1d4ed8' : 'var(--trvl-gray-500)' }};">
                                                    {{ $t }}
                                                    @if($available)
                                                        <span style="width:5px;height:5px;border-radius:50%;background:#00a651;display:inline-block;"></span>
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <span style="font-size: 0.7rem; color: var(--trvl-gray-500); font-weight: 500;">
                                        @php
                                            $hasAvailable = false;
                                            foreach($times as $time) {
                                                $t = is_string($time) ? $time : ($time->format('H:i') ?? '08:00');
                                                if ($t >= $now) { $hasAvailable = true; break; }
                                            }
                                        @endphp
                                        @if($hasAvailable)
                                            <span style="color:#00a651;">Tersedia hari ini</span>
                                        @else
                                            <span style="color:#dc2626;">Keberangkatan hari ini habis</span>
                                        @endif
                                    </span>
                                    <span style="margin-left: auto; font-size: 0.72rem; color: var(--trvl-gray-600); white-space: nowrap;">{{ $route->distance_km ?? '250' }} km</span>
                                </div>
                    @empty
                        <div style="background: var(--trvl-card); border-radius: 14px; border: 1px solid var(--trvl-border); padding: 3rem 2rem; text-align: center;">
                            <div style="font-size: 1rem; font-weight: 700; color: var(--trvl-blue); margin-bottom: 1rem;">Tidak Ada Rute</div>
                            <p style="font-size: 1rem; font-weight: 700; color: var(--trvl-text);">{{ __('travel.empty') }}</p>
                            <p style="font-size: 0.85rem; color: var(--trvl-gray-600); margin-top: 0.5rem; line-height: 1.5;">{{ __('travel.empty_desc') }}</p>
                            <a href="{{ route('public.travel') }}" 
                               style="display: inline-block; margin-top: 1rem; background: var(--trvl-blue); color: white; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: 0.875rem; text-decoration: none;">Reset Filter</a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
                    {{ $routes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<style>
/* Hero section */
.travel-hero-section {
    background: linear-gradient(135deg, #0d2147 0%, #1a3a6c 30%, #0064d2 70%, #1e88e5 100%);
}
.dark .travel-hero-section {
    background: linear-gradient(135deg, #0a0a1a 0%, #0d1a3a 30%, #003d80 70%, #0d5ca0 100%);
}
.dark .bg-card { background: var(--trvl-card); }
.dark .bg-section { background: var(--trvl-bg); }
.dark #travel-grid .trvl-form-field { background: var(--trvl-bg); color: var(--trvl-text); }
@media (max-width: 900px) {
    #travel-grid { grid-template-columns: 1fr !important; }
}
</style>
<script>
(function(){
    const parent = document.querySelector('div > .trvl-container > div[style*="grid-template-columns: 260px"]');
    if(parent) parent.id = 'travel-grid';
})();
</script>
 @endsection
