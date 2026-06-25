@extends('layouts.app')

@section('title', 'Dashboard Driver')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Page Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard Driver</h1>
                    <p class="mt-1 text-sm text-gray-500">Selamat datang, {{ auth()->user()->name }}! Kelola tugas perjalanan Anda.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Active Orders -->
            <a href="{{ route('driver.orders') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Order Aktif</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $activeOrderCount ?? 0 }}</p>
                        </div>
                        <div class="h-14 w-14 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="h-7 w-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-blue-500 font-medium">Lihat detail →</span>
                    </div>
                </div>
                <div class="h-1 bg-blue-400"></div>
            </a>

            <!-- Total Trips -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Trip</p>
                            <p class="text-3xl font-bold text-green-600">{{ $totalTrips ?? 0 }}</p>
                        </div>
                        <div class="h-14 w-14 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="h-7 w-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-500 font-medium">Trip yang telah selesai</span>
                    </div>
                </div>
                <div class="h-1 bg-green-400"></div>
            </div>

            <!-- Balance -->
            <a href="{{ route('driver.earnings') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Saldo</p>
                            <p class="text-3xl font-bold text-orange-600">Rp {{ number_format($balance ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="h-14 w-14 rounded-full bg-orange-100 flex items-center justify-center">
                            <svg class="h-7 w-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-orange-500 font-medium">Lihat riwayat →</span>
                    </div>
                </div>
                <div class="h-1 bg-orange-400"></div>
            </a>
        </div>

        <!-- Driver Status Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Status Driver</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Current Status -->
                <div>
                    <p class="text-sm text-gray-500 mb-2">Status Saat Ini</p>
                    <form method="POST" action="{{ route('driver.status.toggle') }}" class="flex items-center space-x-4">
                        @csrf
                        <select name="status" class="block w-full md:w-auto rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="available" {{ ($driverStatus ?? '') === 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="offline" {{ ($driverStatus ?? '') === 'offline' ? 'selected' : '' }}>Offline</option>
                            <option value="busy" {{ ($driverStatus ?? '') === 'busy' ? 'selected' : '' }}>Sibuk</option>
                            <option value="on_leave" {{ ($driverStatus ?? '') === 'on_leave' ? 'selected' : '' }}>Cuti</option>
                        </select>
                        <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                            Ubah Status
                        </button>
                    </form>
                </div>

                <!-- Armada Info -->
                <div>
                    <p class="text-sm text-gray-500 mb-2">Informasi Armada</p>
                    @if($armada)
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $armada->vehicle_type }} - {{ $armada->plate_number }}</p>
                            <p class="text-xs text-gray-500">Supir: {{ $armada->driver_name }}</p>
                        </div>
                    </div>
                    @else
                    <div class="flex items-center space-x-3 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                        <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <p class="text-sm text-yellow-800">Belum ada armada yang ditugaskan. Hubungi admin.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('driver.orders') }}" class="flex items-center space-x-4 p-4 bg-blue-50 rounded-lg border border-blue-200 hover:bg-blue-100 transition-colors">
                    <div class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center flex-shrink-0">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-blue-900">Order Aktif</p>
                        <p class="text-xs text-blue-700">Lihat perjalanan yang sedang berjalan</p>
                    </div>
                </a>

                <a href="{{ route('driver.earnings') }}" class="flex items-center space-x-4 p-4 bg-green-50 rounded-lg border border-green-200 hover:bg-green-100 transition-colors">
                    <div class="h-12 w-12 rounded-full bg-green-500 flex items-center justify-center flex-shrink-0">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-green-900">Pendapatan</p>
                        <p class="text-xs text-green-700">Cek saldo dan riwayat trip</p>
                    </div>
                </a>

                <a href="{{ route('tracking.dashboard') }}" class="flex items-center space-x-4 p-4 bg-purple-50 rounded-lg border border-purple-200 hover:bg-purple-100 transition-colors">
                    <div class="h-12 w-12 rounded-full bg-purple-500 flex items-center justify-center flex-shrink-0">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-purple-900">Peta Tracking</p>
                        <p class="text-xs text-purple-700">Pantau lokasi armada</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
