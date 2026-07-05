
@extends('layouts.public')

@section('title', 'Travel - ASR GO')

@section('content')
<!-- TRAVEL SEARCH BAR -->
<div class="travel-hero-section" style="padding: 2.5rem 0 2rem;" id="layanan">
    <div class="trvl-container">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: white; letter-spacing: -0.5px;">
                <span style="display:inline-flex; align-items:center; gap:0.4rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 16l4-4 4 4 4-4 4 4 4-4"/><path d="M2 12h20"/><line x1="6" y1="14" x2="6" y2="20"/><line x1="18" y1="14" x2="18" y2="20"/></svg>
                    Travel Antar Kota
                </span>
            </h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 0.25rem; font-weight: 400;">Harga terjangkau, nyaman, aman & tepat waktu</p>
        </div>
        <form method="GET" action="{{ route('public.travel') }}" style="background: var(--trvl-card); border-radius: 16px; padding: 1.25rem; box-shadow: 0 20px 50px rgba(0,0,0,0.15);">
            <div style="display: grid; grid-template-columns: 1fr 1fr 140px 100px 1fr; gap: 0.75rem; align-items: end;">
                <div>
                    <label class="trvl-field-label">Dari</label>
                    <select name="origin" class="trvl-form-field">
                        <option value="">Kota Asal</option>
                        @foreach ($origins as $origin)
                            <option value="{{ $origin }}" {{ request('origin') == $origin ? 'selected' : '' }}>{{ $origin }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="trvl-field-label">Ke</label>
                    <select name="destination" class="trvl-form-field">
                        <option value="">Kota Tujuan</option>
                        @foreach ($destinations as $destination)
                            <option value="{{ $destination }}" {{ request('destination') == $destination ? 'selected' : '' }}>{{ $destination }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="trvl-field-label">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="trvl-form-field">
                </div>
                <div>
                    <label class="trvl-field-label">Penumpang</label>
                    <select name="passengers" class="trvl-form-field">
                        <option value="1" {{ request('passengers') == '1' ? 'selected' : '' }}>1 orang</option>
                        <option value="2" {{ request('passengers') == '2' ? 'selected' : '' }}>2 orang</option>
                        <option value="3" {{ request('passengers') == '3' ? 'selected' : '' }}>3 orang</option>
                        <option value="4" {{ request('passengers') == '4' ? 'selected' : '' }}>4 orang</option>
                        <option value="5" {{ request('passengers') == '5' ? 'selected' : '' }}>+5 orang</option>
                    </select>
                <div>
                    <button type="submit" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; background: linear-gradient(135deg, #0064d2 0%, #004ba0 100%); color: white; padding: 0.875rem 1.5rem; border-radius: 10px; font-weight: 700; font-size: 0.9rem; transition: all 0.25s; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(0,100,210,0.35); width: 100%;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><mipath d="m21 21-4.35-4.35"/></svg>
                        Cari Tiket
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div style="background: var(--trvl-bg); padding: 1.5rem 0 3rem;" id="armada">
    <div class="trvl-container">
        <div style="display: grid; grid-template-columns: 260px 1fr; gap: 1.5rem;">

            <!-- FILTER SIDEBAR -->
            <aside>
                <div style="background: var(--trvl-card); border-radius: 14px; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border: 1px solid var(--trvl-border); position: sticky; top: 80px;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; padding-bottom: 0.75rem; border-bottom: 2px solid #f0f6ff;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0064d2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                        <h3 style="font-size: 0.9rem; font-weight: 700; color: #0d2147;">Filter</h3>
                    </div>
                    <form method="GET" action="{{ route('public.travel') }}">
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Asal</label>
                            <select name="origin" class="trvl-form-field" style="font-size: 0.85rem; padding: 0.6rem 0.75rem;">
                                <option value="">Semua Asal</option>
                                @foreach ($origins as $origin)
                                    <option value="{{ $origin }}" {{ request('origin') == $origin ? 'selected' : '' }}>{{ $origin }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Tujuan</label>
                            <select name="destination" class="trvl-form-field" style="font-size: 0.85rem; padding: 0.6rem 0.75rem;">
                                <option value="">Semua Tujuan</option>
                                @foreach ($destinations as $destination)
                                    <option value="{{ $destination }}" {{ request('destination') == $destination ? 'selected' : '' }}>{{ $destination }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Tanggal Berangkat</label>
                            <input type="date" name="date" value="{{ request('date') }}" class="trvl-form-field" style="font-size: 0.85rem; padding: 0.6rem 0.75rem;">
                        </div>
                        <div style="margin-bottom: 0.5rem;">
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Penumpang</label>
                            <select name="passengers" class="trvl-form-field" style="font-size: 0.85rem; padding: 0.6rem 0.75rem;">
                                <option value="">Jumlah</option>
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ request('passengers') == $i ? 'selected' : '' }}>{{ $i }} {{ $i == 6 ? '+' : '' }} penumpang</option>
                                @endfor
                            </select>
                        </div>
                        <div style="margin-top: 1.25rem; display: flex; gap: 0.5rem;">
                            <button type="submit" style="flex: 1; background: #0064d2; color: white; padding: 0.7rem 1rem; border-radius: 8px; font-weight: 700; font-size: 0.85rem; border: none; cursor: pointer; transition: all 0.2s;">Filter</button>
                            <a href="{{ route('public.travel') }}" style="background: #e9ecef; color: #6c757d; padding: 0.7rem 1rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem; text-decoration: none; transition: all 0.2s;">Reset</a>
                        </div>
                    </form>

                    <!-- Price filter -->
                    <div style="margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid var(--trvl-border);">
                        <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.5rem;">Harga</label>
                        <div style="display: flex; gap: 0.4rem; align-items: center;">
                            <input type="number" value="{{ request('price_min') }}" placeholder="Min" class="trvl-form-field" style="font-size: 0.8rem; padding: 0.5rem; flex: 1;" readonly>
                            <span style="color: #6c757d;">–</span>
                            <input type="number" value="{{ request('price_max') }}" placeholder="Max" class="trvl-form-field" style="font-size: 0.8rem; padding: 0.5rem; flex: 1;" readonly>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- ROUTE LISTING -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding: 0 0.25rem;">
                    <p style="font-size: 0.875rem; color: #6c757d; font-weight: 500;">
                        <span style="font-weight: 700; color: #0d2147;">{{ $routes->total() }}</span> rute ditemukan
                    </p>
                    <div style="font-size: 0.82rem; color: #6c757d; display: flex; align-items: center; gap: 0.4rem;">
                        <span>Urutkan:</span>
                        <select style="border: none; background: transparent; font-weight: 600; color: #0064d2; font-size: 0.82rem; cursor: pointer;">
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
                                            <span style="font-weight: 800; font-size: 0.95rem; color: #0d2147;">{{ $route->origin_city }}</span>
                                            <svg width="20" height="16" viewBox="0 0 24 16" fill="none" stroke="#0064d2" stroke-width="2"><path d="M5 8h14M13 4l4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            <span style="font-weight: 800; font-size: 0.95rem; color: #0d2147;">{{ $route->destination_city }}</span>
                                        </div>
                                        <div style="display: flex; flex-wrap: wrap; gap: 1rem; padding-bottom: 0.5rem;">
                                            <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.78rem; color: #495057; font-weight: 500;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                {{ $route->estimated_hours ?? '-' }} jam
                                            </div>
                                            <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.78rem; color: #495057; font-weight: 500;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                                {{ $route->total_seats ?? '28' }} kursi
                                            </div>
                                            <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.78rem; color: #495057; font-weight: 500;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
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
                                            <span style="font-size: 0.7rem; color: #6c757d; font-weight: 500;">mulai dari</span>
                                            <p style="font-size: 1.35rem; font-weight: 800; color: #0064d2; line-height: 1.1;">Rp {{ number_format($cheapestPrice->price_per_seat, 0, ',', '.') }}</p>
                                            <span style="font-size: 0.7rem; color: #6c757d; font-weight: 400;">/ penumpang</span>
                                        </div>
                                    @else
                                        <span style="font-size: 0.85rem; color: #6c757d; font-weight: 500;">Hubungi CS</span>
                                    @endif
                                    @auth
                                        <a href="{{ route('bookings.travel.create', ['route_id' => $route->id]) }}" 
                                           style="display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem; background: linear-gradient(135deg, #0064d2 0%, #004ba0 100%); color: white; padding: 0.7rem 1.5rem; border-radius: 10px; font-weight: 700; font-size: 0.85rem; text-decoration: none; transition: all 0.25s; box-shadow: 0 4px 14px rgba(0,100,210,0.3);">
                                            Pesan
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" 
                                           style="display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem; background: white; color: #0064d2; border: 2px solid #0064d2; padding: 0.65rem 1.5rem; border-radius: 10px; font-weight: 700; font-size: 0.85rem; text-decoration: none; transition: all 0.25s;">
                                            Pesan
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0064d2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                        </a>
                                    @endauth
                                </div>
                            </div>

                            <!-- Schedule Strip -->
                            <div style="background: var(--trvl-gray-100); padding: 0.6rem 1.25rem; border-top: 1px solid var(--trvl-border); display: flex; align-items: center; gap: 1rem;">
                                <span style="font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.04em;">Jadwal Keberangkatan:</span>
                                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                    @if(!empty($route->departure_times))
                                        @foreach($route->departure_times as $time)
                                            <span style="display: inline-block; background: var(--trvl-bg); border: 1px solid var(--trvl-border); border-radius: 6px; padding: 0.2rem 0.6rem; font-size: 0.75rem; font-weight: 600; color: var(--trvl-gray-900);">{{ is_string($time) ? $time : ($time->format('H:i') ?? '08:00') }}</span>
                                        @endforeach
                                    @else
                                        <span style="display: inline-block; background: var(--trvl-bg); border: 1px solid var(--trvl-border); border-radius: 6px; padding: 0.2rem 0.6rem; font-size: 0.75rem; font-weight: 600; color: var(--trvl-gray-900);">08:00</span>
                                        <span style="display: inline-block; background: var(--trvl-bg); border: 1px solid var(--trvl-border); border-radius: 6px; padding: 0.2rem 0.6rem; font-size: 0.75rem; font-weight: 600; color: var(--trvl-gray-900);">14:00</span>
                                        <span style="display: inline-block; background: var(--trvl-bg); border: 1px solid var(--trvl-border); border-radius: 6px; padding: 0.2rem 0.6rem; font-size: 0.75rem; font-weight: 600; color: var(--trvl-gray-900);">19:30</span>
                                    @endif
                                </div>
                                <span style="margin-left: auto; font-size: 0.72rem; color: #6c757d; white-space: nowrap;">Jarak {{ $route->distance_km ?? '250' }} km</span>
                        </div>
                    @empty
                        <div style="background: var(--trvl-card); border-radius: 14px; border: 1px solid var(--trvl-border); padding: 3rem 2rem; text-align: center;">
                            <div style="font-size: 3.5rem; margin-bottom: 1rem;">🚐</div>
                            <p style="font-size: 1rem; font-weight: 700; color: #0d2147;">Oops, belum ada rute tersedia</p>
                            <p style="font-size: 0.85rem; color: #6c757d; margin-top: 0.5rem; line-height: 1.5;">Coba ubah atau reset filter pencarian kamu untuk menemukan rute lainnya.</p>
                            <a href="{{ route('public.travel') }}" 
                               style="display: inline-block; margin-top: 1rem; background: #0064d2; color: white; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: 0.875rem; text-decoration: none;">Reset Filter</a>
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
    #travel-grid > aside { order: -1; }
    #travel-grid > aside > div { position: static !important; margin-bottom: 1rem; }
}
</style>
<script>
(function(){
    const parent = document.querySelector('div > .trvl-container > div[style*="grid-template-columns: 260px"]');
    if(parent) parent.id = 'travel-grid';
})();
</script>
 @endsection
