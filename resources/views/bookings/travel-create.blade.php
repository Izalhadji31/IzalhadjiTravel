@extends('layouts.app')

@section('title', 'Create Travel Booking')

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Create Travel Booking</h1>
        <p class="text-gray-600">Book a travel trip to your preferred destination</p>
    </div>

    <div class="max-w-4xl">
        <div class="card">
            <div class="card-header mb-6">Fill in the booking details</div>
            
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <p class="text-red-700 font-semibold mb-2">Please fix the errors:</p>
                    <ul class="text-red-600 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('bookings.travel.store') }}" method="POST" class="space-y-6" id="bookingForm">
                @csrf
                
                <!-- Route Selection -->
                <div>
                    <label for="route_id" class="block text-gray-700 font-medium mb-2">Select Route</label>
                    <select name="route_id" id="route_id" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('route_id') border-red-500 @enderror">
                        <option value="">-- Choose a route --</option>
                        @foreach ($routes as $route)
                            <option value="{{ $route->id }}" @selected(old('route_id') == $route->id)>
                                {{ $route->origin_city }} → {{ $route->destination_city }} ({{ $route->distance_km }} km)
                            </option>
                        @endforeach
                    </select>
                    @error('route_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Scheduled Date -->
                <div>
                    <label for="scheduled_date" class="block text-gray-700 font-medium mb-2">Travel Date</label>
                    <input type="date" name="scheduled_date" id="scheduled_date" 
                           value="{{ old('scheduled_date') }}" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('scheduled_date') border-red-500 @enderror">
                    @error('scheduled_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Number of Seats -->
                <div>
                    <label for="number_of_seats" class="block text-gray-700 font-medium mb-2">Number of Seats</label>
                    <input type="number" name="number_of_seats" id="number_of_seats" min="1" max="6"
                           value="{{ old('number_of_seats', 1) }}" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('number_of_seats') border-red-500 @enderror">
                    <p class="text-gray-500 text-sm mt-1">Maximum 6 seats per booking (Minibus)</p>
                    @error('number_of_seats') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Seat Selection -->
                <div id="seatSelectionSection" class="hidden">
                    <label class="block text-gray-700 font-medium mb-2">Select Seats</label>
                    <div id="seatAvailabilityStatus" class="mb-2 text-sm"></div>
                    <div id="seatGrid" class="grid grid-cols-2 gap-4 mb-2 max-w-xs mx-auto">
                        <!-- Seats will be generated dynamically -->
                    </div>
                    <p class="text-gray-500 text-sm text-center">Click on seats to select them. Green = available, Red = occupied, Blue = selected, Yellow = locked by others</p>
                    <input type="hidden" name="selected_seats" id="selectedSeatsInput">
                    @error('selected_seats') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Passenger Data -->
                <div id="passengerDataSection" class="hidden space-y-4">
                    <label class="block text-gray-700 font-medium mb-2">Passenger Information</label>
                    <div id="passengerForms" class="space-y-4">
                        <!-- Passenger forms will be generated dynamically -->
                    </div>
                    @error('passenger_data') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Terms -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-gray-700">
                        <strong>Note:</strong> You must have a verified identity to proceed with the booking. Please verify your identity in your profile settings.
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary flex-1">Create Booking</button>
                    <a href="{{ route('bookings.travel') }}" class="btn-secondary flex-1 text-center">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const numberOfSeatsInput = document.getElementById('number_of_seats');
            const routeSelect = document.getElementById('route_id');
            const dateInput = document.getElementById('scheduled_date');
            const seatSelectionSection = document.getElementById('seatSelectionSection');
            const passengerDataSection = document.getElementById('passengerDataSection');
            const seatGrid = document.getElementById('seatGrid');
            const passengerForms = document.getElementById('passengerForms');
            const selectedSeatsInput = document.getElementById('selectedSeatsInput');
            const seatAvailabilityStatus = document.getElementById('seatAvailabilityStatus');
            
            let selectedSeats = [];
            let lockedSeats = [];
            const totalSeats = 6; // Minibus with 6 seats
            let availabilityRefreshInterval;
            let currentRouteId = null;
            let currentTravelDate = null;

            // Add event listeners for route and date changes
            routeSelect.addEventListener('change', refreshSeatAvailability);
            dateInput.addEventListener('change', refreshSeatAvailability);

            numberOfSeatsInput.addEventListener('change', function() {
                const seatCount = parseInt(this.value);
                
                if (seatCount > 0) {
                    seatSelectionSection.classList.remove('hidden');
                    passengerDataSection.classList.remove('hidden');
                    refreshSeatAvailability();
                    generatePassengerForms(seatCount);
                } else {
                    seatSelectionSection.classList.add('hidden');
                    passengerDataSection.classList.add('hidden');
                    clearInterval(availabilityRefreshInterval);
                }
            });

            async function refreshSeatAvailability() {
                const routeId = routeSelect.value;
                const travelDate = dateInput.value;

                if (!routeId || !travelDate) {
                    return;
                }

                currentRouteId = routeId;
                currentTravelDate = travelDate;

                try {
                    const response = await fetch(`/seat-availability/availability?route_id=${routeId}&travel_date=${travelDate}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        updateSeatGridWithAvailability(data.data);
                    } else {
                        console.error('Failed to fetch seat availability');
                    }
                } catch (error) {
                    console.error('Error fetching seat availability:', error);
                }
            }

            function updateSeatGridWithAvailability(availability) {
                seatGrid.innerHTML = '';
                selectedSeats = [];
                lockedSeats = availability.locked || [];
                selectedSeatsInput.value = '';

                const bookedSeats = availability.booked || [];
                const availableSeats = availability.available || [];

                for (let i = 1; i <= totalSeats; i++) {
                    const seatButton = document.createElement('button');
                    seatButton.type = 'button';
                    seatButton.textContent = i;
                    seatButton.dataset.seatNumber = i;

                    // Determine seat status and styling
                    if (bookedSeats.includes(i.toString())) {
                        seatButton.className = 'p-6 border-2 rounded-lg font-bold text-xl transition-colors bg-red-100 border-red-300 text-red-700 cursor-not-allowed';
                        seatButton.disabled = true;
                    } else if (lockedSeats.includes(i.toString())) {
                        seatButton.className = 'p-6 border-2 rounded-lg font-bold text-xl transition-colors bg-yellow-100 border-yellow-300 text-yellow-700 cursor-not-allowed';
                        seatButton.disabled = true;
                    } else {
                        seatButton.className = 'p-6 border-2 rounded-lg font-bold text-xl transition-colors bg-green-100 border-green-300 hover:bg-green-200';
                        seatButton.disabled = false;
                    }

                    seatButton.addEventListener('click', function() {
                        const seatNumber = this.dataset.seatNumber;
                        const maxSeats = parseInt(numberOfSeatsInput.value);
                        
                        if (selectedSeats.includes(seatNumber)) {
                            // Deselect seat and unlock it
                            selectedSeats = selectedSeats.filter(s => s !== seatNumber);
                            this.className = 'p-6 border-2 rounded-lg font-bold text-xl transition-colors bg-green-100 border-green-300 hover:bg-green-200';
                            unlockSeat(seatNumber);
                        } else if (selectedSeats.length < maxSeats) {
                            // Select seat and lock it
                            lockSeat(seatNumber).then(success => {
                                if (success) {
                                    selectedSeats.push(seatNumber);
                                    this.className = 'p-6 border-2 rounded-lg font-bold text-xl transition-colors bg-blue-500 text-white border-blue-700';
                                    selectedSeatsInput.value = JSON.stringify(selectedSeats);
                                    updatePassengerFormSeatNumbers();
                                } else {
                                    refreshSeatAvailability(); // Refresh if lock failed
                                }
                            });
                        } else {
                            alert('You can only select ' + maxSeats + ' seats');
                        }
                    });
                    
                    seatGrid.appendChild(seatButton);
                }

                // Update status message
                const availableCount = availableSeats.length;
                seatAvailabilityStatus.innerHTML = `<span class="text-green-600 font-semibold">${availableCount}</span> seats available`;
            }

            async function lockSeat(seatNumber) {
                try {
                    const response = await fetch('/seat-availability/lock', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            route_id: currentRouteId,
                            travel_date: currentTravelDate,
                            seat_numbers: [seatNumber],
                            lock_minutes: 15
                        })
                    });

                    const data = await response.json();
                    return data.success;
                } catch (error) {
                    console.error('Error locking seat:', error);
                    return false;
                }
            }

            async function unlockSeat(seatNumber) {
                try {
                    const response = await fetch('/seat-availability/unlock', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            route_id: currentRouteId,
                            travel_date: currentTravelDate,
                            seat_numbers: [seatNumber]
                        })
                    });

                    const data = await response.json();
                    return data.success;
                } catch (error) {
                    console.error('Error unlocking seat:', error);
                    return false;
                }
            }

            function generatePassengerForms(count) {
                passengerForms.innerHTML = '';
                
                for (let i = 0; i < count; i++) {
                    const passengerForm = document.createElement('div');
                    passengerForm.className = 'bg-gray-50 p-4 rounded-lg border';
                    passengerForm.innerHTML = `
                        <h3 class="font-medium text-gray-800 mb-3">Passenger ${i + 1} <span class="text-sm text-gray-500">(Seat: <span class="seat-display-${i}">-</span>)</span></h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-gray-600 text-sm mb-1">Full Name</label>
                                <input type="text" name="passenger_data[${i}][name]" required
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                       placeholder="Enter full name">
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm mb-1">NIK (ID Number)</label>
                                <input type="text" name="passenger_data[${i}][nik]" required
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                       placeholder="Enter NIK (16 digits)">
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm mb-1">Phone Number</label>
                                <input type="tel" name="passenger_data[${i}][phone]" required
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                       placeholder="08xxxxxxxxxx">
                            </div>
                        </div>
                    `;
                    passengerForms.appendChild(passengerForm);
                }
            }

            function updatePassengerFormSeatNumbers() {
                // Update seat display in passenger forms
                selectedSeats.forEach((seatNumber, index) => {
                    const seatDisplay = document.querySelector(`.seat-display-${index}`);
                    if (seatDisplay) {
                        seatDisplay.textContent = seatNumber;
                    }
                });
            }

            // Auto-refresh availability every 30 seconds
            function startAutoRefresh() {
                clearInterval(availabilityRefreshInterval);
                availabilityRefreshInterval = setInterval(refreshSeatAvailability, 30000);
            }

            // Start auto-refresh when seat selection is shown
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.target.id === 'seatSelectionSection') {
                        if (!seatSelectionSection.classList.contains('hidden')) {
                            startAutoRefresh();
                        } else {
                            clearInterval(availabilityRefreshInterval);
                        }
                    }
                });
            });

            observer.observe(seatSelectionSection, { attributes: true, attributeFilter: ['class'] });
        });
    </script>
@endsection
