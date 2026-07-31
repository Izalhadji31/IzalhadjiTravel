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

    <!-- Add Driver Form -->
    <div id="addForm" style="display: none; background: #fff; border-radius: 8px; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <h3 style="font-size: 16px; font-weight: 600; margin: 0 0 16px 0;">Tambah Driver Baru</h3>
        <form action="{{ route('partner.drivers.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Nama Driver *</label>
                    <input type="text" name="driver_name" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="Nama lengkap">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Nomor HP *</label>
                    <input type="text" name="driver_phone" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="08xxxxxxxxxx">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Nomor Plat Armada *</label>
                    <input type="text" name="plate_number" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="Contoh: AB 1234 CD">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Jenis Kendaraan *</label>
                    <input type="text" name="vehicle_type" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="Contoh: Avanza, Innova">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Kapasitas Kursi *</label>
                    <input type="number" name="seat_capacity" required min="1" max="30" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="Contoh: 7">
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
        <table style="width: 100%; border-collapse: collaps;">
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
                    <td style="padding: 12px 16px; font-size: 13px; color: #475569;">{{ $driver->driver_phone }}</td>
                    <td style="padding: 12px 16px; font-size: 13px; color: #2563eb; font-weight: 500;">{{ $driver->plate_number }}</td>
                    <td style="padding: 12px 16px; font-size: 13px; color: #475569;">{{ $driver->vehicle_type }} ({{ $driver->seat_capacity }} seat)</td>
                    <td style="padding: 12px 16px; text-align: center;">
                        <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; text-transform: capitalize;
                            {{ $driver->status === 'tersedia' ? 'background-color:#dcfce7;color:#166534;' : '' }}
                            {{ $driver->status === 'jalan' ? 'background-color:#dbeafe;color:#1e40af;' : '' }}
                            {{ $driver->status === 'maintenance' ? 'background-color:#fee2e2;color:#991b1b;' : '' }}">
                            {{ $driver->status }}
                        </span>
                    </td>
                    <td style="padding: 12px 16px; text-align: center;">
                        <a href="{{ route('partner.drivers.edit', $driver->id) }}" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #f1f5f9; color: #475569; text-decoration: none;">Edit</a>
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
