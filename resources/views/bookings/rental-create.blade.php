@extends('layouts.app')

@section('title', 'Sewa Rental')

@section('content')
    <div class="mb-8">
        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Sewa Mobil</h1>
        <p class="text-gray-600">Sewa mobil untuk kebutuhan transportasi Anda.</p>
    </div>

    <div class="max-w-2xl">
        <div class="card">
            <div class="card-header mb-6">Lengkapi detail sewa</div>
            
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <p class="text-red-700 font-semibold mb-2">Harap perbaiki kesalahan:</p>
                    <ul class="text-red-600 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>&bull; {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('bookings.rental.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Route Selection -->
                <div>
                    <label for="route_id" class="block text-gray-700 font-medium mb-2">Pilih Rute</label>
                    <select name="route_id" id="route_id" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('route_id') border-red-500 @enderror">
                        <option value="">-- Pilih rute --</option>
                        @foreach ($routes as $route)
                            <option value="{{ $route->id }}" @selected(old('route_id') == $route->id)>
                                {{ $route->origin_city }} &rarr; {{ $route->destination_city }}
                            </option>
                        @endforeach
                    </select>
                    @error('route_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-gray-700 font-medium mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" 
                           value="{{ old('start_date') }}" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('start_date') border-red-500 @enderror">
                    @error('start_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Rental Type -->
                <div>
                    <label class="block text-gray-700 font-medium mb-3">Tipe Sewa</label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="radio" name="rental_type" value="with_driver" @checked(old('rental_type') == 'with_driver')
                                   class="w-4 h-4 text-blue-600 rounded-full" required>
                            <span class="ml-2 text-gray-700">Dengan Sopir</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="rental_type" value="without_driver" @checked(old('rental_type') == 'without_driver')
                                   class="w-4 h-4 text-blue-600 rounded-full" required>
                            <span class="ml-2 text-gray-700">Lepas Kunci</span>
                        </label>
                    </div>
                    @error('rental_type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Regency Count -->
                <div>
                    <label for="regency_count" class="block text-gray-700 font-medium mb-2">Jumlah Kabupaten</label>
                    <input type="number" name="regency_count" id="regency_count" min="1"
                           value="{{ old('regency_count', 1) }}" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition-colors @error('regency_count') border-red-500 @enderror">
                    <p class="text-gray-500 text-sm mt-1">Jumlah wilayah kabupaten yang akan dilalui</p>
                    @error('regency_count') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Terms -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-gray-700">
                        <strong>Catatan:</strong> Pemesanan akan dikonfirmasi setelah pembayaran diverifikasi.
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary flex-1">Sewa Sekarang</button>
                    <a href="{{ route('bookings.rental') }}" class="btn-secondary flex-1 text-center">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
