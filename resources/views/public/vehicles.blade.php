@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white pt-24 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-4xl lg:text-5xl font-black text-gray-900 mb-4">
                Daftar Kendaraan Tersedia
            </h1>
            <p class="text-gray-500 text-lg max-w-2xl">
                Pilih kendaraan yang sesuai dengan kebutuhan Anda. Semua armada kami terawat, berlisensi, dan dilengkapi asuransi.
            </p>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-10">
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Vehicle Type Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Kendaraan</label>
                    <select name="vehicle_type" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-colors" style="appearance:none; background-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22><path stroke=%22%236b7280%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%221.5%22 d=%22M6 8l4 4 4-4%22/></svg>'); background-position: right 0.75rem center; background-repeat: no-repeat; background-size: 1.25rem; padding-right: 2.5rem;">
                        <option value="">-- Semua Tipe --</option>
                        @foreach($vehicleTypes as $type)
                            <option value="{{ $type }}" {{ request('vehicle_type') === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Min Capacity Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Min. Kapasitas</label>
                    <input type="number" name="min_capacity" placeholder="Jumlah kursi minimal" 
                           value="{{ request('min_capacity') }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-colors">
                </div>

                <!-- Sort By -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan Berdasarkan</label>
                    <select name="sort" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-colors" style="appearance:none; background-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22><path stroke=%22%236b7280%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%221.5%22 d=%22M6 8l4 4 4-4%22/></svg>'); background-position: right 0.75rem center; background-repeat: no-repeat; background-size: 1.25rem; padding-right: 2.5rem;">
                        <option value="vehicle_type" {{ request('sort') === 'vehicle_type' ? 'selected' : '' }}>Tipe Kendaraan</option>
                        <option value="seat_capacity" {{ request('sort') === 'seat_capacity' ? 'selected' : '' }}>Kapasitas</option>
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Terbaru</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Vehicles Grid -->
        @if($vehicles->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($vehicles as $vehicle)
                    <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300">
                        <!-- Vehicle Image Header -->
                        <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center relative">
                            <div class="text-6xl">
                                @switch($vehicle->vehicle_type)
                                    @case('Avanza')
                                        🚗
                                        @break
                                    @case('Innova')
                                        🚙
                                        @break
                                    @case('Hiace')
                                        🚐
                                        @break
                                    @case('Elf')
                                        🚐
                                        @break
                                    @default
                                        🚗
                                @endswitch
                            </div>
                            <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                ✓ Tersedia
                            </div>
                        </div>

                        <!-- Vehicle Info -->
                        <div class="p-5">
                            <!-- Vehicle Type & Plate -->
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $vehicle->vehicle_type }}</h3>
                            <p class="text-sm text-gray-500 font-mono mb-4">{{ strtoupper($vehicle->plate_number) }}</p>

                            <!-- Details -->
                            <div class="space-y-3 mb-5 border-y border-gray-100 py-4">
                                <!-- Capacity -->
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">👥 Kapasitas</span>
                                    <span class="font-bold text-gray-900">{{ $vehicle->seat_capacity }} Orang</span>
                                </div>

                                <!-- Driver Info -->
                                <div class="flex items-start justify-between">
                                    <span class="text-sm text-gray-600">👨‍✈️ Pengemudi</span>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900 text-sm">{{ $vehicle->driver_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $vehicle->driver_phone }}</p>
                                    </div>
                                </div>

                                <!-- Partner -->
                                @if($vehicle->mitra)
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">🏢 Mitra</span>
                                        <span class="text-sm font-medium text-gray-900">{{ $vehicle->mitra->name }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Features -->
                            <div class="text-xs text-gray-600 space-y-1 mb-5">
                                <p>✓ AC & Power Steering</p>
                                <p>✓ Asuransi Lengkap</p>
                                <p>✓ Pengemudi Profesional</p>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('login') }}" class="w-full block text-center bg-blue-600 text-white font-semibold py-2.5 rounded-lg hover:bg-blue-700 transition-colors">
                                Pesan Sekarang
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $vehicles->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="text-6xl mb-4">🚗</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak ada kendaraan ditemukan</h3>
                <p class="text-gray-500 mb-6">Coba ubah filter pencarian Anda</p>
                <a href="{{ route('public.vehicles') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 1 1 18 0 9 9 0 0 1-18 0z"/>
                    </svg>
                    Kembalikan ke Semua Kendaraan
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    body {
        font-family: 'Inter', sans-serif;
    }
</style>
@endsection
