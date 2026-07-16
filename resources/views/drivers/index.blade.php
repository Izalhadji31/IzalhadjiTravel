@extends('layouts.app')

@section('title', 'Drivers Management')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-8 flex justify-between items-start">
        <div>
            <h1 class="page-title">Drivers Management</h1>
            <p class="page-subtitle">Manage and track your drivers performance.</p>
        </div>
        <a href="{{ route('drivers.create') }}" class="btn-primary">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Driver
        </a>
    </div>

    <!-- Driver Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Drivers</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalDrivers }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">On Duty</p>
                    <p class="text-3xl font-bold text-amber-600 mt-2">{{ $onDutyDrivers }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Available</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $availableDrivers }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m0 0l-2-1m2 1v2.5M14 4l-2 1m0 0L10 4m2 1v2.5"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Maintenance</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $maintenanceDrivers }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-6 flex flex-wrap gap-4 items-center justify-between">
        <form method="GET" action="{{ route('drivers.index') }}" class="flex flex-wrap gap-3 items-center">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari driver atau telepon..."
                class="form-input"
                style="min-width:220px;"
            />
            <button type="submit" class="btn-primary">Cari</button>
        </form>

        <div class="text-sm text-gray-500">Menampilkan {{ $drivers->count() }} dari {{ $totalDrivers }} driver</div>
    </div>

    <div class="grid-responsive">
        @forelse ($drivers as $driver)
        <div class="card hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $driver->driver_name }}</h3>
                    <p class="text-sm text-gray-600 mt-1">Plat: <strong>{{ $driver->plate_number }}</strong></p>
                </div>
                <span class="badge badge-{{ $driver->status === 'tersedia' ? 'success' : ($driver->status === 'jalan' ? 'info' : 'danger') }}">{{ ucfirst($driver->status) }}</span>
            </div>

            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-lg h-24 flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>

            <div class="space-y-2 mb-4 pb-4 border-b border-gray-200 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Telepon:</span>
                    <span class="font-medium text-gray-900">{{ $driver->driver_phone ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Kendaraan:</span>
                    <span class="font-medium text-gray-900">{{ $driver->vehicle_type }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Kursi:</span>
                    <span class="font-medium text-gray-900">{{ $driver->seat_capacity }}</span>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('drivers.edit', $driver->id) }}" class="flex-1 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg font-medium hover:bg-blue-100 text-center text-sm transition-colors">Edit</a>
                <a href="{{ route('drivers.show', $driver->id) }}" class="flex-1 px-3 py-2 bg-gray-50 text-gray-700 rounded-lg font-medium hover:bg-gray-100 text-center text-sm transition-colors">Detail</a>
            </div>
        </div>
        @empty
        <div class="card col-span-full text-center text-gray-600">
            <div class="text-4xl mb-3">🚚</div>
            Belum ada driver ditemukan. Tambahkan driver baru untuk mulai menggunakan sistem.
        </div>
        @endforelse
    </div>
@endsection
