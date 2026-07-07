@extends('layouts.app')

@section('title', 'Booking Detail')

@section('content')
<div style="padding: 24px; background-color: #f1f5f9; min-height: 100vh;">
    <!-- Page Header -->
    <div style="margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">Detail Booking</h1>
            <p style="font-size: 14px; color: #64748b; margin: 4px 0 0 0;">Kelola booking #{{ $booking->booking_code ?? $booking->id }}</p>
        </div>
        <a href="{{ route('admin.bookings') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none; background-color: #ffffff; color: #475569; border: 1px solid #e2e8f0; transition: all 0.15s;" onmouseover="this.style.backgroundColor='#f8fafc';" onmouseout="this.style.backgroundColor='#ffffff';">
            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Booking
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div style="margin-bottom: 16px; padding: 12px 16px; background-color: #dcfce7; color: #166534; border-radius: 6px; font-size: 14px; border: 1px solid #bbf7d0;">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="margin-bottom: 16px; padding: 12px 16px; background-color: #fee2e2; color: #991b1b; border-radius: 6px; font-size: 14px; border: 1px solid #fecaca;">
        {{ session('error') }}
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        <!-- Left Column: Booking Info -->
        <div>
            <!-- Booking Info Card -->
            <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); overflow: hidden; margin-bottom: 24px;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                    <h2 style="font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Booking Information</h2>
                    @php $s = $booking->status; @endphp
                    <span style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; text-transform: capitalize;
                        {{ $s === 'pending' ? 'background-color:#fef3c7;color:#92400e;' : '' }}
                        {{ $s === 'confirmed' ? 'background-color:#dbeafe;color:#1e40af;' : '' }}
                        {{ $s === 'departed' ? 'background-color:#ffedd5;color:#9a3412;' : '' }}
                        {{ $s === 'completed' ? 'background-color:#dcfce7;color:#166534;' : '' }}
                        {{ $s === 'cancelled' ? 'background-color:#fee2e2;color:#991b1b;' : '' }}">
                        {{ ucfirst($s) }}
                    </span>
                </div>
                <div style="padding: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <div style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Kode Booking</div>
                            <div style="font-size: 14px; font-weight: 600; color: #2563eb;">{{ $booking->booking_code ?? '-' }}</div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Tipe</div>
                            <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; {{ $type === 'travel' ? 'background-color:#dbeafe;color:#1d4ed8;' : 'background-color:#e0e7ff;color:#4338ca;' }}">
                                {{ ucfirst($type) }}
                            </span>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Customer</div>
                            <div style="font-size: 14px; font-weight: 500; color: #1e293b;">{{ $booking->user->name ?? '-' }}</div>
                            <div style="font-size: 12px; color: #64748b;">{{ $booking->user->email ?? '' }}</div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Rute</div>
                            <div style="font-size: 14px; font-weight: 500; color: #1e293b;">{{ $booking->route->name ?? $booking->route->nama_rute ?? ($booking->route->origin ?? '') . ' → ' . ($booking->route->destination ?? '') }}</div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Tanggal</div>
                                @if($type === 'travel')
                                    {{ $booking->scheduled_date ? \Carbon\Carbon::parse($booking->scheduled_date)->format('d M Y') : '-' }}
                                @else
                                    {{ $booking->start_date ? \Carbon\Carbon::parse($booking->start_date)->format('d M Y') : '-' }}
                                @endif
                            </div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Waktu</div>
                            <div style="font-size: 14px; font-weight: 500; color: #1e293b;">
                                @if($type === 'travel')
                                    {{ $booking->departure_time ? \Carbon\Carbon::parse($booking->departure_time)->format('H:i') : '-' }}
                                @else
                                    {{ $booking->start_time ? \Carbon\Carbon::parse($booking->start_time)->format('H:i') : '-' }}
                                @endif
                            </div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Total Harga</div>
                            <div style="font-size: 18px; font-weight: 700; color: #1e293b;">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</div>
                        </div>
                        @if($type === 'travel')
                        <div>
                            <div style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Kursi</div>
                            <div style="font-size: 14px; font-weight: 500; color: #1e293b;">{{ $booking->number_of_seats ?? '-' }}</div>
                        </div>
                        @else
                        <div>
                            <div style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Tipe Rental</div>
                            <div style="font-size: 14px; font-weight: 500; color: #1e293b;">{{ ucfirst(str_replace('_', ' ', $booking->rental_type ?? '-')) }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Info Card -->
            @if($booking->payments && $booking->payments->count() > 0)
            <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); overflow: hidden;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0;">
                    <h2 style="font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Informasi Pembayaran</h2>
                </div>
                <div style="padding: 20px;">
                    @foreach($booking->payments as $payment)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; {{ !$loop->last ? 'border-bottom: 1px solid #f1f5f9;' : '' }}">
                        <div>
                            <div style="font-size: 14px; font-weight: 500; color: #1e293b;">{{ $payment->payment_method ?? 'Payment' }} #{{ $payment->id }}</div>
                            <div style="font-size: 12px; color: #64748b;">{{ $payment->created_at ? \Carbon\Carbon::parse($payment->created_at)->format('d M Y H:i') : '' }}</div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 14px; font-weight: 600; color: #1e293b;">Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}</div>
                            @php $ps = $payment->status; @endphp
                            <span style="display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 600; text-transform: uppercase;
                                {{ $ps === 'success' ? 'background-color:#dcfce7;color:#166534;' : '' }}
                                {{ $ps === 'pending' ? 'background-color:#fef3c7;color:#92400e;' : '' }}
                                {{ $ps === 'failed' ? 'background-color:#fee2e2;color:#991b1b;' : '' }}">
                                {{ ucfirst($ps) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column: Armada & Actions -->
        <div>
            <!-- Armada Assignment Card -->
            <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); overflow: hidden; margin-bottom: 24px;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0;">
                    <h2 style="font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Penugasan Armada</h2>
                </div>
                <div style="padding: 20px;">
                    @if($booking->armada)
                    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; padding: 16px; margin-bottom: 16px;">
                        <div style="font-size: 12px; color: #166534; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Saat Ini Ditugaskan</div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                            <div>
                                <div style="font-size: 11px; color: #64748b;">Plat Nomor</div>
                                <div style="font-size: 14px; font-weight: 600; color: #1e293b;">{{ $booking->armada->plate_number ?? '-' }}</div>
                            </div>
                            <div>
                                <div style="font-size: 11px; color: #64748b;">Sopir</div>
                                <div style="font-size: 14px; font-weight: 600; color: #1e293b;">{{ $booking->armada->driver_name ?? '-' }}</div>
                            </div>
                            <div>
                                <div style="font-size: 11px; color: #64748b;">Tipe Kendaraan</div>
                                <div style="font-size: 14px; font-weight: 500; color: #1e293b;">{{ $booking->armada->vehicle_type ?? '-' }}</div>
                            </div>
                            <div>
                                <div style="font-size: 11px; color: #64748b;">Telepon</div>
                                <div style="font-size: 14px; font-weight: 500; color: #1e293b;">{{ $booking->armada->driver_phone ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div style="background-color: #fef3c7; border: 1px solid #fde68a; border-radius: 6px; padding: 16px; margin-bottom: 16px;">
                        <div style="font-size: 13px; color: #92400e; font-weight: 500;">Belum ada armada ditugaskan</div>
                    </div>
                    @endif

                    @if($booking->status === 'pending' || $booking->status === 'confirmed')
                    <form action="{{ route('admin.bookings.approve', ['type' => $type, 'id' => $booking->id]) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 6px;">Tugaskan / Ganti Armada</label>
                            <select name="armada_id" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; color: #1e293b; background-color: #ffffff;">
                                <option value="">-- Pilih Armada Tersedia --</option>
                                @forelse($availableArmadas as $armada)
                                <option value="{{ $armada->id }}" {{ $booking->assigned_armada_id == $armada->id ? 'selected' : '' }}>
                                    {{ $armada->plate_number }} - {{ $armada->driver_name }} ({{ $armada->vehicle_type }}, {{ $armada->seat_capacity }} seats)
                                </option>
                                @empty
                                <option value="" disabled>Tidak ada armada tersedia</option>
                                @endforelse
                            </select>
                        </div>
                        <button type="submit" style="width: 100%; padding: 10px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; background-color: #3b82f6; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s; display: flex; align-items: center; justify-content: center; gap: 6px;" onmouseover="this.style.backgroundColor='#2563eb';" onmouseout="this.style.backgroundColor='#3b82f6';">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $booking->armada ? 'Perbarui Armada' : 'Tugaskan Armada & Konfirmasi' }}
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Status Actions Card -->
            <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); overflow: hidden;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0;">
                    <h2 style="font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Aksi Status</h2>
                </div>
                <div style="padding: 20px;">
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        @if($booking->status === 'pending')
                        <form action="{{ route('admin.bookings.approve', ['type' => $type, 'id' => $booking->id]) }}" method="POST" id="confirmForm">
                            @csrf
                            <input type="hidden" name="armada_id" id="confirmArmadaId" value="">
                            <button type="button" onclick="openConfirmModal()" style="width: 100%; padding: 10px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; background-color: #3b82f6; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s; display: flex; align-items: center; justify-content: center; gap: 6px;" onmouseover="this.style.backgroundColor='#2563eb';" onmouseout="this.style.backgroundColor='#3b82f6';">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Konfirmasi Booking
                            </button>
                        </form>
                        @endif

                        @if($booking->status === 'confirmed' || $booking->status === 'departed')
                        <form action="{{ route('admin.bookings.complete', ['type' => $type, 'id' => $booking->id]) }}" method="POST">
                            @csrf
                            <button type="submit" style="width: 100%; padding: 10px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; background-color: #22c55e; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s; display: flex; align-items: center; justify-content: center; gap: 6px;" onmouseover="this.style.backgroundColor='#16a34a';" onmouseout="this.style.backgroundColor='#22c55e';">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Tandai Selesai
                            </button>
                        </form>
                        @endif

                        @if(!in_array($booking->status, ['completed', 'cancelled']))
                        <form action="{{ route('admin.bookings.cancel', ['type' => $type, 'id' => $booking->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan booking ini? Tindakan ini tidak bisa dibatalkan.');">
                            @csrf
                            <button type="submit" style="width: 100%; padding: 10px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; background-color: #ef4444; color: #ffffff; border: none; cursor: pointer; transition: background-color 0.15s; display: flex; align-items: center; justify-content: center; gap: 6px;" onmouseover="this.style.backgroundColor='#dc2626';" onmouseout="this.style.backgroundColor='#ef4444';">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Batalkan Booking
                            </button>
                        </form>
                        @endif

                        @if(in_array($booking->status, ['completed', 'cancelled']))
                        <div style="text-align: center; padding: 16px; color: #94a3b8; font-size: 13px;">
                            Tidak ada tindakan lanjutan untuk booking {{ $booking->status }}.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Modal -->
