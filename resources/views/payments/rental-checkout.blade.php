@extends('layouts.app')

@section('content')
<style>
    .checkout-container {
        max-width: 80rem;
        margin: 0 auto;
        padding: 3rem 1rem;
    }
    @media (min-width: 640px) {
        .checkout-container { padding: 3rem 1.5rem; }
    }
    @media (min-width: 1024px) {
        .checkout-container { padding: 3rem 2rem; }
    }
    .checkout-header { margin-bottom: 2rem; }
    .back-link {
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
    }
    .back-link:hover { color: #1d4ed8; }
    .checkout-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: #111827;
        margin-top: 1rem;
    }
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    @media (min-width: 1024px) {
        .checkout-grid { grid-template-columns: 2fr 1fr; }
    }
    .card {
        background: #ffffff;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        padding: 1.5rem;
    }
    .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 1.5rem;
    }
    .detail-section {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }
    .detail-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .section-subtitle {
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.5rem;
    }
    .vehicle-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
    }
    .vehicle-plate {
        font-size: 0.875rem;
        color: #4b5563;
    }
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    .detail-label {
        font-size: 0.875rem;
        color: #4b5563;
    }
    .detail-value {
        font-weight: 600;
        color: #111827;
    }
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
    }
    .status-pending { background-color: #fef3c7; color: #92400e; }
    .status-success { background-color: #d1fae5; color: #065f46; }
    .status-failed { background-color: #fee2e2; color: #991b1b; }
    .summary-card {
        position: sticky;
        top: 1.5rem;
    }
    .summary-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 1.5rem;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }
    .total-label {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
    }
    .total-amount {
        font-size: 1.875rem;
        font-weight: 700;
        color: #2563eb;
    }
    .btn-pay {
        width: 100%;
        background-color: #2563eb;
        color: #ffffff;
        font-weight: 700;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.2s;
    }
    .btn-pay:hover { background-color: #1d4ed8; }
    .btn-retry {
        width: 100%;
        margin-top: 0.75rem;
        background-color: #e5e7eb;
        color: #111827;
        font-weight: 600;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.2s;
    }
    .btn-retry:hover { background-color: #d1d5db; }
    .success-box {
        background-color: #ecfdf5;
        border: 1px solid #a7f3d0;
        border-radius: 0.5rem;
        padding: 1rem;
        text-align: center;
    }
    .success-text {
        color: #047857;
        font-weight: 600;
    }
    .success-link {
        color: #059669;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-block;
        margin-top: 0.5rem;
        text-decoration: none;
    }
    .success-link:hover { color: #047857; }
    .secure-note {
        font-size: 0.75rem;
        color: #6b7280;
        text-align: center;
        margin-top: 1rem;
    }
    .countdown-timer {
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 0.5rem;
        padding: 0.75rem;
        text-align: center;
        margin-bottom: 1rem;
    }
    .countdown-label {
        font-size: 0.75rem;
        color: #991b1b;
        font-weight: 600;
    }
    .countdown-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #dc2626;
        font-variant-numeric: tabular-nums;
    }
    .rental-type {
        font-size: 0.875rem;
        color: #4b5563;
        margin-top: 0.25rem;
    }
</style>

<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ $clientKey }}"></script>

<div class="checkout-container">
    <!-- Header -->
    <div class="checkout-header">
        <a href="{{ route('bookings.rental') }}" class="back-link">
            ← Kembali ke Pemesanan
        </a>
        <h1 class="checkout-title">Pembayaran Rental</h1>
    </div>

    <div class="checkout-grid">
        <!-- Booking Details -->
        <div>
            <div class="card">
                <h2 class="card-title">Detail Pemesanan</h2>

                <!-- Vehicle Information -->
                <div class="detail-section">
                    <h3 class="section-subtitle">Kendaraan</h3>
                    <p class="vehicle-name">{{ $booking->armada->vehicle_name }}</p>
                    <p class="vehicle-plate">{{ $booking->armada->license_plate }}</p>
                    <p class="rental-type">
                        @if($booking->rental_type === 'with_driver')
                            Dengan Sopir
                        @else
                            Tanpa Sopir (Lepas Kunci)
                        @endif
                    </p>
                </div>

                <!-- Booking Details -->
                <div class="detail-grid detail-section">
                    <div>
                        <p class="detail-label">Kode Pemesanan</p>
                        <p class="detail-value">{{ $booking->booking_code }}</p>
                    </div>
                    <div>
                        <p class="detail-label">Durasi</p>
                        <p class="detail-value">{{ $booking->number_of_days }} hari</p>
                    </div>
                    <div>
                        <p class="detail-label">Tanggal Mulai</p>
                        <p class="detail-value">{{ $booking->start_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="detail-label">Tanggal Kembali</p>
                        <p class="detail-value">{{ $booking->end_date->format('d M Y') }}</p>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <p class="detail-label">Status Pembayaran</p>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                        @if($payment->status === 'success')
                            <span class="status-badge status-success">Success</span>
                        @elseif($payment->status === 'pending')
                            <span class="status-badge status-pending">Pending</span>
                        @else
                            <span class="status-badge status-failed">Failed</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div>
            <div class="card summary-card">
                <h3 class="summary-title">Ringkasan Pembayaran</h3>

                <div class="summary-row">
                    <span style="color: #4b5563;">Tarif Harian × {{ $booking->number_of_days }}</span>
                    <span style="font-weight: 600;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>

                <div class="summary-total">
                    <span class="total-label">Total</span>
                    <span class="total-amount">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </span>
                </div>

                @if($payment->status === 'success')
                    <div class="success-box">
                        <p class="success-text">✓ Pembayaran Berhasil</p>
                        <a href="{{ route('bookings.rental.show', $booking) }}" class="success-link">
                            Lihat Detail Pemesanan →
                        </a>
                    </div>
                @else
                    @if($payment->status === 'pending')
                        <div class="countdown-timer" id="countdown-timer">
                            <p class="countdown-label">Batas Pembayaran</p>
                            <p class="countdown-value" id="countdown-display">23:59:59</p>
                        </div>
                    @endif

                    <button onclick="triggerMidtransPayment()" class="btn-pay">
                        Bayar Sekarang
                    </button>

                    @if($payment->status === 'failed')
                        <button onclick="retryPayment()" class="btn-retry">
                            Coba Lagi
                        </button>
                    @endif
                @endif

                <p class="secure-note">
                    Pembayaran aman dengan Midtrans
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    let snapToken = "{{ $snapToken ?? null }}";

    // Countdown Timer (24 hours from payment creation)
    @if($payment->status === 'pending')
    (function() {
        // Calculate deadline: 24 hours from payment created_at
        const createdAt = new Date("{{ $payment->created_at->toIso8601String() }}");
        const deadline = new Date(createdAt.getTime() + 24 * 60 * 60 * 1000);

        function updateCountdown() {
            const now = new Date();
            const diff = deadline - now;

            if (diff <= 0) {
                document.getElementById('countdown-display').textContent = "00:00:00";
                document.getElementById('countdown-timer').style.display = 'none';
                return;
            }

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            const display = String(hours).padStart(2, '0') + ':' +
                           String(minutes).padStart(2, '0') + ':' +
                           String(seconds).padStart(2, '0');
            document.getElementById('countdown-display').textContent = display;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();
    @endif

    function triggerMidtransPayment() {
        if (!snapToken || snapToken === 'null') {
            alert('Token pembayaran tidak tersedia');
            return;
        }

        snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log('Payment successful:', result);
                window.location.href = "{{ route('payments.success') }}?" + new URLSearchParams({
                    order_id: result.order_id,
                    status_code: result.status_code,
                    transaction_status: result.transaction_status
                }).toString();
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                window.location.href = "{{ route('payments.pending') }}?" + new URLSearchParams({
                    order_id: result.order_id,
                    status_code: result.status_code
                }).toString();
            },
            onError: function(result) {
                console.log('Payment error:', result);
                window.location.href = "{{ route('payments.error') }}?" + new URLSearchParams({
                    order_id: result.order_id,
                    status_code: result.status_code
                }).toString();
            },
            onClose: function() {
                console.log('Payment modal closed');
            }
        });
    }

    function retryPayment() {
        fetch("{{ route('payments.retry', $payment) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                snapToken = data.snapToken;
                triggerMidtransPayment();
            } else {
                alert('Gagal mempersiapkan pembayaran ulang: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
</script>
@endsection
