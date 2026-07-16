@extends('layouts.app')

@section('content')
<div style="padding: 24px; background-color: #f1f5f9; min-height: 100vh;">
    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">Armada Saya</h1>
            <p style="font-size: 14px; color: #64748b; margin: 4px 0 0 0;">Kelola armada milik partner Anda</p>
        </div>
        <button onclick="document.getElementById('addForm').style.display='block'" style="padding: 10px 20px; background-color: #2563eb; color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px;">
            + Tambah Armada
        </button>
    </div>

    <!-- Add Armada Form (Hidden by default) -->
    <div id="addForm" style="display: none; background: #fff; border-radius: 8px; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <h3 style="font-size: 16px; font-weight: 600; margin: 0 0 16px 0;">Tambah Armada Baru</h3>
        <form action="{{ route('partner.armadas.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Nomor Plat *</label>
                    <input type="text" name="plate_number" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="Contoh: AB 1234 CD">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Nama Driver *</label>
                    <input type="text" name="driver_name" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="Nama lengkap driver">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Nomor HP Driver *</label>
                    <input type="text" name="driver_phone" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="08xxxxxxxxxx">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Jenis Kendaraan *</label>
                    <input type="text" name="vehicle_type" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;" placeholder="Contoh: Avanza, Innova, Hiace">
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

    <!-- Armada Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px;">
        @forelse($armadas as $armada)
        @php
            $borderClass = 'border-l-4 border-rose-500';
            $badgeClass = 'inline-flex items-center justify-center rounded-full px-3 py-1 text-xs font-semibold text-center';
            if ($armada->status === 'tersedia') {
                $borderClass = 'border-l-4 border-emerald-500';
                $badgeClass .= ' bg-emerald-100 text-emerald-800';
            } elseif ($armada->status === 'jalan') {
                $borderClass = 'border-l-4 border-sky-500';
                $badgeClass .= ' bg-sky-100 text-sky-800';
            } elseif ($armada->status === 'maintenance') {
                $borderClass = 'border-l-4 border-rose-500';
                $badgeClass .= ' bg-rose-100 text-rose-800';
            } else {
                $badgeClass .= ' bg-slate-100 text-slate-700';
            }
        @endphp
        <div class="bg-white rounded-2xl p-5 shadow-sm {{ $borderClass }}">
            <div class="flex justify-between items-start gap-3 mb-3">
                <div>
                    <div class="text-base font-semibold text-slate-900">{{ $armada->plate_number }}</div>
                    <div class="text-sm text-slate-500">{{ $armada->vehicle_type }}</div>
                </div>
                <span class="{{ $badgeClass }}" style="text-transform: capitalize;">
                    {{ $armada->status }}
                </span>
            </div>
            <div style="font-size: 13px; color: #475569; margin-bottom: 8px;">
                <strong>Driver:</strong> {{ $armada->driver_name }}
            </div>
            <div style="font-size: 13px; color: #475569; margin-bottom: 8px;">
                <strong>HP:</strong> {{ $armada->driver_phone }}
            </div>
            <div style="font-size: 13px; color: #475569; margin-bottom: 16px;">
                <strong>Kapasitas:</strong> {{ $armada->seat_capacity }} kursi
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('partner.armadas.edit', $armada->id) }}" style="padding: 6px 14px; background-color: #f1f5f9; color: #475569; border-radius: 4px; font-size: 12px; font-weight: 600; text-decoration: none;">Edit</a>
                @if($armada->status === 'tersedia')
                <form action="{{ route('partner.armadas.update', $armada->id) }}" method="POST" style="display:inline;">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="maintenance">
                    <button type="submit" style="padding: 6px 14px; background-color: #fef3c7; color: #92400e; border: none; border-radius: 4px; font-size: 12px; font-weight: 600; cursor: pointer;">Maintenance</button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; background: #fff; border-radius: 8px; padding: 48px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
            <div style="font-size: 40px; margin-bottom: 8px;">🚗</div>
            <p style="color: #94a3b8; font-size: 14px;">Belum ada armada. Tambahkan armada pertama Anda.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
