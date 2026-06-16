@extends('layouts.app')

@section('title', 'Dashboard Mitra')

@section('content')
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 class="page-title">Dashboard Mitra</h1>
            <p class="page-subtitle">Selamat datang kembali! Pantau operasional armada dan bagi hasil Anda secara real-time.</p>
        </div>
        <div style="background: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.9rem;">
            Mitra: {{ $partner ? $partner->name : 'N/A' }}
        </div>
    </div>

    <!-- Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Total Earnings (Bagi Hasil) -->
        <div class="card" style="border-left: 4px solid #059669;">
            <p style="color: #666; font-size: 0.9rem; margin: 0;">Total Pendapatan Bagi Hasil</p>
            <p style="color: #059669; font-size: 1.8rem; font-weight: 700; margin: 0.5rem 0 0.25rem 0;">
                Rp {{ number_format($totalEarnings, 0, ',', '.') }}
            </p>
            <p style="color: #999; font-size: 0.75rem; margin: 0;">Persentase Bagi Hasil: {{ $partner ? $partner->revenue_share_percentage : 50 }}%</p>
        </div>

        <!-- Total Armada -->
        <div class="card" style="border-left: 4px solid #2563eb;">
            <p style="color: #666; font-size: 0.9rem; margin: 0;">Total Armada Mobil</p>
            <p style="color: #2563eb; font-size: 1.8rem; font-weight: 700; margin: 0.5rem 0 0.25rem 0;">
                {{ $totalVehicles ?? 0 }} Kendaraan
            </p>
            <p style="color: #999; font-size: 0.75rem; margin: 0;">Terdaftar di sistem ASR GO</p>
        </div>

        <!-- Active / Jalan -->
        <div class="card" style="border-left: 4px solid #3b82f6;">
            <p style="color: #666; font-size: 0.9rem; margin: 0;">Armada Beroperasi (Jalan)</p>
            <p style="color: #3b82f6; font-size: 1.8rem; font-weight: 700; margin: 0.5rem 0 0.25rem 0;">
                {{ $activeVehicles ?? 0 }} Kendaraan
            </p>
            <p style="color: #999; font-size: 0.75rem; margin: 0;">Sedang dalam trip / disewa</p>
        </div>

        <!-- Available & Maintenance -->
        <div class="card" style="border-left: 4px solid #f59e0b;">
            <p style="color: #666; font-size: 0.9rem; margin: 0;">Tersedia / Perawatan</p>
            <p style="color: #f59e0b; font-size: 1.8rem; font-weight: 700; margin: 0.5rem 0 0.25rem 0;">
                {{ $availableVehicles ?? 0 }} / {{ $maintenanceVehicles ?? 0 }}
            </p>
            <p style="color: #999; font-size: 0.75rem; margin: 0;">Siap jalan vs Sedang diservis</p>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        
        <!-- Fleet Status Section -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.1rem; font-weight: 600; color: #111; margin: 0;">Daftar Armada & Status Operasional</h2>
                <a href="/tracking" class="btn btn-primary" style="font-size: 0.85rem; padding: 0.4rem 0.8rem;">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Buka Peta Pelacakan
                </a>
            </div>

            @if($armadas && $armadas->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; font-size: 0.9rem; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 1px solid #e5e7eb; text-align: left;">
                                <th style="padding: 0.75rem; color: #666; font-weight: 500;">Pelat Nomor</th>
                                <th style="padding: 0.75rem; color: #666; font-weight: 500;">Jenis Mobil</th>
                                <th style="padding: 0.75rem; color: #666; font-weight: 500;">Kapasitas Kursi</th>
                                <th style="padding: 0.75rem; color: #666; font-weight: 500;">Sopir & Kontak</th>
                                <th style="padding: 0.75rem; color: #666; font-weight: 500;">Status Operasional</th>
                                <th style="padding: 0.75rem; color: #666; font-weight: 500;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($armadas as $armada)
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    <td style="padding: 0.75rem; font-weight: 600; color: #111;">{{ $armada->plate_number }}</td>
                                    <td style="padding: 0.75rem; color: #333;">{{ $armada->vehicle_type }}</td>
                                    <td style="padding: 0.75rem; color: #666;">{{ $armada->seat_capacity }} Penumpang</td>
                                    <td style="padding: 0.75rem; color: #333;">
                                        <div style="font-weight: 500;">{{ $armada->driver_name }}</div>
                                        <div style="font-size: 0.8rem; color: #666;">{{ $armada->driver_phone }}</div>
                                    </td>
                                    <td style="padding: 0.75rem;">
                                        @if($armada->status === 'tersedia')
                                            <span style="display: inline-block; background: #d1fae5; color: #059669; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.8rem; font-weight: 500;">Tersedia (Garasi)</span>
                                        @elseif($armada->status === 'jalan')
                                            <span style="display: inline-block; background: #dbeafe; color: #2563eb; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.8rem; font-weight: 500;">Sedang Jalan (Trip)</span>
                                        @elseif($armada->status === 'maintenance')
                                            <span style="display: inline-block; background: #fee2e2; color: #dc2626; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.8rem; font-weight: 500;">Perawatan</span>
                                        @else
                                            <span style="display: inline-block; background: #f3f4f6; color: #666; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.8rem; font-weight: 500;">{{ $armada->status }}</span>
                                        @endif
                                    </td>
                                    <td style="padding: 0.75rem;">
                                        <a href="/tracking/vehicle/{{ $armada->id }}" style="color: #2563eb; text-decoration: none; font-weight: 600; font-size: 0.85rem;">Detail Lacak</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: #666;">
                    <p style="margin: 0 0 1rem 0;">Anda belum memiliki armada yang terdaftar.</p>
                    <a href="/vehicles/create" class="btn btn-primary">Daftarkan Mobil Pertama Anda</a>
                </div>
            @endif
        </div>

        <!-- Revenue sharing & reports -->
        <div class="card" style="display: flex; flex-direction: column;">
            <h2 style="font-size: 1.1rem; font-weight: 600; color: #111; margin: 0 0 1rem 0;">Laporan Keuangan & Bagi Hasil</h2>
            
            @if($revenueSharings && $revenueSharings->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 1rem; flex: 1;">
                    @foreach($revenueSharings as $sharing)
                        <div style="border-bottom: 1px solid #f3f4f6; padding-bottom: 0.75rem;">
                            <div style="display: flex; justify-content: space-between; align-items: start;">
                                <div>
                                    <div style="font-size: 0.85rem; font-weight: 600; color: #111;">
                                        Booking Code: {{ $sharing->booking ? $sharing->booking->booking_code : 'N/A' }}
                                    </div>
                                    <div style="font-size: 0.75rem; color: #666;">
                                        {{ $sharing->created_at ? $sharing->created_at->format('d M Y, H:i') : '-' }}
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 0.9rem; font-weight: 700; color: #059669;">
                                        +Rp {{ number_format($sharing->mitra_amount, 0, ',', '.') }}
                                    </div>
                                    <div style="font-size: 0.75rem; color: #999;">
                                        Share: {{ $sharing->mitra_percentage }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 2rem; color: #666; flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <p style="margin: 0;">Belum ada riwayat transaksi bagi hasil yang tercatat.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
