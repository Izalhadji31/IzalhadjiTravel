@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-100 p-6">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Manajemen Booking</h1>
        <p class="mt-1 text-sm text-slate-500">Kelola semua booking travel dan rental</p>
    </div>

    <!-- Stats Cards -->
    <div class="mb-6 grid gap-4 md:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-lg border-l-4 border-amber-500 bg-white p-4 shadow-sm">
            <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500">Pending</div>
            <div class="mt-2 text-2xl font-bold text-amber-500">{{ $travelBookings->where('status', 'pending')->count() + $rentalBookings->where('status', 'pending')->count() }}</div>
        </div>
        <div class="rounded-lg border-l-4 border-blue-500 bg-white p-4 shadow-sm">
            <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500">Dikonfirmasi</div>
            <div class="mt-2 text-2xl font-bold text-blue-500">{{ $travelBookings->where('status', 'confirmed')->count() + $rentalBookings->where('status', 'confirmed')->count() }}</div>
        </div>
        <div class="rounded-lg border-l-4 border-orange-500 bg-white p-4 shadow-sm">
            <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500">Berangkat</div>
            <div class="mt-2 text-2xl font-bold text-orange-500">{{ $travelBookings->where('status', 'departed')->count() + $rentalBookings->where('status', 'departed')->count() }}</div>
        </div>
        <div class="rounded-lg border-l-4 border-green-500 bg-white p-4 shadow-sm">
            <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500">Selesai</div>
            <div class="mt-2 text-2xl font-bold text-green-500">{{ $travelBookings->where('status', 'completed')->count() + $rentalBookings->where('status', 'completed')->count() }}</div>
        </div>
        <div class="rounded-lg border-l-4 border-red-500 bg-white p-4 shadow-sm">
            <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500">Dibatalkan</div>
            <div class="mt-2 text-2xl font-bold text-red-500">{{ $travelBookings->where('status', 'cancelled')->count() + $rentalBookings->where('status', 'cancelled')->count() }}</div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <!-- Filter Bar -->
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-5 py-4">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.bookings') }}" class="inline-block rounded-md px-3.5 py-2 text-sm font-medium transition {{ request('status') === null || request('status') === '' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Semua</a>
                <a href="{{ route('admin.bookings', ['status' => 'pending']) }}" class="inline-block rounded-md px-3.5 py-2 text-sm font-medium transition {{ request('status') === 'pending' ? 'bg-amber-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Pending</a>
                <a href="{{ route('admin.bookings', ['status' => 'confirmed']) }}" class="inline-block rounded-md px-3.5 py-2 text-sm font-medium transition {{ request('status') === 'confirmed' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Dikonfirmasi</a>
                <a href="{{ route('admin.bookings', ['status' => 'departed']) }}" class="inline-block rounded-md px-3.5 py-2 text-sm font-medium transition {{ request('status') === 'departed' ? 'bg-orange-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Berangkat</a>
                <a href="{{ route('admin.bookings', ['status' => 'completed']) }}" class="inline-block rounded-md px-3.5 py-2 text-sm font-medium transition {{ request('status') === 'completed' ? 'bg-green-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Selesai</a>
                <a href="{{ route('admin.bookings', ['status' => 'cancelled']) }}" class="inline-block rounded-md px-3.5 py-2 text-sm font-medium transition {{ request('status') === 'cancelled' ? 'bg-red-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Dibatalkan</a>
            </div>
            <div class="text-sm text-slate-500">
                Total: <strong class="text-slate-700">{{ $travelBookings->count() + $rentalBookings->count() }}</strong> booking
            </div>
        </div>

        <!-- Table -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8fafc;">
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Kode</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Customer</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Tipe</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Rute / Kendaraan</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Tanggal</th>
                        <th style="padding: 12px 16px; text-align: right; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Harga</th>
                        <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Status</th>
                        <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $status = request('status', '');
                        $filteredTravel = $status ? $travelBookings->where('status', $status) : $travelBookings;
                        $filteredRental = $status ? $rentalBookings->where('status', $status) : $rentalBookings;
                    @endphp

                    @forelse($filteredTravel as $booking)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#f8fafc';" onmouseout="this.style.backgroundColor='transparent';">
                        <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #2563eb;">{{ $booking->booking_code ?? $booking->kode_booking ?? '#' . $booking->id }}</td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #1e293b;">{{ $booking->customer->name ?? $booking->nama_pelanggan ?? '-' }}</td>
                        <td style="padding: 12px 16px;">
                            <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #dbeafe; color: #1d4ed8;">Travel</span>
                        </td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #475569;">{{ $booking->route ?? $booking->rute ?? ($booking->origin ?? '') . ' → ' . ($booking->destination ?? '') }}</td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #475569;">{{ isset($booking->date) ? \Carbon\Carbon::parse($booking->date)->format('d M Y') : (isset($booking->tanggal) ? \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') : '-') }}</td>
                        <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #1e293b; text-align: right;">Rp {{ number_format($booking->price ?? $booking->harga ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 12px 16px; text-align: center;">
                            @php $s = $booking->status; @endphp
                            @php
                                $statusClass = match($s) {
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'confirmed' => 'bg-blue-100 text-blue-700',
                                    'departed' => 'bg-orange-100 text-orange-700',
                                    'completed' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    default => 'bg-slate-100 text-slate-700',
                                };
                            @endphp
                            <span class="inline-block rounded-full px-3 py-1 text-[11px] font-semibold capitalize {{ $statusClass }}">
                                {{ ucfirst($s) }}
                            </span>
                        </td>
                        <td style="padding: 12px 16px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center; align-items: center;">
                                @php
                                    $bookingType = $booking->number_of_seats !== null ? 'travel' : 'rental';
                                @endphp
                                <a href="{{ route('admin.bookings.show', ['type' => $bookingType, 'id' => $booking->id]) }}" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #64748b; color: #ffffff; border: none; cursor: pointer; text-decoration: none; transition: background-color 0.15s; display: inline-flex; align-items: center; gap: 3px;" onmouseover="this.style.backgroundColor='#475569';" onmouseout="this.style.backgroundColor='#64748b';">
                                    <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    View
                                </a>
                                @if($s === 'pending')
                                <button type="button"
                                        data-url="{{ route('admin.bookings.approve', ['type' => $bookingType, 'id' => $booking->id]) }}"
                                        onclick="openArmadaModal(this.dataset.url)"
                                        style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #3b82f6; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s;"
                                        onmouseover="this.style.backgroundColor='#2563eb';"
                                        onmouseout="this.style.backgroundColor='#3b82f6';">Setujui</button>
                                @endif
                                @if($s === 'confirmed' || $s === 'departed')
                                <form action="{{ route('admin.bookings.complete', ['type' => $bookingType, 'id' => $booking->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #22c55e; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#16a34a';" onmouseout="this.style.backgroundColor='#22c55e';">Selesai</button>
                                </form>
                                @endif
                                @if($s !== 'cancelled' && $s !== 'completed')
                                <form action="{{ route('admin.bookings.cancel', ['type' => $bookingType, 'id' => $booking->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Yakin ingin membatalkan booking ini?');" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #ef4444; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#dc2626';" onmouseout="this.style.backgroundColor='#ef4444';">Batalkan</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    @if($filteredRental->isEmpty())
                    <tr>
                        <td colspan="8" style="padding: 48px 16px; text-align: center; color: #94a3b8; font-size: 14px;">
                            <div style="font-size: 40px; margin-bottom: 8px; font-weight:700; color:#2563eb;">List</div>
                            Tidak ada booking untuk filter ini.
                        </td>
                    </tr>
                    @endif
                    @endforelse

                    @forelse($filteredRental as $booking)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#f8fafc';" onmouseout="this.style.backgroundColor='transparent';">
                        <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #2563eb;">{{ $booking->booking_code ?? $booking->kode_booking ?? '#' . $booking->id }}</td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #1e293b;">{{ $booking->customer->name ?? $booking->nama_pelanggan ?? '-' }}</td>
                        <td style="padding: 12px 16px;">
                            <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #e0e7ff; color: #4338ca;">Rental</span>
                        </td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #475569;">{{ $booking->vehicle->name ?? $booking->kendaraan->nama ?? ($booking->vehicle ?? '-') }}</td>
                        <td style="padding: 12px 16px; font-size: 13px; color: #475569;">{{ isset($booking->date) ? \Carbon\Carbon::parse($booking->date)->format('d M Y') : (isset($booking->tanggal) ? \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') : '-') }}</td>
                        <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #1e293b; text-align: right;">Rp {{ number_format($booking->price ?? $booking->harga ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 12px 16px; text-align: center;">
                            @php $s = $booking->status; @endphp
                            @php
                                $statusClass = match($s) {
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'confirmed' => 'bg-blue-100 text-blue-700',
                                    'departed' => 'bg-orange-100 text-orange-700',
                                    'completed' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    default => 'bg-slate-100 text-slate-700',
                                };
                            @endphp
                            <span class="inline-block rounded-full px-3 py-1 text-[11px] font-semibold capitalize {{ $statusClass }}">
                                {{ ucfirst($s) }}
                            </span>
                        </td>
                        <td style="padding: 12px 16px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center; align-items: center;">
                                @php
                                    $bookingType = $booking->number_of_seats !== null ? 'travel' : 'rental';
                                @endphp
                                <a href="{{ route('admin.bookings.show', ['type' => $bookingType, 'id' => $booking->id]) }}" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #64748b; color: #ffffff; border: none; cursor: pointer; text-decoration: none; transition: background-color 0.15s; display: inline-flex; align-items: center; gap: 3px;" onmouseover="this.style.backgroundColor='#475569';" onmouseout="this.style.backgroundColor='#64748b';">
                                    <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat
                                </a>
                                @if($s === 'pending')
                                <button type="button"
                                        data-url="{{ route('admin.bookings.approve', ['type' => $bookingType, 'id' => $booking->id]) }}"
                                        onclick="openArmadaModal(this.dataset.url)"
                                        style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #3b82f6; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s;"
                                        onmouseover="this.style.backgroundColor='#2563eb';"
                                        onmouseout="this.style.backgroundColor='#3b82f6';">Setujui</button>
                                @endif
                                @if($s === 'confirmed' || $s === 'departed')
                                <form action="{{ route('admin.bookings.complete', ['type' => $bookingType, 'id' => $booking->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #22c55e; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#16a34a';" onmouseout="this.style.backgroundColor='#22c55e';">Selesai</button>
                                </form>
                                @endif
                                @if($s !== 'cancelled' && $s !== 'completed')
                                <form action="{{ route('admin.bookings.cancel', ['type' => $bookingType, 'id' => $booking->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Yakin ingin membatalkan booking ini?');" style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; background-color: #ef4444; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#dc2626';" onmouseout="this.style.backgroundColor='#ef4444';">Batalkan</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    @if($filteredTravel->isEmpty())
                    <tr>
                        <td colspan="8" style="padding: 48px 16px; text-align: center; color: #94a3b8; font-size: 14px;">
                            <div style="font-size: 40px; margin-bottom: 8px; font-weight:700; color:#2563eb;">List</div>
                            Tidak ada booking untuk filter ini.
                        </td>
                    </tr>
                    @endif
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 px-5 py-3 text-sm text-slate-500">
            <span>Menampilkan {{ $filteredTravel->count() + $filteredRental->count() }} dari {{ $travelBookings->count() + $rentalBookings->count() }} booking</span>
            <span>Terakhir diperbarui: {{ now()->format('d M Y H:i') }}</span>
        </div>
    </div>
</div>

<!-- Armada Selection Modal -->
<div id="armadaModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50">
    <div class="w-[90%] max-w-[440px] rounded-lg bg-white p-6 shadow-2xl">
        <h3 class="mb-2 text-lg font-semibold text-slate-900">Atur Armada</h3>
        <p class="mb-4 text-sm text-slate-500">Pilih armada yang tersedia untuk ditugaskan sebelum mengonfirmasi booking ini:</p>
        <form id="armadaApproveForm" method="POST">
            @csrf
            <select name="armada_id" id="armadaSelect" class="mb-4 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700">
                <option value="">-- Pilih Armada Tersedia --</option>
                @php
                    $availableArmadas = \App\Models\Armada::where('status', 'tersedia')->orderBy('plate_number')->get();
                @endphp
                @forelse($availableArmadas as $armada)
                <option value="{{ $armada->id }}">{{ $armada->plate_number }} — {{ $armada->driver_name }} ({{ $armada->vehicle_type }}, {{ $armada->seat_capacity }} seats)</option>
                @empty
                <option value="" disabled>Tidak ada armada yang tersedia</option>
                @endforelse
            </select>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeArmadaModal()" class="rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-600">Batal</button>
                <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Konfirmasi & Setujui</button>
            </div>
        </form>
    </div>
</div>

<script>
let currentApproveUrl = '';
function openArmadaModal(url) {
    currentApproveUrl = url;
    document.getElementById('armadaModal').style.display = 'flex';
}
function closeArmadaModal() {
    document.getElementById('armadaModal').style.display = 'none';
    document.getElementById('armadaApproveForm').reset();
}
document.getElementById('armadaModal').addEventListener('click', function(e) {
    if (e.target === this) closeArmadaModal();
});
document.getElementById('armadaApproveForm').addEventListener('submit', function(e) {
    const armadaId = document.getElementById('armadaSelect').value;
    if (!armadaId) {
        alert('Silakan pilih armada terlebih dahulu sebelum menyetujui.');
        e.preventDefault();
        return;
    }
    this.action = currentApproveUrl;
});
</script>
@endsection
