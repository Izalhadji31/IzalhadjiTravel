@extends('layouts.app')

@section('title', 'Edit Armada')

@php
    /** @var \App\Models\Armada $armada */
    $armada = optional($armada);
@endphp

@section('content')
<div style="padding: 24px; background-color: #f1f5f9; min-height: 100vh;">
    <div style="max-width: 720px; margin: 0 auto; background: #fff; border-radius: 12px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div style="margin-bottom: 24px;">
            <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">Edit Armada</h1>
            <p style="color: #64748b; margin-top: 8px;">Perbarui data armada partner Anda.</p>
        </div>

        @if ($errors->any())
            <div style="margin-bottom: 20px; padding: 16px; border-radius: 12px; background: #fee2e2; color: #991b1b;">
                <ul style="list-style: disc inside; margin: 0; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('partner.armadas.update', data_get($armada, 'id')) }}" method="POST" style="display: grid; gap: 18px;">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #334155;">Nomor Plat *</label>
                    <input type="text" name="plate_number" value="{{ old('plate_number', data_get($armada, 'plate_number')) }}" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 10px;" />
                </div>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #334155;">Nama Driver *</label>
                    <input type="text" name="driver_name" value="{{ old('driver_name', data_get($armada, 'driver_name')) }}" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 10px;" />
                </div>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #334155;">Nomor HP Driver</label>
                    <input type="text" name="driver_phone" value="{{ old('driver_phone', data_get($armada, 'driver_phone')) }}" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 10px;" />
                </div>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #334155;">Jenis Kendaraan *</label>
                    <input type="text" name="vehicle_type" value="{{ old('vehicle_type', data_get($armada, 'vehicle_type')) }}" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 10px;" />
                </div>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #334155;">Kapasitas Kursi *</label>
                    <input type="number" name="seat_capacity" value="{{ old('seat_capacity', data_get($armada, 'seat_capacity')) }}" required min="1" max="30" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 10px;" />
                </div>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #334155;">Status</label>
                    <select name="status" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 10px;">
                        <option value="tersedia" @if(old('status', data_get($armada, 'status')) === 'tersedia') selected @endif>Tersedia</option>
                        <option value="jalan" @if(old('status', data_get($armada, 'status')) === 'jalan') selected @endif>Jalan</option>
                        <option value="maintenance" @if(old('status', data_get($armada, 'status')) === 'maintenance') selected @endif>Maintenance</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: flex-end; margin-top: 10px;">
                <a href="{{ route('partner.armadas') }}" style="padding: 12px 18px; border-radius: 10px; border: 1px solid #cbd5e1; color: #475569; text-decoration: none;">Batal</a>
                <button type="submit" style="padding: 12px 18px; background-color: #2563eb; color: #fff; border-radius: 10px; font-weight: 600;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
