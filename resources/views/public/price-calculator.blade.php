
@extends('layouts.public')

@section('title', 'Cek Harga - ASR GO')

@section('content')
<!-- PRICE CALCULATOR HERO -->
<div style="background: linear-gradient(135deg, #0d2147 0%, #1a3a6c 30%, #0064d2 70%, #1e88e5 100%); padding: 2.5rem 0 2rem;">
    <div class="trvl-container">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: white; letter-spacing: -0.5px;">
                <span style="display:inline-flex; align-items:center; gap:0.4rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    Kalkulator Harga
                </span>
            </h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 0.25rem; font-weight: 400;">Hitung harga perjalanan Anda dengan mudah dan cepat</p>
        </div>
    </div>
</div>

<!-- CALCULATOR BODY -->
<div style="background: #f8f9fa; padding: 0 0 4rem;">
    <div class="trvl-container">
        <div style="max-width: 800px; margin: -1rem auto 0; position: relative; z-index: 2;">

            <!-- Service Type Card -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 1px solid #e9ecef; padding: 1.5rem; margin-bottom: 1.25rem;">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.6rem;">Pilih Layanan</label>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <button type="button" onclick="setService('travel')" id="btn-service-travel"
                            style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 1rem; border-radius: 12px; border: 2px solid #0064d2; background: #e8f4fd; color: #0064d2; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.25s;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0064d2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        Travel
                    </button>
                    <button type="button" onclick="setService('rental')" id="btn-service-rental"
                            style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 1rem; border-radius: 12px; border: 2px solid #dee2e6; background: white; color: #6c757d; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.25s;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"/><circle cx="6.5" cy="16.5" r="2.5"/><circle cx="16.5" cy="16.5" r="2.5"/></svg>
                        Rental Kendaraan
                    </button>
                </div>
            </div>

            <!-- Travel Calculator Form -->
            <div id="travel-section" style="background: white; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 1px solid #e9ecef; padding: 1.5rem; margin-bottom: 1.25rem;">
                <h2 style="font-size: 1.1rem; font-weight: 800; color: #0d2147; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0064d2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/></svg>
                    Travel
                </h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Rute</label>
                        <select id="travel-route" onchange="calculateTravelPrice()" class="trvl-form-field">
                            <option value="" data-price="0">-- Pilih Rute --</option>
                            @foreach ($routes->where('type', 'travel') as $route)
                                <option value="{{ $route->id }}" data-price="{{ $route->travelPrices->first()->price ?? 0 }}" data-origin="{{ $route->origin }}" data-destination="{{ $route->destination }}">
                                    {{ $route->origin }} → {{ $route->destination }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Jumlah Penumpang</label>
                        <select id="travel-passengers" onchange="calculateTravelPrice()" class="trvl-form-field">
                            <option value="1">1 orang</option>
                            <option value="2">2 orang</option>
                            <option value="3">3 orang</option>
                            <option value="4">4 orang</option>
                            <option value="5">5 orang</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Tanggal Berangkat</label>
                        <input type="date" id="travel-date" value="{{ date('Y-m-d') }}" class="trvl-form-field">
                    </div>
                </div>
            </div>

            <!-- Rental Calculator Form -->
            <div id="rental-section" style="background: white; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 1px solid #e9ecef; padding: 1.5rem; margin-bottom: 1.25rem; display: none;">
                <h2 style="font-size: 1.1rem; font-weight: 800; color: #0d2147; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0064d2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"/><circle cx="6.5" cy="16.5" r="2.5"/><circle cx="16.5" cy="16.5" r="2.5"/></svg>
                    Rental Kendaraan
                </h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Tujuan</label>
                        <select id="rental-destination" class="trvl-form-field">
                            <option value="">-- Pilih Tujuan --</option>
                            @php
                                $rentalDestinations = collect();
                                foreach ($routes->where('type', 'rental') as $route) {
                                    if (!$rentalDestinations->contains($route->destination)) {
                                        $rentalDestinations->push($route->destination);
                                    }
                                }
                            @endphp
                            @foreach ($rentalDestinations as $dest)
                                <option value="{{ $dest }}">{{ $dest }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Tipe Kendaraan</label>
                        <select id="rental-vehicle-type" class="trvl-form-field" onchange="calculateRentalPrice()">
                            <option value="standard" data-base="300000">Standard (Rp 300rb/hari)</option>
                            <option value="premium" data-base="500000">Premium (Rp 500rb/hari)</option>
                            <option value="luxury" data-base="1000000">Luxury (Rp 1jt/hari)</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Opsi Sopir</label>
                        <div style="display: flex; gap: 0.75rem; padding: 0.6rem 0;">
                            <label style="display: flex; align-items: center; gap: 0.4rem; cursor: pointer;">
                                <input type="radio" name="driver_option" value="without" onchange="calculateRentalPrice()" checked style="accent-color: #0064d2; width: 16px; height: 16px;">
                                <span style="font-size: 0.9rem; font-weight: 600; color: #495057;">Tanpa Sopir</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.4rem; cursor: pointer;">
                                <input type="radio" name="driver_option" value="with" onchange="calculateRentalPrice()" style="accent-color: #0064d2; width: 16px; height: 16px;">
                                <span style="font-size: 0.9rem; font-weight: 600; color: #495057;">Dengan Sopir (+Rp 150rb/hari)</span>
                            </label>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                        <div>
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Tanggal Mulai</label>
                            <input type="date" id="rental-start-date" value="{{ date('Y-m-d') }}" class="trvl-form-field">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">Durasi (hari)</label>
                            <input type="number" id="rental-days" value="1" min="1" max="30" onchange="calculateRentalPrice()" class="trvl-form-field">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Result Card -->
            <div id="result-section" style="background: linear-gradient(135deg, #0d2147 0%, #1a3a6c 40%, #0064d2 75%, #1e88e5 100%); border-radius: 16px; padding: 1.5rem; box-shadow: 0 10px 40px rgba(0,100,210,0.3); display: none; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; border-radius: 50%; background: radial-gradient(circle, rgba(96,165,250,0.15) 0%, transparent 70%); pointer-events: none;"></div>
                <div style="display: flex; justify-content: space-between; align-items: center; position: relative; z-index: 1;">
                    <div>
                        <p style="font-size: 0.78rem; color: rgba(255,255,255,0.7); font-weight: 500; margin-bottom: 0.25rem;">Total Harga</p>
                        <p id="result-price" style="font-size: 2.5rem; font-weight: 900; color: white; line-height: 1.1;">Rp 0</p>
                        <p id="result-detail" style="font-size: 0.78rem; color: rgba(255,255,255,0.6); margin-top: 0.35rem;">Pilih rute untuk melihat harga</p>
                    </div>
                    <div>
                        @auth
                            <button onclick="proceedToBooking()" 
                                    style="display: inline-flex; align-items: center; gap: 0.5rem; background: white; color: #004ba0; padding: 0.9rem 2rem; border-radius: 10px; font-weight: 800; font-size: 0.95rem; border: none; cursor: pointer; transition: all 0.25s; box-shadow: 0 4px 16px rgba(0,0,0,0.15); text-decoration: none;">
                                Booking Sekarang
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#004ba0" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                        @else
                            <a href="{{ route('login') }}" 
                               style="display: inline-flex; align-items: center; gap: 0.5rem; background: white; color: #004ba0; padding: 0.9rem 2rem; border-radius: 10px; font-weight: 800; font-size: 0.95rem; text-decoration: none; transition: all 0.25s; box-shadow: 0 4px 16px rgba(0,0,0,0.15);">
                                Login & Booking
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#004ba0" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Info Note -->
            <div style="margin-top: 1.25rem; background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border: 1px solid #dbeafe; border-radius: 12px; padding: 1rem 1.25rem;">
                <div style="display: flex; gap: 0.65rem; align-items: flex-start;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0064d2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <p style="font-size: 0.8rem; color: #495057; line-height: 1.6;">
                        <strong>Catatan:</strong> Harga yang ditampilkan adalah estimasi harga dasar. Harga final dapat berubah sesuai dengan kondisi perjalanan, ketersediaan armada, dan kebijakan yang berlaku saat pemesanan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentService = 'travel';
    let currentPrice = 0;
    let basePricePerDay = 300000;

    function setService(service) {
        currentService = service;
        
        // Update button styles
        const travelBtn = document.getElementById('btn-service-travel');
        const rentalBtn = document.getElementById('btn-service-rental');
        
        if (service === 'travel') {
            travelBtn.style.borderColor = '#0064d2';
            travelBtn.style.background = '#e8f4fd';
            travelBtn.style.color = '#0064d2';
            travelBtn.querySelector('svg').setAttribute('stroke', '#0064d2');
            
            rentalBtn.style.borderColor = '#dee2e6';
            rentalBtn.style.background = 'white';
            rentalBtn.style.color = '#6c757d';
            rentalBtn.querySelector('svg').setAttribute('stroke', '#6c757d');
            
            document.getElementById('travel-section').style.display = 'block';
            document.getElementById('rental-section').style.display = 'none';
        } else {
            rentalBtn.style.borderColor = '#0064d2';
            rentalBtn.style.background = '#e8f4fd';
            rentalBtn.style.color = '#0064d2';
            rentalBtn.querySelector('svg').setAttribute('stroke', '#0064d2');
            
            travelBtn.style.borderColor = '#dee2e6';
            travelBtn.style.background = 'white';
            travelBtn.style.color = '#6c757d';
            travelBtn.querySelector('svg').setAttribute('stroke', '#6c757d');
            
            document.getElementById('travel-section').style.display = 'none';
            document.getElementById('rental-section').style.display = 'block';
        }
        
        document.getElementById('result-section').style.display = 'none';
        currentPrice = 0;
    }

    function calculateTravelPrice() {
        const routeSelect = document.getElementById('travel-route');
        const passengers = parseInt(document.getElementById('travel-passengers').value) || 1;
        const selectedOption = routeSelect.options[routeSelect.selectedIndex];
        const pricePerSeat = parseInt(selectedOption.dataset.price || 0);
        
        if (pricePerSeat > 0 && passengers > 0) {
            currentPrice = pricePerSeat * passengers;
            const origin = selectedOption.dataset.origin || '';
            const destination = selectedOption.dataset.destination || '';
            document.getElementById('result-detail').textContent = `${origin} → ${destination} — ${passengers} penumpang`;
            showResult();
        } else {
            document.getElementById('result-section').style.display = 'none';
        }
    }

    function calculateRentalPrice() {
        const destination = document.getElementById('rental-destination').value;
        const vehicleType = document.getElementById('rental-vehicle-type');
        const driverOption = document.querySelector('input[name="driver_option"]:checked').value;
        const days = parseInt(document.getElementById('rental-days').value) || 1;
        
        // Get base price from vehicle type
        const selectedVehicle = vehicleType.options[vehicleType.selectedIndex];
        basePricePerDay = parseInt(selectedVehicle.dataset.base || 300000);
        
        if (!destination) {
            document.getElementById('result-section').style.display = 'none';
            return;
        }
        
        let driverCost = driverOption === 'with' ? 150000 * days : 0;
        currentPrice = (basePricePerDay * days) + driverCost;
        
        const driverLabel = driverOption === 'with' ? 'dengan sopir' : 'tanpa sopir';
        document.getElementById('result-detail').textContent = `${destination} — ${selectedVehicle.text.split('(')[0].trim()} ${driverLabel} (${days} hari)`;
        
        showResult();
    }

    function showResult() {
        document.getElementById('result-price').textContent = 'Rp ' + currentPrice.toLocaleString('id-ID');
        document.getElementById('result-section').style.display = 'block';
    }

    function proceedToBooking() {
        if (currentService === 'travel') {
            const routeId = document.getElementById('travel-route').value;
            if (routeId) {
                window.location.href = `{{ route('bookings.travel.create') }}?route_id=${routeId}`;
            }
        } else {
            const destination = document.getElementById('rental-destination').value;
            const vehicleType = document.getElementById('rental-vehicle-type').value;
            const driverOption = document.querySelector('input[name="driver_option"]:checked').value;
            const days = document.getElementById('rental-days').value;
            if (destination) {
                window.location.href = `{{ route('bookings.rental.create') }}?destination=${destination}&vehicle_type=${vehicleType}&driver=${driverOption}&days=${days}`;
            }
        }
    }
</script>
 @endsection
