@extends('layouts.app')

@section('title', 'Rental Kendaraan - ASR GO')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Sewa Kendaraan</h1>
                <p class="text-gray-600">Pilih kendaraan impian Anda untuk perjalanan selanjutnya</p>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <form method="GET" action="{{ route('public.rental') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Destination Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tujuan</label>
                        <select name="destination" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                            <option value="">Semua Tujuan</option>
                            @foreach ($destinations as $destination)
                                <option value="{{ $destination }}" {{ request('destination') == $destination ? 'selected' : '' }}>
                                    {{ $destination }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Vehicle Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Kendaraan</label>
                        <select name="vehicle_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                            <option value="">Semua Tipe</option>
                            @foreach ($vehicleTypes as $type)
                                <option value="{{ $type }}" {{ request('vehicle_type') == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Min -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Min (Rp)</label>
                        <input type="number" name="price_min" value="{{ request('price_min') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="0">
                    </div>

                    <!-- Price Max -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Max (Rp)</label>
                        <input type="number" name="price_max" value="{{ request('price_max') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="999999999">
                    </div>

                    <!-- Filter Button -->
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Rentals Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse ($rentals as $rental)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <!-- Rental Header -->
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-gray-900">{{ $rental->route->name ?? 'Rental Kendaraan' }}</h3>
                                <p class="text-sm text-gray-600 mt-1">Tujuan: {{ $rental->route->destination_city }}</p>
                            </div>

                            <!-- Rental Info -->
                            <div class="space-y-3 mb-6 pb-6 border-b">
                                <div>
                                    <p class="text-xs text-gray-600">Tanpa Sopir (per hari)</p>
                                    <p class="text-2xl font-bold text-blue-600">
                                        Rp {{ number_format($rental->price_without_driver, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600">Dengan Sopir (per hari)</p>
                                    <p class="text-2xl font-bold text-green-600">
                                        Rp {{ number_format($rental->price_with_driver, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Perks -->
                            @if ($rental->description)
                                <div class="mb-6 text-sm text-gray-600">
                                    <p>{{ $rental->description }}</p>
                                </div>
                            @endif

                            <!-- Action Button -->
                            @auth
                                <a href="{{ route('bookings.rental.create', ['route_id' => $rental->route_id]) }}" 
                                   class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                    Pesan Sekarang
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="block w-full text-center bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                    Login untuk Pesan
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-600 text-lg">Tidak ada layanan rental yang tersedia</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $rentals->links() }}
            </div>
        </div>
    </div>
@endsection
