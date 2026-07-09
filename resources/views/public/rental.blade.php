
@extends('layouts.public')

@section('title', __('rental.title') . ' - ASR GO')

@section('content')
@php
    $baseArmada = [
        ['nama' => 'Toyota Avanza (New)', 'kursi' => 6, 'transmisi' => 'Manual', 'harga' => 350000, 'tahun' => 2019, 'plat' => 'EB 1234 AB', 'img' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Toyota Avanza (All New)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 400000, 'tahun' => 2022, 'plat' => 'EB 5678 CD', 'img' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Toyota Rush (S)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 450000, 'tahun' => 2020, 'plat' => 'EB 9012 EF', 'img' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Toyota Rush (GR)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 500000, 'tahun' => 2022, 'plat' => 'EB 3456 GH', 'img' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Toyota Innova (G)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 500000, 'tahun' => 2020, 'plat' => 'EB 7890 IJ', 'img' => 'https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Toyota Innova (Reborn)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 600000, 'tahun' => 2022, 'plat' => 'EB 2345 KL', 'img' => 'https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Toyota Innova (Venturer)', 'kursi' => 7, 'transmisi' => 'Automatic', 'harga' => 750000, 'tahun' => 2023, 'plat' => 'EB 6789 MN', 'img' => 'https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Toyota Hiace (Premio)', 'kursi' => 12, 'transmisi' => 'Manual', 'harga' => 800000, 'tahun' => 2020, 'plat' => 'EB 0123 OP', 'img' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Toyota Hiace (Royale)', 'kursi' => 12, 'transmisi' => 'Manual', 'harga' => 1000000, 'tahun' => 2022, 'plat' => 'EB 1122 QR', 'img' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Honda Brio (Satya)', 'kursi' => 4, 'transmisi' => 'Manual', 'harga' => 250000, 'tahun' => 2021, 'plat' => 'EB 3344 ST', 'img' => 'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Honda Brio (RS)', 'kursi' => 4, 'transmisi' => 'Automatic', 'harga' => 300000, 'tahun' => 2023, 'plat' => 'EB 5566 UV', 'img' => 'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Honda Mobilio (E)', 'kursi' => 6, 'transmisi' => 'Manual', 'harga' => 350000, 'tahun' => 2020, 'plat' => 'EB 7788 WX', 'img' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Honda Mobilio (RS)', 'kursi' => 6, 'transmisi' => 'Manual', 'harga' => 400000, 'tahun' => 2022, 'plat' => 'EB 9900 YZ', 'img' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Daihatsu Grand Max (Blind Van)', 'kursi' => 2, 'transmisi' => 'Manual', 'harga' => 300000, 'tahun' => 2020, 'plat' => 'EB 1112 AB', 'img' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Daihatsu Grand Max (Pickup)', 'kursi' => 2, 'transmisi' => 'Manual', 'harga' => 350000, 'tahun' => 2021, 'plat' => 'EB 1314 CD', 'img' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Daihatsu Grand Max (Minibus)', 'kursi' => 8, 'transmisi' => 'Manual', 'harga' => 400000, 'tahun' => 2022, 'plat' => 'EB 1516 EF', 'img' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Toyota Hilux (E)', 'kursi' => 4, 'transmisi' => 'Manual', 'harga' => 600000, 'tahun' => 2021, 'plat' => 'EB 1718 GH', 'img' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Toyota Hilux (V)', 'kursi' => 4, 'transmisi' => 'Manual', 'harga' => 700000, 'tahun' => 2023, 'plat' => 'EB 1920 IJ', 'img' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Daihatsu Terios (X)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 400000, 'tahun' => 2020, 'plat' => 'EB 2122 KL', 'img' => 'https://images.unsplash.com/photo-1543465077-db45b34b70a4?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Daihatsu Terios (R)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 450000, 'tahun' => 2022, 'plat' => 'EB 2324 MN', 'img' => 'https://images.unsplash.com/photo-1543465077-db45b34b70a4?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Suzuki Ertiga (GX)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 350000, 'tahun' => 2020, 'plat' => 'EB 2526 OP', 'img' => 'https://images.unsplash.com/photo-1550355291-bedd4e5a8e4c?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Suzuki Ertiga (Sport)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 400000, 'tahun' => 2022, 'plat' => 'EB 2728 QR', 'img' => 'https://images.unsplash.com/photo-1550355291-bedd4e5a8e4c?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Mitsubishi Xpander (GLS)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 450000, 'tahun' => 2021, 'plat' => 'EB 2930 ST', 'img' => 'https://images.unsplash.com/photo-1568844293986-8d0400bd4745?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Mitsubishi Xpander (Ultimate)', 'kursi' => 7, 'transmisi' => 'Automatic', 'harga' => 550000, 'tahun' => 2023, 'plat' => 'EB 3132 UV', 'img' => 'https://images.unsplash.com/photo-1568844293986-8d0400bd4745?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Toyota Fortuner (SRV)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 1000000, 'tahun' => 2021, 'plat' => 'EB 3334 WX', 'img' => 'https://images.unsplash.com/photo-1550353127-b0da98aeaa0e?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Toyota Fortuner (VRZ)', 'kursi' => 7, 'transmisi' => 'Automatic', 'harga' => 1300000, 'tahun' => 2023, 'plat' => 'EB 3536 YZ', 'img' => 'https://images.unsplash.com/photo-1550353127-b0da98aeaa0e?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Honda HR-V (E)', 'kursi' => 5, 'transmisi' => 'Automatic', 'harga' => 700000, 'tahun' => 2021, 'plat' => 'EB 3738 AB', 'img' => 'https://images.unsplash.com/photo-1568844293986-8d0400bd4745?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Honda HR-V (SE)', 'kursi' => 5, 'transmisi' => 'Automatic', 'harga' => 800000, 'tahun' => 2023, 'plat' => 'EB 3940 CD', 'img' => 'https://images.unsplash.com/photo-1568844293986-8d0400bd4745?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Mitsubishi Pajero Sport (Dakar)', 'kursi' => 7, 'transmisi' => 'Automatic', 'harga' => 1400000, 'tahun' => 2023, 'plat' => 'EB 4142 EF', 'img' => 'https://images.unsplash.com/photo-1550353127-b0da98aeaa0e?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Isuzu Elf (NLR)', 'kursi' => 15, 'transmisi' => 'Manual', 'harga' => 900000, 'tahun' => 2021, 'plat' => 'EB 4344 GH', 'img' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Toyota Calya (E)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 300000, 'tahun' => 2020, 'plat' => 'EB 4546 IJ', 'img' => 'https://images.unsplash.com/photo-1543465077-db45b34b70a4?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Daihatsu Sigra (X)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 300000, 'tahun' => 2021, 'plat' => 'EB 4748 KL', 'img' => 'https://images.unsplash.com/photo-1550355291-bedd4e5a8e4c?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Toyota Agya (G)', 'kursi' => 4, 'transmisi' => 'Manual', 'harga' => 200000, 'tahun' => 2022, 'plat' => 'EB 4950 MN', 'img' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=900&q=80'],
        ['nama' => 'Nissan Livina (High)', 'kursi' => 7, 'transmisi' => 'Manual', 'harga' => 400000, 'tahun' => 2020, 'plat' => 'EB 5152 OP', 'img' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=900&q=80'],
    ];

    $getType = function($name) {
        $n = strtolower($name);
        if (str_contains($n, 'avanza') || str_contains($n, 'innova') || str_contains($n, 'mobilio') || str_contains($n, 'ertiga') || str_contains($n, 'xpander') || str_contains($n, 'calya') || str_contains($n, 'sigra') || str_contains($n, 'livina')) return 'MPV';
        if (str_contains($n, 'rush') || str_contains($n, 'terios') || str_contains($n, 'fortuner') || str_contains($n, 'hr-v') || str_contains($n, 'pajero')) return 'SUV';
        if (str_contains($n, 'brio') || str_contains($n, 'agya')) return 'Hatchback';
        if (str_contains($n, 'hiace') || str_contains($n, 'elf') || str_contains($n, 'minibus')) return 'Minibus';
        if (str_contains($n, 'pickup') || str_contains($n, 'blind van') || str_contains($n, 'hilux')) return 'Commercial';
        return 'Lainnya';
    };

    foreach ($baseArmada as &$k) {
        $k['type'] = $getType($k['nama']);
    }
    unset($k);

    $vehicleTypes = collect($baseArmada)->pluck('type')->unique()->sort()->values()->all();

    $armadaRental = $baseArmada;
    $reqType = request('vehicle_type');
    $reqCap = request('min_capacity');

    if ($reqType || $reqCap) {
        $armadaRental = array_filter($armadaRental, function($k) use ($reqType, $reqCap) {
            $match = true;
            if ($reqType && strtolower($k['type']) !== strtolower($reqType)) $match = false;
            if ($reqCap && $k['kursi'] < $reqCap) $match = false;
            return $match;
        });
    }
@endphp
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
        <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;" id="rental-grid">

            <!-- VEHICLE LISTING -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding: 0 0.25rem;">
                    <p style="font-size: 0.875rem; color: #6c757d; font-weight: 500;">
                        <span style="font-weight: 700; color: #0d2147;">{{ count($armadaRental) }}</span> kendaraan tersedia
                    </p>
                </div>



                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
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
                                @auth
                                    <a href="{{ route('bookings.rental.create', ['vehicle' => $kendaraan['nama']]) }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; background: linear-gradient(135deg, #0064d2 0%, #004ba0 100%); color: white; padding: 0.8rem; border-radius: 12px; font-weight: 700; font-size: 0.9rem; text-decoration: none; transition: all 0.25s; box-shadow: 0 4px 14px rgba(0,100,210,0.3);">
                                        Sewa Sekarang
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; background: linear-gradient(135deg, #0064d2 0%, #004ba0 100%); color: white; padding: 0.8rem; border-radius: 12px; font-weight: 700; font-size: 0.9rem; text-decoration: none; transition: all 0.25s; box-shadow: 0 4px 14px rgba(0,100,210,0.3);">
                                        Sewa Sekarang
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                    </a>
                                @endauth
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
