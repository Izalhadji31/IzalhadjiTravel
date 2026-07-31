@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Page Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Pendapatan Driver</h1>
                    <p class="mt-1 text-sm text-gray-500">Pantau pendapatan dan riwayat trip Anda</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">{{ $driver->name ?? 'Driver' }}</span>
                    <div class="h-10 w-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr($driver->name ?? 'D', 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Saldo Saat Ini -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Saldo Saat Ini</p>
                            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($driverBalance ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="h-14 w-14 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="h-7 w-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-500 font-medium">Tersedia untuk penarikan</span>
                    </div>
                </div>
                <div class="h-1 bg-green-400"></div>
            </div>

            <!-- Total Trip -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Trip</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $totalEarnings ?? 0 }}</p>
                        </div>
                        <div class="h-14 w-14 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="h-7 w-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-blue-500 font-medium">Trip yang telah selesai</span>
                    </div>
                </div>
                <div class="h-1 bg-blue-400"></div>
            </div>

            <!-- Pendapatan Pending -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Pendapatan Pending</p>
                            <p class="text-3xl font-bold text-orange-600">Rp {{ number_format($pendingEarnings ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="h-14 w-14 rounded-full bg-orange-100 flex items-center justify-center">
                            <svg class="h-7 w-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-orange-500 font-medium">Menunggu penyelesaian</span>
                    </div>
                </div>
                <div class="h-1 bg-orange-400"></div>
            </div>
        </div>

        <!-- Driver Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Driver</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                        <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Nama</p>
                        <p class="text-sm font-medium text-gray-800">{{ $driver->name ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                        <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Armada</p>
                        <p class="text-sm font-medium text-gray-800">{{ $armada->nama_armada ?? ($armada->name ?? '-') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                        <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Nomor Telepon</p>
                        <p class="text-sm font-medium text-gray-800">{{ $driver->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trip History Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Riwayat Trip</h2>
                <span class="text-sm text-gray-500">{{ count($tripHistory ?? []) }} trip tercatat</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rute</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jarak</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pendapatan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($tripHistory ?? [] as $trip)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($trip->created_at ?? now())->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($trip->created_at ?? now())->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(($trip->type ?? '') === 'travel' || ($trip->tipe ?? '') === 'travel')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                                        </svg>
                                        Travel
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                        </svg>
                                        Rental
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $trip->route ?? ($trip->rute ?? '-') }}">
                                    {{ $trip->route ?? ($trip->rute ?? '-') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $trip->pickup_location ?? '' }} → {{ $trip->destination ?? '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $trip->distance ?? ($trip->jarak ?? '0') }} km</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-green-600">Rp {{ number_format($trip->earning ?? ($trip->pendapatan ?? 0), 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(($trip->status ?? '') === 'completed' || ($trip->status ?? '') === 'selesai')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500 mr-1.5"></span>
                                        Selesai
                                    </span>
                                @elseif(($trip->status ?? '') === 'pending' || ($trip->status === 'menunggu'))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <span class="h-1.5 w-1.5 rounded-full bg-yellow-500 mr-1.5"></span>
                                        Pending
                                    </span>
                                @elseif (($trip->status ?? '') === 'cancelled' || ($trip->status === 'dibatalkan'))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                        Dibatalkan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-500 mr-1.5"></span>
                                        {{ ucfirst($trip->status ?? '-') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                    </svg>
                                    <p class="text-sm text-gray-500">Belum ada riwayat trip</p>
                                    <p class="text-xs text-gray-400 mt-1">Trip Anda akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Revenue Sharing History -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Riwayat Pembagian Pendapatan</h2>
                    <p class="text-sm text-gray-500 mt-1">Detail pembagian revenue antara driver dan perusahaan</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                        <p class="text-sm text-green-700 font-medium">Total Pendapatan Driver</p>
                        <p class="text-2xl font-bold text-green-700 mt-1">Rp {{ number_format(($driverBalance ?? 0) * 0.7, 0, ',', '.') }}</p>
                        <p class="text-xs text-green-600 mt-1">70% dari total revenue</p>
                    </div>
                    <div class="p-4 bg-indigo-50 rounded-lg border border-indigo-200">
                        <p class="text-sm text-indigo-700 font-medium">Bagian Perusahaan</p>
                        <p class="text-2xl font-bold text-indigo-700 mt-1">Rp {{ number_format(($driverBalance ?? 0) * 0.3, 0, ',', '.') }}</p>
                        <p class="text-xs text-indigo-600 mt-1">30% dari total revenue</p>
                    </div>
                </div>

                <!-- Revenue Sharing Table -->
                <div class="overflow-x-auto mt-4">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID Trip</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Bagian Driver (70%)</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Bagian Perusahaan (30%)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($tripHistory ?? [] as $trip)
                            @if(($trip->status ?? '') === 'completed' || ($trip->status ?? '') === 'selesai')
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($trip->created_at ?? now())->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 font-mono">
                                    #{{ $trip->id ?? strtoupper(substr(md5(rand()), 0, 8)) }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    Rp {{ number_format($trip->earning ?? ($trip->pendapatan ?? 0), 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-green-600">
                                    Rp {{ number_format(($trip->earning ?? ($trip->pendapatan ?? 0)) * 0.7, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-indigo-600">
                                    Rp {{ number_format(($trip->earning ?? ($trip->pendapatan ?? 0)) * 0.3, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endif
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center">
                                    <p class="text-sm text-gray-500">Belum ada data pembagian pendapatan</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
