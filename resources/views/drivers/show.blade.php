@extends('layouts.app')

@section('title', 'Driver Details')

@section('content')
    <div class="page-header mb-8">
        <h1 class="page-title">Detail Driver</h1>
        <p class="page-subtitle">Informasi lengkap driver dan armada.</p>
    </div>

    <div class="max-w-2xl">
        <div class="card space-y-6">
            <div class="space-y-2">
                <h2 class="text-xl font-semibold text-gray-900">{{ $driver->driver_name }}</h2>
                <p class="text-sm text-gray-600">Plat: <strong>{{ $driver->plate_number }}</strong></p>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="p-4 rounded-2xl bg-slate-50">
                    <p class="text-sm text-gray-500">Telepon</p>
                    <p class="text-lg font-medium text-gray-900">{{ $driver->driver_phone ?? 'Tidak tersedia' }}</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50">
                    <p class="text-sm text-gray-500">Jenis Kendaraan</p>
                    <p class="text-lg font-medium text-gray-900">{{ $driver->vehicle_type }}</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50">
                    <p class="text-sm text-gray-500">Kapasitas Kursi</p>
                    <p class="text-lg font-medium text-gray-900">{{ $driver->seat_capacity }}</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50">
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="text-lg font-medium text-gray-900">{{ ucfirst($driver->status ?? 'unknown') }}</p>
                </div>
            </div>

            <div class="space-y-3">
                <h3 class="text-base font-semibold text-gray-900">Partner</h3>
                <p class="text-sm text-gray-600">{{ optional($driver->mitra)->name ?? 'Partner tidak tersedia' }}</p>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('drivers.edit', $driver->id) }}" class="btn-primary">Edit Driver</a>
                <a href="{{ route('drivers.index') }}" class="btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection