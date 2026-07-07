@extends('layouts.app')

@section('title', 'Pesan Travel')

@section('content')
    <div class="mb-8">
        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Pesan Travel</h1>
        <p class="text-gray-600">Pesan tiket travel ke tujuan Anda.</p>
    </div>

    <div class="max-w-2xl">
        <div class="card">
            <div class="card-header mb-6">Lengkapi detail pemesanan</div>
            
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <p class="text-red-700 font-semibold mb-2">Harap perbaiki kesalahan berikut:</p>
                    <ul class="text-red-600 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>&bull; {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('bookings.travel.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Route Selection -->
                <div>
                    <label for="route_id" class="block text-gray-700 font-medium mb-2">Pilih Rute</label>
                    <select name="route_id" id="route_id" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('route_id') border-red-500 @enderror">
                        <option value="">-- Pilih rute --</option>
                        @foreach ($routes as $route)
                            <option value="{{ $route->id }}" @selected(old('route_id') == $route->id)>
                                {{ $route->origin_city }} &rarr; {{ $route->destination_city }} ({{ $route->distance_km }} km)
                            </option>
                        @endforeach
                    </select>
                    @error('route_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Scheduled Date -->
                <div>
                    <label for="scheduled_date" class="block text-gray-700 font-medium mb-2">Tanggal Berangkat</label>
                    <input type="date" name="scheduled_date" id="scheduled_date" 
                           value="{{ old('scheduled_date') }}" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('scheduled_date') border-red-500 @enderror">
                    @error('scheduled_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Number of Seats -->
                <div>
                    <label for="number_of_seats" class="block text-gray-700 font-medium mb-2">Jumlah Kursi</label>
                    <input type="number" name="number_of_seats" id="number_of_seats" min="1" max="16"
                           value="{{ old('number_of_seats', 1) }}" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('number_of_seats') border-red-500 @enderror">
                    <p class="text-gray-500 text-sm mt-1">Maksimal 16 kursi per pemesanan</p>
                    @error('number_of_seats') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Passengers Section -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-gray-700 font-medium">Data Penumpang</label>
                        <button type="button" id="addPassengerBtn" class="px-3 py-1.5 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors">
                            + Tambah Penumpang
                        </button>
                    </div>
                    <div id="passengersContainer" class="space-y-3">
                        <!-- Passenger rows will be dynamically added here -->
                        <div class="passenger-row bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <div>
                                    <label class="text-sm text-gray-600 mb-1 block">Nama</label>
                                    <input type="text" name="passengers[0][name]" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#0064d2] text-sm"
                                           placeholder="Nama penumpang">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600 mb-1 block">NIK</label>
                                    <input type="text" name="passengers[0][nik]" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#0064d2] text-sm"
                                           placeholder="Nomor NIK">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600 mb-1 block">No. Kursi</label>
                                    <input type="text" name="passengers[0][seat_number]" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#0064d2] text-sm"
                                           placeholder="Contoh: 1A">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terms -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-gray-700">
                        <strong>Catatan:</strong> Pemesanan akan dikonfirmasi setelah pembayaran diverifikasi.
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary flex-1">Pesan Sekarang</button>
                    <a href="{{ route('bookings.travel') }}" class="btn-secondary flex-1 text-center">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let passengerIndex = 1;
    const container = document.getElementById('passengersContainer');
    const addBtn = document.getElementById('addPassengerBtn');

    addBtn.addEventListener('click', function() {
        const rows = container.querySelectorAll('.passenger-row');
        const clone = rows[0].cloneNode(true);
        
        // Update indices
        clone.querySelectorAll('input').forEach(function(input) {
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace(/passengers\[\d+\]/, 'passengers[' + passengerIndex + ']'));
                input.value = '';
            }
        });
        
        // Add remove button
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'remove-passenger absolute top-2 right-2 text-red-500 hover:text-red-700 text-lg font-bold';
        removeBtn.innerHTML = '&times;';
        removeBtn.onclick = function() {
            this.parentElement.remove();
        };
        
        clone.style.position = 'relative';
        clone.appendChild(removeBtn);
        container.appendChild(clone);
        passengerIndex++;
    });
});
</script>
@endpush
