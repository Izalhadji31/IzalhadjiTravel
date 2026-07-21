
@extends('layouts.public')

@section('title', __('airport.title') . ' - ASR GO')

@section('content')
<style>
.airport-row-even { background: var(--trvl-card); }
.airport-row-odd { background: var(--trvl-gray-100); }
</style>
<!-- HEADER -->
<div style="background: linear-gradient(135deg, #0d2147 0%, #1a3a6c 30%, #0064d2 70%, #1e88e5 100%); padding: 2.5rem 0 2rem;">
    <div class="trvl-container">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: white; letter-spacing: -0.5px;">
                <span style="display:inline-flex; align-items:center; gap:0.4rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5m0 0L7 10m5-5l5 5"/></svg>
                    {{ __('airport.title') }}
                </span>
            </h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 0.25rem;">{{ __('airport.subtitle') }}</p>
        </div>

        <!-- Booking Form -->
        <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 20px 50px rgba(0,0,0,0.15); max-width: 700px; margin: 0 auto;">
            <form id="airportForm" onsubmit="return kirimWA()">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display:block; font-size:0.75rem; font-weight:600; color:#495057; margin-bottom:0.3rem;">{{ __('airport.service_type') }}</label>
                        <select id="tipe" required style="width:100%; padding:0.65rem 0.8rem; border:1.5px solid #e9ecef; border-radius:8px; font-size:0.85rem; background:white;">
                            <option value="pickup">{{ __('airport.service_pickup') }}</option>
                            <option value="dropoff">{{ __('airport.service_dropoff') }}</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.75rem; font-weight:600; color:#495057; margin-bottom:0.3rem;">{{ __('airport.pick_vehicle') }}</label>
                        <select id="mobil" required style="width:100%; padding:0.65rem 0.8rem; border:1.5px solid #e9ecef; border-radius:8px; font-size:0.85rem; background:white;">
                            <option value="agya" data-name="Agya / Calya" data-price="30000">Agya / Calya - Rp30.000</option>
                            <option value="brio" data-name="Brio" data-price="35000">Brio - Rp35.000</option>
                            <option value="avanza" data-name="Avanza / Mobilio / Sigra" data-price="50000" selected>Avanza / Mobilio / Sigra - Rp50.000</option>
                            <option value="xpander" data-name="Xpander / Terios / Ertiga" data-price="70000">Xpander / Terios / Ertiga - Rp70.000</option>
                            <option value="innova" data-name="Innova / Rush" data-price="100000">Innova / Rush - Rp100.000</option>
                            <option value="fortuner" data-name="Fortuner / Pajero" data-price="150000">Fortuner / Pajero - Rp150.000</option>
                            <option value="hiace" data-name="Hiace / Elf" data-price="200000">Hiace / Elf - Rp200.000</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.75rem; font-weight:600; color:#495057; margin-bottom:0.3rem;">{{ __('airport.date') }}</label>
                        <input type="date" id="tanggal" required value="{{ date('Y-m-d') }}" style="width:100%; padding:0.65rem 0.8rem; border:1.5px solid #e9ecef; border-radius:8px; font-size:0.85rem;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.75rem; font-weight:600; color:#495057; margin-bottom:0.3rem;">{{ __('airport.time') }}</label>
                        <input type="time" id="jam" required value="08:00" style="width:100%; padding:0.65rem 0.8rem; border:1.5px solid #e9ecef; border-radius:8px; font-size:0.85rem;">
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <label style="display:block; font-size:0.75rem; font-weight:600; color:#495057; margin-bottom:0.3rem;">{{ __('airport.full_name') }}</label>
                        <input type="text" id="nama" required placeholder="{{ __('airport.full_name_placeholder') }}" style="width:100%; padding:0.65rem 0.8rem; border:1.5px solid #e9ecef; border-radius:8px; font-size:0.85rem;">
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <label style="display:block; font-size:0.75rem; font-weight:600; color:#495057; margin-bottom:0.3rem;">{{ __('airport.whatsapp_number') }}</label>
                        <input type="tel" id="nowa" required placeholder="{{ __('airport.whatsapp_placeholder') }}" style="width:100%; padding:0.65rem 0.8rem; border:1.5px solid #e9ecef; border-radius:8px; font-size:0.85rem;">
                    </div>
                </div>
                <button type="submit" style="width:100%; margin-top:1rem; background:linear-gradient(135deg,#0064d2,#004ba0); color:white; padding:0.85rem; border:none; border-radius:10px; font-weight:700; font-size:0.95rem; cursor:pointer; box-shadow:0 4px 14px rgba(0,100,210,0.3);">
                    {{ __('airport.book_via_whatsapp') }}
                </button>
            </form>
        </div>
    </div>
