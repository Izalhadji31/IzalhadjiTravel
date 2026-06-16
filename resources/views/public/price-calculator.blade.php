@extends('layouts.app')

@section('title', 'Cek Harga - ASR GO')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Kalkulator Harga</h1>
                <p class="text-xl text-gray-600">Hitung harga perjalanan Anda dengan mudah</p>
            </div>

            <!-- Calculator Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <!-- Service Selector -->
                <div class="mb-8">
                    <label class="block text-sm font-bold text-gray-900 mb-4">Pilih Layanan</label>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" onclick="setService('travel')" 
                                class="service-btn active px-6 py-4 rounded-lg border-2 border-blue-600 bg-blue-50 text-blue-600 font-semibold transition-all"
                                data-service="travel">
                            🚐 Travel Antar Kota
                        </button>
                        <button type="button" onclick="setService('rental')" 
                                class="service-btn px-6 py-4 rounded-lg border-2 border-gray-300 bg-white text-gray-700 font-semibold transition-all"
                                data-service="rental">
                            🚗 Sewa Kendaraan
                        </button>
                    </div>
                </div>

                <!-- Travel Section -->
                <div id="travel-section" class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Pilih Rute</label>
                        <select id="travel-route" onchange="calculatePrice()" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                            <option value="">-- Pilih Rute --</option>
                            @foreach ($routes->where('type', 'travel') as $route)
                                <option value="{{ $route->id }}" data-price="{{ $route->travelPrices->first()->price ?? 0 }}">
                                    {{ $route->origin }} → {{ $route->destination }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Rental Section -->
                <div id="rental-section" class="space-y-6 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Tujuan</label>
                            <select id="rental-destination" onchange="calculatePrice()" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                <option value="">-- Pilih Tujuan --</option>
                                @php
                                    $destinations = collect();
                                    foreach ($routes->where('type', 'rental') as $route) {
                                        if (!$destinations->contains($route->destination)) {
                                            $destinations->push($route->destination);
                                        }
                                    }
                                @endphp
                                @foreach ($destinations as $dest)
                                    <option value="{{ $dest }}">{{ $dest }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Tipe Kendaraan</label>
                            <select id="rental-vehicle-type" onchange="calculatePrice()" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                <option value="standard">Standard</option>
                                <option value="premium">Premium</option>
                                <option value="luxury">Luxury</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Opsi Sopir</label>
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="driver_option" value="without" onchange="calculatePrice()" checked class="w-4 h-4 text-blue-600">
                                    <span class="ml-3 text-gray-700">Tanpa Sopir</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="driver_option" value="with" onchange="calculatePrice()" class="w-4 h-4 text-blue-600">
                                    <span class="ml-3 text-gray-700">Dengan Sopir</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Jumlah Hari</label>
                            <input type="number" id="rental-days" value="1" min="1" max="365" onchange="calculatePrice()" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        </div>
                    </div>
                </div>

                <!-- Result Section -->
                <div id="result-section" class="mt-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-2 border-blue-200 hidden">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Harga</p>
                            <p id="result-price" class="text-4xl font-bold text-blue-600">Rp 0</p>
                        </div>
                        <div class="flex items-end justify-end">
                            @auth
                                <button onclick="proceedToBooking()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                                    Lanjutkan Booking →
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                                    Login untuk Melanjutkan →
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Info -->
                <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm text-gray-700">
                        <strong>Catatan:</strong> Harga yang ditampilkan adalah harga dasar. Harga final dapat berubah sesuai dengan kondisi perjalanan dan kebijakan yang berlaku.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentService = 'travel';
        let currentPrice = 0;

        function setService(service) {
            currentService = service;
            document.querySelectorAll('.service-btn').forEach(btn => {
                btn.classList.remove('active', 'border-blue-600', 'bg-blue-50', 'text-blue-600');
                btn.classList.add('border-gray-300', 'bg-white', 'text-gray-700');
            });
            document.querySelector(`[data-service="${service}"]`).classList.add('active', 'border-blue-600', 'bg-blue-50', 'text-blue-600');

            document.getElementById('travel-section').classList.toggle('hidden', service !== 'travel');
            document.getElementById('rental-section').classList.toggle('hidden', service !== 'rental');
            document.getElementById('result-section').classList.add('hidden');

            resetForm();
        }

        function resetForm() {
            document.getElementById('travel-route').value = '';
            document.getElementById('rental-destination').value = '';
            document.getElementById('rental-days').value = 1;
            document.querySelector('input[name="driver_option"][value="without"]').checked = true;
            currentPrice = 0;
        }

        function calculatePrice() {
            if (currentService === 'travel') {
                calculateTravelPrice();
            } else {
                calculateRentalPrice();
            }
        }

        function calculateTravelPrice() {
            const routeSelect = document.getElementById('travel-route');
            const price = parseInt(routeSelect.options[routeSelect.selectedIndex].dataset.price || 0);

            if (price > 0) {
                currentPrice = price;
                showResult();
            } else {
                document.getElementById('result-section').classList.add('hidden');
            }
        }

        function calculateRentalPrice() {
            const destination = document.getElementById('rental-destination').value;
            const vehicleType = document.getElementById('rental-vehicle-type').value;
            const driverOption = document.querySelector('input[name="driver_option"]:checked').value;
            const days = parseInt(document.getElementById('rental-days').value) || 1;

            if (!destination) {
                document.getElementById('result-section').classList.add('hidden');
                return;
            }

            fetch("{{ route('public.calculate-price') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    service: 'rental',
                    destination: destination,
                    vehicle_type: vehicleType,
                    with_driver: driverOption === 'with',
                    days: days
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentPrice = data.price;
                    showResult();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function showResult() {
            document.getElementById('result-price').textContent = 'Rp ' + currentPrice.toLocaleString('id-ID');
            document.getElementById('result-section').classList.remove('hidden');
        }

        function proceedToBooking() {
            if (currentService === 'travel') {
                const routeId = document.getElementById('travel-route').value;
                if (routeId) window.location.href = `{{ route('bookings.travel.create') }}?route_id=${routeId}`;
            } else {
                const destination = document.getElementById('rental-destination').value;
                if (destination) window.location.href = `{{ route('bookings.rental.create') }}?destination=${destination}`;
            }
        }
    </script>
@endsection
