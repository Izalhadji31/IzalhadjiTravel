
@extends('layouts.public')

@section('title', 'Daftar Kendaraan - ASR GO')

@section('content')
<!-- HERO SECTION -->
<div style="background: linear-gradient(135deg, #0d2147 0%, #1a3a6c 30%, #0064d2 70%, #1e88e5 100%); padding: 2.5rem 0 2rem;">
    <div class="trvl-container">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: white; letter-spacing: -0.5px;">
                <span style="display:inline-flex; align-items:center; gap:0.4rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"/><circle cx="6.5" cy="16.5" r="2.5"/><circle cx="16.5" cy="16.5" r="2.5"/></svg>
                    {{ __('vehicles.title') }}
                </span>
            </h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 0.25rem; font-weight: 400;">{{ __('vehicles.subtitle') }}</p>
    <div class="trvl-container">
        @php
            $armada = [
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

            // Filter by jumlah kursi
            $filterKursi = request('kursi');
            $filterTahun = request('tahun');
            $filtered = $armada;
            if ($filterKursi) {
                $filtered = array_filter($filtered, fn($m) => $m['kursi'] == $filterKursi);
            }
            if ($filterTahun) {
                $filtered = array_filter($filtered, fn($m) => $m['tahun'] == $filterTahun);
            }
            $tahunList = array_unique(array_column($armada, 'tahun'));
            rsort($tahunList);
            $kursiList = array_unique(array_column($armada, 'kursi'));
            sort($kursiList);
        @endphp

        <!-- Filter -->
        <div style="background: var(--trvl-card); border-radius: 16px; border: 1px solid var(--trvl-border); padding: 1.25rem; margin-bottom: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 0.75rem; align-items: end;">
                <div>
                    <label style="display:block; font-size:0.72rem; font-weight:600; color:var(--trvl-gray-700); margin-bottom:0.3rem;">{{ __('vehicles.filter_seats') }}</label>
                    <select name="kursi" style="width:100%; padding:0.6rem 0.8rem; border:1.5px solid var(--trvl-border); border-radius:8px; font-size:0.82rem; background: var(--trvl-card); color: var(--trvl-text); cursor:pointer; appearance:none;" onchange="this.form.submit()">
                        <option value="">{{ __('vehicles.all_seats') }}</option>
                        @foreach($kursiList as $k)
                            <option value="{{ $k }}" {{ request('kursi') == $k ? 'selected' : '' }}>{{ $k }} {{ __('rental.seats') }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:0.72rem; font-weight:600; color:var(--trvl-gray-700); margin-bottom:0.3rem;">{{ __('vehicles.filter_year') }}</label>
                    <select name="tahun" style="width:100%; padding:0.6rem 0.8rem; border:1.5px solid var(--trvl-border); border-radius:8px; font-size:0.82rem; background: var(--trvl-card); color: var(--trvl-text); cursor:pointer; appearance:none;" onchange="this.form.submit()">
                        <option value="">{{ __('vehicles.all_years') }}</option>
                        @foreach($tahunList as $t)
                            <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:0.72rem; font-weight:600; color:var(--trvl-gray-700); margin-bottom:0.3rem;">&nbsp;</label>
                    <a href="{{ route('public.vehicles') }}" style="display:flex; align-items:center; justify-content:center; gap:0.3rem; width:100%; padding:0.6rem 0.8rem; border:1.5px solid var(--trvl-border); border-radius:8px; font-size:0.82rem; color:var(--trvl-text); background: var(--trvl-card); text-decoration:none; font-weight:600;">{{ __('vehicles.reset') }}</a>
                </div>
            </form>
        </div>

        <!-- Results count -->
        <p style="font-size:0.85rem; color:var(--trvl-gray-600); margin-bottom:1rem;">
            <span style="font-weight:700; color:var(--trvl-text);">{{ count($filtered) }}</span> {{ __('vehicles.found') }}

        <!-- Vehicle Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem;">
            @foreach($filtered as $kendaraan)
            <div style="background: var(--trvl-card); border-radius: 16px; border: 1px solid var(--trvl-border); box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden; transition: all 0.3s ease;"
                 onmouseover="this.style.boxShadow='0 4px 20px rgba(0,100,210,0.12)'; this.style.borderColor='#bfdbfe';"
                 onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.06)'; this.style.borderColor='var(--trvl-border)';">
                <div style="height: 180px; overflow: hidden; position:relative;">
                    <img src="{{ $kendaraan['img'] }}" alt="{{ $kendaraan['nama'] }}" style="width:100%; height:100%; object-fit:cover;" loading="lazy">
                    <div style="position:absolute; top:0.75rem; right:0.75rem; background: var(--trvl-green); color:white; padding:0.2rem 0.7rem; border-radius:20px; font-size:0.7rem; font-weight:700;">{{ __('vehicles.available_now') }}</div>
                </div>
                <div style="padding: 1rem;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.3rem;">
                        <h3 style="font-size:0.95rem; font-weight:700; color:var(--trvl-text); margin:0;">{{ $kendaraan['nama'] }}</h3>
                        <span style="font-size:0.6rem; font-weight:600; padding:0.2rem 0.6rem; border-radius:20px; background: var(--trvl-blue-light); color: var(--trvl-blue);">{{ $kendaraan['transmisi'] }}</span>
                    </div>
                    <p style="font-size:0.75rem; color:var(--trvl-gray-600); margin-bottom:0.75rem;">{{ $kendaraan['plat'] }} • {{ $kendaraan['tahun'] }}</p>

                    <div style="display:flex; align-items:center; gap:1rem; padding:0.6rem 0; border-top:1px solid var(--trvl-border); border-bottom:1px solid var(--trvl-border); margin-bottom:0.75rem;">
                        <span style="font-size:0.8rem; color:var(--trvl-gray-600);">{{ $kendaraan['kursi'] }} {{ __('rental.seats') }}</span>
                        <span style="font-size:0.8rem; color:var(--trvl-gray-600);">{{ __('vehicles.ac') }}</span>
                    </div>

                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <div>
                            <span style="font-size:0.7rem; color:var(--trvl-gray-600);">{{ __('vehicles.starting') }}</span>
                            <p style="font-size:1.1rem; font-weight:800; color:var(--trvl-blue); margin:0;">Rp{{ number_format($kendaraan['harga'], 0, ',', '.') }}</p>
                            <span style="font-size:0.65rem; color:var(--trvl-gray-500);">{{ __('price_calc.per_day') }}</span>
                        </div>
                        <a href="{{ route('login') }}" style="display:inline-flex; align-items:center; gap:0.3rem; background:linear-gradient(135deg,var(--trvl-blue) 0%, var(--trvl-blue-dark) 100%); color:white; padding:0.55rem 1rem; border-radius:8px; font-weight:700; font-size:0.8rem; text-decoration:none; box-shadow:0 4px 14px rgba(0,100,210,0.3);">
                            {{ __('vehicles.rent') }}
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if(!count($filtered))
        <div style="background: var(--trvl-card); border-radius: 16px; border: 1px solid var(--trvl-border); padding: 3rem 2rem; text-align: center;">
            <p style="font-size:1rem; font-weight:700; color:var(--trvl-text); margin-bottom:0.5rem;">{{ __('vehicles.no_vehicle') }}</p>
            <p style="font-size:0.85rem; color:var(--trvl-gray-600);">{{ __('vehicles.change_filter') }}</p>
            <a href="{{ route('public.vehicles') }}" style="display:inline-block; margin-top:1rem; background: var(--trvl-blue); color:white; padding:0.65rem 1.5rem; border-radius:8px; font-weight:600; font-size:0.85rem; text-decoration:none;">{{ __('vehicles.reset_filter') }}</a>
        </div>
        @endif
    </div>
</div>
@endsection