</div>

<!-- PRICING TABLE -->
<div style="background: var(--trvl-bg); padding: 3rem 0;">
    <div class="trvl-container">
        <div style="text-align:center; margin-bottom:2rem;">
            <span style="display:inline-block; background:#e8f4fd; color:#0064d2; font-size:0.75rem; font-weight:700; padding:0.35rem 1rem; border-radius:20px;">{{ __('airport.pricing_title') }}</span>
            <h2 style="font-size:1.5rem; font-weight:800; color:var(--trvl-text); margin-top:0.75rem;">{{ __('airport.pricing_title') }}</h2>
            <p style="color:var(--trvl-gray-600); font-size:0.85rem; margin-top:0.25rem;">{{ __('airport.pricing_desc') }}</p>
        </div>
        <div style="max-width:500px; margin:0 auto; background:var(--trvl-card); border-radius:16px; border:1px solid var(--trvl-border); overflow:hidden;">
            @php
                $hargaAirport = [
                    ['Agya / Calya / Sigra', '4', 'Rp30.000'],
                    ['Brio', '4', 'Rp35.000'],
                    ['Avanza / Mobilio', '6', 'Rp50.000'],
                    ['Xpander / Terios / Ertiga', '7', 'Rp70.000'],
                    ['Innova / Rush', '7', 'Rp100.000'],
                    ['Fortuner / Pajero', '7', 'Rp150.000'],
                    ['Hiace / Elf', '12-15', 'Rp200.000'],
                ];
            @endphp
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#0064d2; color:white;">
                        <th style="padding:12px 16px; text-align:left; font-size:0.8rem;">{{ __('airport.table_vehicle') }}</th>
                        <th style="padding:12px 16px; text-align:center; font-size:0.8rem;">{{ __('airport.table_seats') }}</th>
                        <th style="padding:12px 16px; text-align:right; font-size:0.8rem;">{{ __('airport.table_price') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hargaAirport as $i => $h)
                    <tr class="{{ $i % 2 == 0 ? 'airport-row-even' : 'airport-row-odd' }}">
                        <td style="padding:10px 16px; font-size:0.85rem; font-weight:600; color:var(--trvl-text);">{{ $h[0] }}</td>
                        <td style="padding:10px 16px; text-align:center; font-size:0.8rem; color:var(--trvl-gray-600);">{{ $h[1] }}</td>
                        <td style="padding:10px 16px; text-align:right; font-size:0.85rem; font-weight:700; color:var(--trvl-blue);">{{ $h[2] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function kirimWA() {
    var tipe = document.getElementById('tipe').value;
    var tipeText = tipe === "pickup" ? "{{ __('airport.service_pickup') }}" : "{{ __('airport.service_dropoff') }}";
    var mobilOption = document.getElementById('mobil').selectedOptions[0];
    var namaMobil = mobilOption.dataset.name;
    var harga = mobilOption.dataset.price;
    var tanggal = document.getElementById('tanggal').value;
    var jam = document.getElementById('jam').value;
    var nama = document.getElementById('nama').value;
    var nowa = document.getElementById('nowa').value;

    var pesan = "{{ __('airport.wa_message_intro') }}\n\n";
    pesan += "{{ __('airport.wa_message_service') }}: " + tipeText + "\n";
    pesan += "{{ __('airport.wa_message_vehicle') }}: " + namaMobil + "\n";
    pesan += "{{ __('airport.wa_message_price') }}: Rp" + Number(harga).toLocaleString('id-ID') + "\n";
    pesan += "{{ __('airport.wa_message_date') }}: " + tanggal + "\n";
    pesan += "{{ __('airport.wa_message_time') }}: " + jam + "\n";
    pesan += "{{ __('airport.wa_message_name') }}: " + nama + "\n";
    pesan += "{{ __('airport.wa_message_whatsapp') }}: " + nowa;

    window.location.href = "https://wa.me/6283156408078?text=" + encodeURIComponent(pesan);
    return false;
}
</script>
@endsection
