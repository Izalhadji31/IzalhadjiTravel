@extends('layouts.app')

@section('title', 'Travel - ASR GO')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Daftar Rute Travel</h1>
                <p class="text-gray-600">Pilih rute perjalanan Anda dan pesan sekarang</p>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <form method="GET" action="{{ route('public.travel') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Origin Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Asal</label>
                        <select name="origin" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                            <option value="">Semua Asal</option>
                            @foreach ($origins as $origin)
                                <option value="{{ $origin }}" {{ request('origin') == $origin ? 'selected' : '' }}>
                                    {{ $origin }}
                                </option>
                            @endforeach
                        </select>
                    </div>

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

            <!-- Routes Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse ($routes as $route)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <!-- Route Header -->
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-gray-900">{{ $route->origin_city }} → {{ $route->destination_city }}</h3>
                                <p class="text-sm text-gray-600 mt-1">Jarak: {{ $route->distance_km }} km</p>
                            </div>

                            <!-- Route Info -->
                            <div class="space-y-3 mb-6 pb-6 border-b">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Durasi</span>
                                    <span class="font-semibold">{{ $route->estimated_hours }} jam</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tipe</span>
                                    <span class="font-semibold">{{ ucfirst($route->route_type) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status</span>
                                    <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aktif</span>
                                </div>
                            </div>

                            <!-- Price -->
                            @if ($route->travelPrices->count() > 0)
                                <div class="mb-6">
                                    @foreach ($route->travelPrices as $price)
                                        <p class="text-2xl font-bold text-blue-600">
                                            Rp {{ number_format($price->price_per_seat, 0, ',', '.') }}
                                        </p>
                                        <p class="text-xs text-gray-600">per kursi</p>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Action Button -->
                            @auth
                                <a href="{{ route('bookings.travel.create', ['route_id' => $route->id]) }}" 
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
                        <p class="text-gray-600 text-lg">Tidak ada rute travel yang tersedia</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $routes->links() }}
            </div>
        </div>
    </div>
@endsection
