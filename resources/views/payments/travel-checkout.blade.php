@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; background-color: #f9fafb; padding: 3rem 1rem;">
    <div style="max-width: 72rem; margin: 0 auto;">
        <!-- Header -->
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('bookings.travel') }}" style="color: #2563eb; font-weight: 600; text-decoration: none; font-size: 0.95rem;">
                ← Kembali ke Pemesanan
            </a>
            <h1 style="font-size: 2.25rem; font-weight: 700; color: #111827; margin-top: 1rem; margin-bottom: 0;">Pembayaran Travel</h1>
        </div>

        <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
            @media (min-width: 1024px)
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            @endif

            <!-- Booking Details -->
            <div>
                <div style="background: #ffffff; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); padding: 1.5rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin-top: 0; margin-bottom: 1.5rem;">Detail Pemesanan</h2>

                    <!-- Countdown Timer -->
                    <div style="background: #fef3c7; border: 1px solid #fcd34d; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="font-size: 1.25rem;">⏰</span>
                            <span style="font-weight: 600; color: #92400e;">Batas Waktu Pembayaran</span>
                        </div>
                        <div id="countdown-timer" style="font-weight: 700; font-size: 1.125rem; color: #92400e; font-family: monospace;">
                            24:00:00
                        </div>
                    </div>

                    <!-- Route Information -->
                    <div style="margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                        <h3 style="font-weight: 600; color: #111827; margin-top: 0; margin-bottom: 0.5rem;">Rute Perjalanan</h3>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div>
                                <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Dari</p>
                                <p style="font-weight: 600; color: #111827; margin: 0;">{{ $booking->route->origin }}</p>
                            </div>
                            <div style="font-size: 1.5rem; color: #2563eb;">→</div>
                            <div>
                                <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Tujuan</p>
                                <p style="font-weight: 600; color: #111827; margin: 0;">{{ $booking->route->destination }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                        <div>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Kode Pemesanan</p>
                            <p style="font-weight: 600; color: #111827; margin: 0;">{{ $booking->booking_code }}</p>
                        </div>
                        <div>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Jumlah Kursi</p>
                            <p style="font-weight: 600; color: #111827; margin: 0;">{{ $booking->number_of_seats }} kursi</p>
                        </div>
                        <div>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Tanggal Perjalanan</p>
                            <p style="font-weight: 600; color: #111827; margin: 0;">{{ $booking->scheduled_date->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Waktu Keberangkatan</p>
                            <p style="font-weight: 600; color: #111827; margin: 0;">{{ $booking->departure_time }}</p>
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Status Pembayaran</p>
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                            @if($payment->status === 'success')
                                <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; background-color: #d1fae5; color: #065f46;">
                                    ✓ Success
                                </span>
                            @elseif($payment->status === 'pending')
                                <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; background-color: #d1fae5; color: #065f46;">
                                    ⏳ Pending
                                </span>
                            @else
                                <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; background-color: #fee2e2; color: #991b1b;">
                                    ✗ Failed
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div>
                <div style="background: #ffffff; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); padding: 1.5rem; position: sticky; top: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #111827; margin-top: 0; margin-bottom: 1.5rem;">Ringkasan Pembayaran</h3>

                    <div style="margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #6b7280;">Harga Tiket × {{ $booking->number_of_seats }}</span>
                            <span style="font-weight: 600;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <span style="font-size: 1.125rem; font-weight: 700; color: #111827;">Total</span>
                        <span style="font-size: 1.875rem; font-weight: 700; color: #2563eb;">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </span>
                    </div>

                    @if($payment->status === 'success')
                        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 0.5rem; padding: 1rem; text-align: center;">
                            <p style="color: #047857; font-weight: 600; margin: 0;">✓ Pembayaran Berhasil</p>
                            <a href="{{ route('bookings.travel.show', $booking) }}" 
                               style="color: #059669; font-weight: 600; font-size: 0.875rem; margin-top: 0.5rem; display: inline-block; text-decoration: none;">
                                Lihat Detail Pemesanan →
                            </a>
                        </div>
                    @else
                        <button onclick="triggerMidtransPayment()" 
                                style="width: 100%; background-color: #2563eb; color: #ffffff; font-weight: 700; padding: 0.75rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; font-size: 1rem; transition: background-color 0.2s;"
                                onmouseover="this.style.backgroundColor='#1d4ed8'" 
                                onmouseout="this.style.backgroundColor='#2563eb'">
                            Bayar Sekarang
                        </button>
                        
                        @if($payment->status === 'failed')
                            <button onclick="retryPayment()" 
                                    style="width: 100%; margin-top: 0.75rem; background-color: #e5e7eb; color: #111827; font-weight: 600; padding: 0.75rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; font-size: 1rem; transition: background-color 0.2s;"
                                    onmouseover="this.style.backgroundColor='#d1d5db'" 
                                    onmouseout="this.style.backgroundColor='#e5e7eb'">
                                Coba Lagi
                            </button>
                        @endif
                    @endif

                    <p style="font-size: 0.75rem; color: #6b7280; text-align: center; margin-top: 1rem; margin-bottom: 0;">
                        Pembayaran aman dengan Midtrans
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap Script -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>

<script>
    const snapToken = "{{ $snapToken ?? null }}";

    // Countdown Timer - 24 hours from payment creation
    @if($payment->status === 'pending' && $payment->created_at)
    (function() {
        // Set deadline to 24 hours after payment was created
        const deadline = new Date("{{ $payment->created_at->addHours(24)->toIso8601String() }}").getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = deadline - now;

            if (distance < 0) {
                document.getElementById('countdown-timer').innerHTML = '<span style="color: #991b1b;">EXPIRED</span>';
                return;
            }

            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('countdown-timer').innerHTML = 
                String(hours).padStart(2, '0') + ':' + 
                String(minutes).padStart(2, '0') + ':' + 
                String(seconds).padStart(2, '0');
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
                window.snapToken = data.snapToken;
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
