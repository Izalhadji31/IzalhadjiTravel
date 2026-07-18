@extends('layouts.app')

@section('title', 'Edit Driver')

@section('content')
    <div class="page-header mb-8">
        <h1 class="page-title">Edit Driver</h1>
        <p class="page-subtitle">Perbarui informasi driver dan kendaraan.</p>
    </div>

    <div class="max-w-2xl">
        <div class="card">
            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('drivers.update', $driver->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="driver_name" class="form-label">Nama Driver</label>
                    <input type="text" id="driver_name" name="driver_name" value="{{ old('driver_name', $driver->driver_name) }}" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="driver_phone" class="form-label">Telepon Driver</label>
                    <input type="text" id="driver_phone" name="driver_phone" value="{{ old('driver_phone', $driver->driver_phone) }}" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="plate_number" class="form-label">Nomor Plat</label>
                    <input type="text" id="plate_number" name="plate_number" value="{{ old('plate_number', $driver->plate_number) }}" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="vehicle_type" class="form-label">Jenis Kendaraan</label>
                    <input type="text" id="vehicle_type" name="vehicle_type" value="{{ old('vehicle_type', $driver->vehicle_type) }}" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="seat_capacity" class="form-label">Kapasitas Kursi</label>
                    <input type="number" id="seat_capacity" name="seat_capacity" value="{{ old('seat_capacity', $driver->seat_capacity) }}" min="1" max="30" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="tersedia" @if(old('status', $driver->status) === 'tersedia') selected @endif>Tersedia</option>
                        <option value="jalan" @if(old('status', $driver->status) === 'jalan') selected @endif>Jalan</option>
                        <option value="maintenance" @if(old('status', $driver->status) === 'maintenance') selected @endif>Maintenance</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary">Perbarui Driver</button>
                    <a href="{{ route('drivers.index') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
