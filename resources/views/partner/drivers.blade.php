@extends('layouts.app')

@section('content')
<div style="padding: 24px; background-color: #f1f5f9; min-height: 100vh;">
    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">Driver Saya</h1>
            <p style="font-size: 14px; color: #64748b; margin: 4px 0 0 0;">Kelola driver milik partner Anda</p>
        </div>
        <button onclick="document.getElementById('addForm').style.display='block'" style="padding: 10px 20px; background-color: #2563eb; color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px;">
            + Tambah Driver
        </button>
    </div>

    @if(session('success'))
        <div style="margin-bottom: 20px; padding: 16px; border-radius: 12px; background: #d1fae5; color: #0f766e;">{{ session('success') }}</div>
    @endif
    @if(session('warning'))
        <div style="margin-bottom: 20px; padding: 16px; border-radius: 12px; background: #fef3c7; color: #92400e;">{{ session('warning') }}</div>
    @endif

    <!-- Add Driver Form -->
    <div id="addForm" style="display: none; background: #fff; border-radius: 8px; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <h3 style="font-size: 16px; font-weight: 600; margin: 0 0 16px 0;">Tambah Driver Baru</h3>
        <form action="{{ route('partner.drivers.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Nama Driver *</label>
                    <input type="text" name="driver_name" value="{{ old('driver_name') }}" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="Nama lengkap">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Nomor HP</label>
                    <input type="text" name="driver_phone" value="{{ old('driver_phone') }}" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="08xxxxxxxxxx">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Nomor Plat Armada *</label>
                    <input type="text" name="plate_number" value="{{ old('plate_number') }}" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="Contoh: AB 1234 CD">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Jenis Kendaraan *</label>
                    <input type="text" name="vehicle_type" value="{{ old('vehicle_type') }}" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="Contoh: Avanza, Innova">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Kapasitas Kursi *</label>
                    <input type="number" name="seat_capacity" value="{{ old('seat_capacity') }}" required min="1" max="30" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="Contoh: 7">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Status</label>
                    <select name="status" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                        <option value="tersedia" @if(old('status') === 'tersedia') selected @endif>Tersedia</option>
                        <option value="jalan" @if(old('status') === 'jalan') selected @endif>Jalan</option>
                        <option value="maintenance" @if(old('status') === 'maintenance') selected @endif>Maintenance</option>
                    </select>
                </div>
            </div>
            <div style="margin-top: 16px; display: flex; gap: 8px;">
                <button type="submit" style="padding: 8px 20px; background-color: #2563eb; color: #fff; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px;">Simpan</button>
                <button type="button" onclick="document.getElementById('addForm').style.display='none'" style="padding: 8px 20px; background-color: #f1f5f9; color: #475569; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px;">Batal</button>
            </div>
        </form>
    </div>

    <!-- Drivers Table -->
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f8fafc;">
                    <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">Nama</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">HP</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">Plat</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">Kendaraan</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">Status</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($drivers as $driver)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #1e293b;">{{ $driver->driver_name }}</td>
                    <td style="padding: 12px 16px; font-size: 13px; color: #475569;">{{ $driver->driver_phone ?? '-' }}</td>
                    <td style="padding: 12px 16px; font-size: 13px; color: #2563eb; font-weight: 500;">{{ $driver->plate_number }}</td>
                    <td style="padding: 12px 16px; font-size: 13px; color: #475569;">{{ $driver->vehicle_type }} ({{ $driver->seat_capacity }} seat)</td>
                    @php
                        $statusClass = 'inline-flex items-center justify-center rounded-full px-3 py-1 text-xs font-semibold';
                        if ($driver->status === 'tersedia') {
                            $statusClass .= ' bg-emerald-100 text-emerald-800';
                        } elseif ($driver->status === 'jalan') {
                            $statusClass .= ' bg-sky-100 text-sky-800';
                        } elseif ($driver->status === 'maintenance') {
                            $statusClass .= ' bg-rose-100 text-rose-800';
                        } else {
                            $statusClass .= ' bg-slate-100 text-slate-700';
                        }
                    @endphp
                    <td style="padding: 12px 16px; text-align: center;">
                        <span class="{{ $statusClass }}" style="text-transform: capitalize;">
                            {{ $driver->status ?? 'Unknown' }}
                        </span>
                    </td>
                    <td style="padding: 12px 16px; text-align: center;">
                        <a href="{{ route('partner.drivers.edit', $driver->id) }}" style="padding: 6px 12px; border-radius: 6px; background-color: #f8fafc; color: #1d4ed8; text-decoration: none; font-size: 12px; font-weight: 600;">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 48px 16px; text-align: center; color: #94a3b8; font-size: 14px;">
                        <div style="font-size: 40px; margin-bottom: 8px;">👨‍✈️</div>
                        Belum ada driver. Tambahkan driver pertama Anda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
