
@extends('layouts.public')

@section('title', 'Rental Kendaraan - ASR GO')

@section('content')
<!-- RENTAL HERO -->
<div class="rental-hero-section" style="padding: 2.5rem 0 2rem;" id="layanan">
    <div class="trvl-container">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: white; letter-spacing: -0.5px;">
                <span style="display:inline-flex; align-items:center; gap:0.4rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"/><circle cx="6.5" cy="16.5" r="2.5"/><circle cx="16.5" cy="16.5" r="2.5"/></svg>
                    Sewa Kendaraan
                </span>
            </h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 0.25rem; font-weight: 400;">Pilih kendaraan terbaik untuk perjalanan Anda</p>
        </div>
        <form method="GET" action="{{ route('public.rental') }}" style="background: var(--trvl-card); border-radius: 16px; padding: 1.25rem; box-shadow: 0 20px 50px rgba(0,0,0,0.15);">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 0.75rem; align-items: end;">
                <div>
                    <label class="trvl-field-label">Tujuan</label>
                    <select name="destination" class="trvl-form-field">
                        <option value="">Semua Tujuan</option>
                        @foreach ($destinations as $destination)
                            <option value="{{ $destination }}" {{ request('destination') == $destination ? 'selected' : '' }}>{{ $destination }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="trvl-field-label">Tipe Kendaraan</label>
                    <select name="vehicle_type" class="trvl-form-field">
                        <option value="">Semua Tipe</option>
                        @foreach ($vehicleTypes as $type)
                            <option value="{{ $type }}" {{ request('vehicle_type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="trvl-field-label">Opsi Sopir</label>
                    <select name="driver_option" class="trvl-form-field">
                        <option value="">Semua Opsi</option>
                        <option value="with" {{ request('driver_option') == 'with' ? 'selected' : '' }}>Dengan Sopir</option>
                        <option value="without" {{ request('driver_option') == 'without' ? 'selected' : '' }}>Tanpa Sopir</option>
                    </select>
                </div>
                <div>
                    <button type="submit" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; background: linear-gradient(135deg, #0064d2 0%, #004ba0 100%); color: white; padding: 0.875rem 1.5rem; border-radius: 10px; font-weight: 700; font-size: 0.9rem; transition: all 0.25s; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(0,100,210,0.35); width: 100%;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        Cari Kendaraan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div style="background: var(--trvl-bg); padding: 1.5rem 0 3rem;" id="armada">
    <div class="trvl-container">
        <div style="display: grid; grid-template-columns: 260px 1fr; gap: 1.5rem;" id="rental-grid">

            <!-- FILTER SIDEBAR -->
            <aside>
                <div style="background: var(--trvl-card); border-radius: 14px; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border: 1px solid var(--trvl-border); position: sticky; top: 80px;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; padding-bottom: 0.75rem; border-bottom: 2px solid #f0f6ff;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0064d2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                        <h3 style="font-size: 0.9rem; font-weight: 700; color: #0d2147;">Filter</h3>
                    </div>
                    <form method="GET" action="{{ route('public.rental') }}">
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.5rem;">Tipe Kendaraan</label>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                @foreach ($vehicleTypes as $type)
                                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.4rem 0.6rem; border-radius: 8px; transition: all 0.15s; {{ request('vehicle_type') == $type ? 'background: #e8f4fd;' : '' }}" onmouseover="this.style.background='#f0f6ff';" onmouseout="this.style.background='{{ request('vehicle_type') == $type ? '#e8f4fd' : 'transparent' }}';">
                                        <input type="radio" name="vehicle_type" value="{{ $type }}" {{ request('vehicle_type') == $type ? 'checked' : '' }} style="accent-color: #0064d2;">
                                        <span style="font-size: 0.85rem; font-weight: 600; color: #0d2147;">{{ ucfirst($type) }}</span>
                                    </label>
                                @endforeach
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.4rem 0.6rem; border-radius: 8px; {{ !request('vehicle_type') ? 'background: #e8f4fd;' : '' }}">
                                    <input type="radio" name="vehicle_type" value="" {{ !request('vehicle_type') ? 'checked' : '' }} style="accent-color: #0064d2;">
                                    <span style="font-size: 0.85rem; font-weight: 600; color: #0d2147;">Semua Tipe</span>
                                </label>
                            </div>
                        </div>
                        <div style="margin-bottom: 1rem; padding-top: 1rem; border-top: 1px solid var(--trvl-border);">
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.5rem;">Opsi Sopir</label>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.4rem 0.6rem; border-radius: 8px; {{ request('driver_option') == 'with' ? 'background: #e8f4fd;' : '' }}">
                                    <input type="radio" name="driver_option" value="with" {{ request('driver_option') == 'with' ? 'checked' : '' }} style="accent-color: #0064d2;">
                                    <span style="font-size: 0.85rem; font-weight: 600; color: #0d2147;">�‍�️ Dengan Sopir</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.4rem 0.6rem; border-radius: 8px; {{ request('driver_option') == 'without' ? 'background: #e8f4fd;' : '' }}">
                                    <input type="radio" name="driver_option" value="without" {{ request('driver_option') == 'without' ? 'checked' : '' }} style="accent-color: #0064d2;">
                                    <span style="font-size: 0.85rem; font-weight: 600; color: #0d2147;">🔑 Tanpa Sopir</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.4rem 0.6rem; border-radius: 8px; {{ !request('driver_option') ? 'background: #e8f4fd;' : '' }}">
                                    <input type="radio" name="driver_option" value="" {{ !request('driver_option') ? 'checked' : '' }} style="accent-color: #0064d2;">
                                    <span style="font-size: 0.85rem; font-weight: 600; color: #0d2147;">Semua Opsi</span>
                                </label>
                            </div>
                        </div>
                        <div style="margin-top: 1.25rem; display: flex; gap: 0.5rem;">
                            <button type="submit" style="flex: 1; background: #0064d2; color: white; padding: 0.7rem 1rem; border-radius: 8px; font-weight: 700; font-size: 0.85rem; border: none; cursor: pointer;">Filter</button>
                            <a href="{{ route('public.rental') }}" style="background: #e9ecef; color: #6c757d; padding: 0.7rem 1rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem; text-decoration: none;">Reset</a>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- VEHICLE LISTING -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding: 0 0.25rem;">
                    <p style="font-size: 0.875rem; color: #6c757d; font-weight: 500;">
                        <span style="font-weight: 700; color: #0d2147;">{{ $rentals->total() }}</span> kendaraan tersedia
                    </p>
                    <div style="font-size: 0.82rem; color: #6c757d; display: flex; align-items: center; gap: 0.4rem;">
                        <span>Urutkan:</span>
                        <select style="border: none; background: transparent; font-weight: 600; color: #0064d2; font-size: 0.82rem; cursor: pointer;">
                            <option>Harga Terendah</option>
                            <option>Harga Tertinggi</option>
                            <option>Kapasitas Terbesar</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    @forelse ($rentals as $rental)
                        <div style="background: var(--trvl-card); border-radius: 14px; border: 1px solid var(--trvl-border); box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);"
                             onmouseover="this.style.boxShadow='0 8px 30px rgba(0,100,210,0.15)'; this.style.borderColor='#dbeafe'; this.style.transform='translateY(-4px)';"
                             onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.06)'; this.style.borderColor='var(--trvl-border)'; this.style.transform='translateY(0)';">

                            <!-- Vehicle Image Placeholder -->
                            <div style="height: 140px; position: relative; overflow: hidden;">
                                <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=600&q=80" alt="{{ $rental->route->name ?? 'Kendaraan' }}" style="width: 100%; height: 100%; object-fit: cover; display: block;" loading="lazy">
                                <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,0.3) 100%);"></div>
                                <!-- Badge -->
                                @if($rental->vehicle_type)
                                    <span style="position: absolute; top: 12px; left: 12px; background: rgba(0,100,210,0.9); color: white; padding: 0.25rem 0.65rem; border-radius: 6px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; backdrop-filter: 4px;">{{ ucfirst($rental->vehicle_type) }}</span>
                                @endif
                                <span style="position: absolute; top: 12px; right: 12px; background: rgba(0,0,0,0.5); color: white; padding: 0.2rem 0.5rem; border-radius: 6px; font-size: 0.68rem; font-weight: 600; backdrop-filter: 4px;">{{ $rental->route->destination_city ?? 'Jakarta' }}</span>
                            </div>

                            <!-- Vehicle Body -->
                            <div style="padding: 1.125rem;">
                                <h3 style="font-size: 0.95rem; font-weight: 700; color: #0d2147; margin-bottom: 0.5rem;">{{ $rental->route->name ?? 'Rental Kendaraan' }}</h3>

                                <!-- Specs -->
                                <div style="display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 0.875rem;">
                                    <span style="display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.72rem; color: #495057; background: #f8f9fa; padding: 0.25rem 0.55rem; border-radius: 6px; font-weight: 500;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                        {{ $rental->capacity ?? '7' }} orang
                                    </span>
                                    <span style="display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.72rem; color: #495057; background: #f8f9fa; padding: 0.25rem 0.55rem; border-radius: 6px; font-weight: 500;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                                        {{ ucfirst($rental->transmission ?? 'Manual') }}
                                    </span>
                                    <span style="display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.72rem; color: #495057; background: #f8f9fa; padding: 0.25rem 0.55rem; border-radius: 6px; font-weight: 500;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"/></svg>
                                        {{ ucfirst($rental->fuel ?? 'Bensin') }}
                                    </span>
                                </div>

                                <!-- Price Options -->
                                <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                                    <div style="flex: 1; background: var(--trvl-gray-100); border-radius: 8px; padding: 0.5rem 0.65rem; border: 1px solid var(--trvl-border);">
                                        <p style="font-size: 0.65rem; color: #6c757d; font-weight: 500; margin-bottom: 0.15rem;">Tanpa Sopir</p>
                                        <p style="font-size: 0.95rem; font-weight: 800; color: #0064d2;">Rp {{ number_format($rental->price_without_driver, 0, ',', '.') }}</p>
                                        <p style="font-size: 0.6rem; color: #6c757d;">/hari</p>
                                    </div>
                                    <div style="flex: 1; background: #f0fdf4; border-radius: 8px; padding: 0.5rem 0.65rem; border: 1px solid #bbf7d0;">
                                        <p style="font-size: 0.65rem; color: #6c757d; font-weight: 500; margin-bottom: 0.15rem;">Dengan Sopir</p>
                                        <p style="font-size: 0.95rem; font-weight: 800; color: #00a651;">Rp {{ number_format($rental->price_with_driver, 0, ',', '.') }}</p>
                                        <p style="font-size: 0.6rem; color: #6c757d;">/hari</p>
                                    </div>
                                </div>

                                <!-- Description -->
                                @if ($rental->description)
                                    <p style="font-size: 0.78rem; color: #6c757d; margin-bottom: 0.875rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $rental->description }}</p>
                                @endif

                                <!-- Action Button -->
                                @auth
                                    <a href="{{ route('bookings.rental.create', ['route_id' => $rental->route_id]) }}" 
                                       style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; background: linear-gradient(135deg, #0064d2 0%, #004ba0 100%); color: white; padding: 0.75rem; border-radius: 10px; font-weight: 700; font-size: 0.875rem; text-decoration: none; transition: all 0.25s; box-shadow: 0 4px 14px rgba(0,100,210,0.3);">
                                        Sewa Sekarang
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" 
                                       style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; background: white; color: #0064d2; border: 2px solid #0064d2; padding: 0.7rem; border-radius: 10px; font-weight: 700; font-size: 0.875rem; text-decoration: none; transition: all 0.25s;">
                                        Sewa Sekarang
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0064d2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: span 2; background: var(--trvl-card); border-radius: 14px; border: 1px solid var(--trvl-border); padding: 3rem 2rem; text-align: center;">
                            <div style="font-size: 3.5rem; margin-bottom: 1rem;">🚗</div>
                            <p style="font-size: 1rem; font-weight: 700; color: #0d2147;">Belum ada kendaraan tersedia</p>
                            <p style="font-size: 0.85rem; color: #6c757d; margin-top: 0.5rem; line-height: 1.5;">Coba ubah filter atau reset pencarian untuk menemukan kendaraan lainnya.</p>
                            <a href="{{ route('public.rental') }}" 
                               style="display: inline-block; margin-top: 1rem; background: #0064d2; color: white; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: 0.875rem; text-decoration: none;">Reset Filter</a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
                    {{ $rentals->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Hero section */
.rental-hero-section {
    background: linear-gradient(135deg, #0d2147 0%, #1a3a6c 30%, #0064d2 70%, #1e88e5 100%);
}
.dark .rental-hero-section {
    background: linear-gradient(135deg, #0a0a1a 0%, #0d1a3a 30%, #003d80 70%, #0d5ca0 100%);
}
.dark .bg-card { background: var(--trvl-card); }
.dark .bg-section { background: var(--trvl-bg); }
.dark #rental-grid .trvl-form-field { background: var(--trvl-bg); color: var(--trvl-text); }
.dark .dark-stat { background: var(--trvl-card); }
.dark [style*="background: #f8f9fa"] { background: var(--trvl-bg) !important; }
@media (max-width: 900px) {
    #rental-grid { grid-template-columns: 1fr !important; }
    #rental-grid > aside { order: -1; }
    #rental-grid > aside > div { position: static !important; margin-bottom: 1rem; }
    #rental-grid > div > div[style*="grid-template-columns: repeat(2"] {
        grid-template-columns: 1fr !important;
    }
}
@media (max-width: 600px) {
    #rental-grid > div > div[style*="grid-template-columns: repeat(2"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
 @endsection