<div id="confirmModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center;">
    <div style="background: #ffffff; border-radius: 8px; padding: 24px; max-width: 400px; width: 90%; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <h3 style="font-size: 18px; font-weight: 600; color: #1e293b; margin: 0 0 16px 0;">Konfirmasi Booking</h3>
        <p style="font-size: 14px; color: #64748b; margin: 0 0 16px 0;">Pilih armada untuk ditugaskan sebelum konfirmasi:</p>
        <select id="modalArmadaSelect" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; color: #1e293b; background-color: #ffffff; margin-bottom: 16px;">
            <option value="">-- Pilih Armada Tersedia --</option>
            @forelse($availableArmadas as $armada)
            <option value="{{ $armada->id }}">{{ $armada->plate_number }} - {{ $armada->driver_name }} ({{ $armada->vehicle_type }})</option>
            @empty
            <option value="" disabled>Tidak ada armada tersedia</option>
            @endforelse
        </select>
        <div style="display: flex; gap: 10px; justify-content: flex-end;">
            <button type="button" onclick="closeConfirmModal()" style="padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 500; background-color: #f1f5f9; color: #475569; border: none; cursor: pointer;">Batal</button>
            <button type="button" onclick="submitConfirmForm()" style="padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; background-color: #3b82f6; color: #ffffff; border: none; cursor: pointer;">Konfirmasi</button>
        </div>
    </div>
</div>

<script>
function openConfirmModal() {
    document.getElementById('confirmModal').style.display = 'flex';
}
function closeConfirmModal() {
    document.getElementById('confirmModal').style.display = 'none';
}
function submitConfirmForm() {
    const armadaId = document.getElementById('modalArmadaSelect').value;
    if (!armadaId) {
        alert('Silakan pilih armada terlebih dahulu.');
        return;
    }
    document.getElementById('confirmArmadaId').value = armadaId;
    document.getElementById('confirmForm').submit();
}
// Close modal when clicking outside
document.getElementById('confirmModal').addEventListener('click', function(e) {
    if (e.target === this) closeConfirmModal();
});
</script>
@endsection
