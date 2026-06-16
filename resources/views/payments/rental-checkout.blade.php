<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pembayaran - ASR GO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('bookings.rental') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                    ← Kembali ke Pemesanan
                </a>
                <h1 class="text-4xl font-bold text-gray-900 mt-4">Pembayaran Rental</h1>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Booking Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Detail Pemesanan</h2>

                        <!-- Vehicle Information -->
                        <div class="mb-6 pb-6 border-b">
                            <h3 class="font-semibold text-gray-900 mb-2">Kendaraan</h3>
                            <p class="text-lg font-semibold text-gray-900">{{ $booking->armada->vehicle_name }}</p>
                            <p class="text-sm text-gray-600">{{ $booking->armada->license_plate }}</p>
                        </div>

                        <!-- Booking Details -->
                        <div class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b">
                            <div>
                                <p class="text-sm text-gray-600">Kode Pemesanan</p>
                                <p class="font-semibold text-gray-900">{{ $booking->booking_code }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Durasi</p>
                                <p class="font-semibold text-gray-900">{{ $booking->number_of_days }} hari</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tanggal Mulai</p>
                                <p class="font-semibold text-gray-900">{{ $booking->start_date->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tanggal Kembali</p>
                                <p class="font-semibold text-gray-900">{{ $booking->end_date->format('d M Y') }}</p>
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <p class="text-sm text-gray-600">Status Pembayaran</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold 
                                    @if($payment->status === 'success')
                                        bg-green-100 text-green-800
                                    @elseif($payment->status === 'pending')
                                        bg-yellow-100 text-yellow-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div>
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Pembayaran</h3>

                        <div class="space-y-4 mb-6 pb-6 border-b">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tarif Harian × {{ $booking->number_of_days }}</span>
                                <span class="font-semibold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-3xl font-bold text-blue-600">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </span>
                        </div>

                        @if($payment->status === 'success')
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                                <p class="text-green-700 font-semibold">✓ Pembayaran Berhasil</p>
                                <a href="{{ route('bookings.rental.show', $booking) }}" 
                                   class="text-green-600 hover:text-green-700 text-sm font-semibold mt-2 block">
                                    Lihat Detail Pemesanan →
                                </a>
                            </div>
                        @else
                            <button onclick="triggerMidtransPayment()" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">
                                Bayar Sekarang
                            </button>
                            
                            @if($payment->status === 'failed')
                                <button onclick="retryPayment()" 
                                        class="w-full mt-3 bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold py-3 px-4 rounded-lg transition-colors">
                                    Coba Lagi
                                </button>
                            @endif
                        @endif

                        <p class="text-xs text-gray-500 text-center mt-4">
                            Pembayaran aman dengan Midtrans
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const snapToken = "{{ $snapToken ?? null }}";

        function triggerMidtransPayment() {
            if (!snapToken) {
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
</body>
</html>
