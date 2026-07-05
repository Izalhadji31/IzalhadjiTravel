@extends('layouts.public')

@section('title', __('rental.title') . ' - ASR GO')

@section('content')
<!-- HERO SECTION -->
<div class="travel-hero-section" style="padding: 2.5rem 0 2rem;">
    <div class="trvl-container">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: white; letter-spacing: -0.5px;">
                <span style="display:inline-flex; align-items:center; gap:0.4rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"/><circle cx="6.5" cy="16.5" r="2.5"/><circle cx="16.5" cy="16.5" r="2.5"/></svg>
                    Daftar Kendaraan
                </span>
            </h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 0.25rem; font-weight: 400;">Pilih kendaraan yang sesuai dengan kebutuhan Anda</p>
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div style="background: var(--trvl-bg); padding: 1.5rem 0 4rem;">
    <div class="trvl-container">
        <!-- Filter Section -->
        <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); padding: 1.25rem; margin-bottom: 1.5rem;">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 0.75rem; align-items: end;">
                <div>
                    <label class="trvl-field-label">{{ __('rental.vehicle_type') }}</label>
                    <select name="vehicle_type" class="trvl-form-field" style="appearance:none; background-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22><path stroke=%22%236b7280%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%221.5%22 d=%22M6 8l4 4 4-4%22/></svg>'); background-position: right 0.75rem center; background-repeat: no-repeat; background-size: 1.25rem; padding-right: 2.5rem;">
                        <option value="">-- {{ __('rental.vehicle_type_all') }} --</option>
                        @foreach($vehicleTypes as $type)
                            <option value="{{ $type }}" {{ request('vehicle_type') === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="trvl-field-label">Min. {{ __('rental.seats') }}</label>
                    <input type="number" name="min_capacity" placeholder="{{ __('general.no_results') }}" 
                           value="{{ request('min_capacity') }}"
                           class="trvl-form-field">
                </div>
                <div>
                    <label class="trvl-field-label">{{ __('general.sort') }}</label>
                    <select name="sort" class="trvl-form-field" style="appearance:none; background-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22><path stroke=%22%236b7280%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%221.5%22 d=%22M6 8l4 4 4-4%22/></svg>'); background-position: right 0.75rem center; background-repeat: no-repeat; background-size: 1.25rem; padding-right: 2.5rem;">
                        <option value="vehicle_type" {{ request('sort') === 'vehicle_type' ? 'selected' : '' }}>{{ __('rental.vehicle_type') }}</option>
                        <option value="seat_capacity" {{ request('sort') === 'seat_capacity' ? 'selected' : '' }}>{{ __('rental.seats') }}</option>
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>{{ __('general.latest') }}</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="trvl-btn-search" style="width: 100%; justify-content: center; padding: 0.7rem 1rem; font-size: 0.85rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        {{ __('general.search') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Vehicles Grid -->
        @if($vehicles->count())
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem;">
                @foreach($vehicles as $vehicle)
                    @php
                        $unsplashQuery = match($vehicle->vehicle_type) {
                            'Avanza' => 'toyota-avanza',
                            'Innova' => 'toyota-innova',
                            'Hiace' => 'toyota-hiace',
                            'Elf' => 'isuzu-elf',
                            'Xpander' => 'mitsubishi-xpander',
                            'Terios' => 'daihatsu-terios',
                            'Pajero' => 'mitsubishi-pajero',
                            'Alphard' => 'toyota-alphard',
                            default => 'car',
                        };
                        $unsplashUrl = "https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=400&h=260&fit=crop&q=80";
                    @endphp
                    <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); box-shadow: var(--trvl-shadow-sm); overflow: hidden; transition: all 0.3s ease;"
                         onmouseover="this.style.boxShadow='var(--trvl-shadow-lg)'; this.style.borderColor='#bfdbfe';"
                         onmouseout="this.style.boxShadow='var(--trvl-shadow-sm)'; this.style.borderColor='var(--trvl-border)';">
                        <!-- Vehicle Image -->
                        <div style="height: 11rem; background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                            <img src="{{ $unsplashUrl }}" 
                                 alt="{{ $vehicle->vehicle_type }}" 
                                 style="width:100%; height:100%; object-fit:cover; display:block;"
                                 loading="lazy">
                            <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,0.3) 100%); pointer-events: none;"></div>
                            <div style="position: absolute; top: 0.75rem; right: 0.75rem; background: #00a651; color: white; padding: 0.25rem 0.75rem; border-radius: var(--trvl-radius-full); font-size: 0.72rem; font-weight: 700; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                                ✓ Tersedia
                            </div>
                        </div>

                        <!-- Vehicle Info -->
                        <div style="padding: 1.25rem;">
                            <h3 style="font-size: 1rem; font-weight: 700; color: var(--trvl-gray-900); margin-bottom: 0.25rem;">{{ $vehicle->vehicle_type }}</h3>
                            <p style="font-size: 0.78rem; color: var(--trvl-gray-500); font-family: monospace; margin-bottom: 0.75rem;">{{ strtoupper($vehicle->plate_number) }}</p>

                            <!-- Details -->
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; padding: 0.75rem 0; border-top: 1px solid var(--trvl-border); border-bottom: 1px solid var(--trvl-border); margin-bottom: 0.75rem;">
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <span style="font-size: 0.82rem; color: var(--trvl-gray-600);">👥 Kapasitas</span>
                                    <span style="font-weight: 700; color: var(--trvl-gray-900); font-size: 0.85rem;">{{ $vehicle->seat_capacity }} Orang</span>
                                </div>
                                <div style="display: flex; align-items: flex-start; justify-content: space-between;">
                                    <span style="font-size: 0.82rem; color: var(--trvl-gray-600);">👨‍✈️ Pengemudi</span>
                                    <div style="text-align: right;">
                                        <p style="font-weight: 600; color: var(--trvl-gray-900); font-size: 0.82rem;">{{ $vehicle->driver_name }}</p>
                                        <p style="font-size: 0.75rem; color: var(--trvl-gray-500);">{{ $vehicle->driver_phone }}</p>
                                    </div>
                                </div>
                                @if($vehicle->mitra)
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span style="font-size: 0.82rem; color: var(--trvl-gray-600);">🏢 Mitra</span>
                                        <span style="font-size: 0.82rem; font-weight: 600; color: var(--trvl-gray-900);">{{ $vehicle->mitra->name }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Features -->
                            <div style="font-size: 0.78rem; color: var(--trvl-gray-600); display: flex; flex-direction: column; gap: 0.3rem; margin-bottom: 1rem;">
                                ✓ {{ __('rental.ac') }} & Power Steering
                                <p>✓ Asuransi Lengkap</p>
                                <p>✓ Pengemudi Profesional</p>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('login') }}" class="trvl-btn-pesan" style="width: 100%; text-align: center;">
                                {{ __('rental.book') }}
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 2rem; display: flex; justify-content: center;">
                {{ $vehicles->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div style="background: var(--trvl-card); border-radius: var(--trvl-radius-lg); border: 1px solid var(--trvl-border); padding: 3rem 2rem; text-align: center;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🚗</div>
                <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--trvl-gray-900); margin-bottom: 0.5rem;">{{ __('rental.empty') }}</h3>
                <p style="color: var(--trvl-gray-600); margin-bottom: 1.5rem; font-size: 0.9rem;">{{ __('rental.empty_desc') }}</p>
                <a href="{{ route('public.vehicles') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: var(--trvl-blue); color: white; padding: 0.75rem 1.5rem; border-radius: var(--trvl-radius-md); font-weight: 700; font-size: 0.9rem; text-decoration: none; transition: all 0.2s;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 1 18 0 9 9 0 0 1-18 0z"/><polyline points="9 12 12 15 15 12"/></svg>
                    Kembalikan ke Semua Kendaraan
                </a>
            </div>
        @endif
    </div>
</div>

<style>
.travel-hero-section {
    background: linear-gradient(135deg, #0d2147 0%, #1a3a6c 30%, #0064d2 70%, #1e88e5 100%);
}
.dark .travel-hero-section {
    background: linear-gradient(135deg, #0a0a1a 0%, #0d1a3a 30%, #003d80 70%, #0d5ca0 100%);
}
@media (max-width: 600px) {
    form[style*="grid-template-columns"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
