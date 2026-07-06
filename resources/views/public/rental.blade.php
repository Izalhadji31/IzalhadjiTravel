
@extends('layouts.public')

@section('title', __('rental.title') . ' - ASR GO')

@section('content')
<!-- RENTAL HERO -->
<div class="rental-hero-section" style="padding: 2.5rem 0 2rem;" id="layanan">
    <div class="trvl-container">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: white; letter-spacing: -0.5px;">
                <span style="display:inline-flex; align-items:center; gap:0.4rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"/><circle cx="6.5" cy="16.5" r="2.5"/><circle cx="16.5" cy="16.5" r="2.5"/></svg>
                    {{ __('rental.title') }}
                </span>
            </h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 0.25rem; font-weight: 400;">{{ __('rental.subtitle') }}</p>
        </div>
        <form method="GET" action="{{ route('public.rental') }}" style="background: var(--trvl-card); border-radius: 16px; padding: 1.25rem; box-shadow: 0 20px 50px rgba(0,0,0,0.15);">
            <div style="display: grid; grid-template-columns: repeat(3, minmax(190px, 1fr)); gap: 0.75rem; align-items: end;">
                <div>
                    <label class="trvl-field-label">{{ __('rental.vehicle_type') }}</label>
                    <select name="vehicle_type" class="trvl-form-field">
                        <option value="">{{ __('rental.vehicle_type_all') }}</option>
                        @foreach ($vehicleTypes as $type)
                            <option value="{{ $type }}" {{ request('vehicle_type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="trvl-field-label">Min. {{ __('rental.seats') }}</label>
                    <input type="number" name="min_capacity" placeholder="Contoh: 6" value="{{ request('min_capacity') }}" class="trvl-form-field">
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
                        <h3 style="font-size: 0.9rem; font-weight: 700; color: #0d2147;">{{ __('rental.filter_title') }}</h3>
                    </div>
                    <form method="GET" action="{{ route('public.rental') }}">
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.5rem;">{{ __('rental.vehicle_type') }}</label>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                @foreach ($vehicleTypes as $type)
                                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.4rem 0.6rem; border-radius: 8px; transition: all 0.15s; {{ request('vehicle_type') == $type ? 'background: #e8f4fd;' : '' }}" onmouseover="this.style.background='#f0f6ff';" onmouseout="this.style.background='{{ request('vehicle_type') == $type ? '#e8f4fd' : 'transparent' }}';">
                                        <input type="radio" name="vehicle_type" value="{{ $type }}" {{ request('vehicle_type') == $type ? 'checked' : '' }} style="accent-color: #0064d2;">
                                        <span style="font-size: 0.85rem; font-weight: 600; color: #0d2147;">{{ ucfirst($type) }}</span>
                                    </label>
                                @endforeach
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.4rem 0.6rem; border-radius: 8px; {{ !request('vehicle_type') ? 'background: #e8f4fd;' : '' }}">
                                    <input type="radio" name="vehicle_type" value="" {{ !request('vehicle_type') ? 'checked' : '' }} style="accent-color: #0064d2;">
                                    <span style="font-size: 0.85rem; font-weight: 600; color: #0d2147;">{{ __('rental.vehicle_type_all') }}</span>
                                </label>
                            </div>
                        </div>
                        <div style="margin-bottom: 1rem; padding-top: 1rem; border-top: 1px solid var(--trvl-border);">
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.5rem;">Min. {{ __('rental.seats') }}</label>
                            <input type="number" name="min_capacity" value="{{ request('min_capacity') }}" placeholder="6" class="trvl-form-field" style="width: 100%;">
                        </div>
                        <div style="margin-top: 1.25rem; display: flex; gap: 0.5rem;">
                            <button type="submit" style="flex: 1; background: #0064d2; color: white; padding: 0.7rem 1rem; border-radius: 8px; font-weight: 700; font-size: 0.85rem; border: none; cursor: pointer;">Terapkan</button>
                            <a href="{{ route('public.rental') }}" style="background: #e9ecef; color: #6c757d; padding: 0.7rem 1rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem; text-decoration: none;">Reset</a>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- VEHICLE LISTING -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding: 0 0.25rem;">
                    <p style="font-size: 0.875rem; color: #6c757d; font-weight: 500;">
                        <span style="font-weight: 700; color: #0d2147;">20</span> kendaraan tersedia
                    </p>
                </div>

                @php
                    $armadaRental = [
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
                @endphp

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                    @foreach($armadaRental as $kendaraan)
                        <div style="background: var(--trvl-card); border-radius: 14px; border: 1px solid var(--trvl-border); box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);"
                             onmouseover="this.style.boxShadow='0 8px 30px rgba(0,100,210,0.15)'; this.style.borderColor='#dbeafe'; this.style.transform='translateY(-4px)';"
                             onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.06)'; this.style.borderColor='var(--trvl-border)'; this.style.transform='translateY(0)';">

                            <div style="height: 160px; position: relative; overflow: hidden;">
                                <img src="{{ $kendaraan['img'] }}" alt="{{ $kendaraan['nama'] }}" style="width: 100%; height: 100%; object-fit: cover; display: block;" loading="lazy">
                                <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, transparent 35%, rgba(0,0,0,0.3) 100%);"></div>
                            </div>

                            <div style="padding: 1.15rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                                    <h3 style="font-size: 1rem; font-weight: 700; color: #0d2147; margin: 0;">{{ $kendaraan['nama'] }}</h3>
                                    <span style="font-size: 0.65rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: 9999px; background: #e8f4fd; color: #0064d2; white-space: nowrap;">{{ $kendaraan['transmisi'] }}</span>
                                </div>
                                <p style="font-size: 0.8rem; color: #6c757d; margin-bottom: 0.6rem;">{{ $kendaraan['plat'] }}</p>
                                <div style="display: flex; gap: 0.5rem; margin-bottom: 0.8rem;">
                                    <span style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.72rem; color: #495057; background: #f8f9fa; padding: 0.4rem 0.7rem; border-radius: 8px;">👥 {{ $kendaraan['kursi'] }} Kursi</span>
                                    <span style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.72rem; color: #495057; background: #f8f9fa; padding: 0.4rem 0.7rem; border-radius: 8px;">❄️ AC</span>
                                </div>
                                <div style="margin-bottom: 0.85rem;">
                                    <span style="font-size: 1.1rem; font-weight: 800; color: #0064d2;">Rp {{ number_format($kendaraan['harga'], 0, ',', '.') }}</span>
                                    <span style="font-size: 0.72rem; color: #6c757d;"> /hari</span>
                                </div>
                                <a href="{{ route('login') }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; background: linear-gradient(135deg, #0064d2 0%, #004ba0 100%); color: white; padding: 0.8rem; border-radius: 12px; font-weight: 700; font-size: 0.9rem; text-decoration: none; transition: all 0.25s; box-shadow: 0 4px 14px rgba(0,100,210,0.3);">
                                    Sewa Sekarang
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
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
    #rental-grid > div > div[style*="grid-template-columns: repeat(3"] {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}
@media (max-width: 600px) {
    #rental-grid > div > div[style*="grid-template-columns: repeat(3"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
 @endsection
