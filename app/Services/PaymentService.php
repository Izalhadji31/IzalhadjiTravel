<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\RentalBooking;
use App\Models\TravelBooking;
use App\Models\AirportTransferBooking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class PaymentService
{
    public function __construct()
    {
        // Configure Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Create Snap token for payment
     */
    public function createSnapToken($booking, string $bookingType, string $orderId): string
    {
        $transactionDetails = [
            'order_id'     => $orderId,
            'gross_amount' => (int) max(1, $booking->total_price ?? 0),
        ];

        $itemDetails     = $this->getItemDetails($booking, $bookingType);
        $customerDetails = $this->getCustomerDetails($booking);

        $payload = [
            'transaction_details' => $transactionDetails,
            'item_details'        => $itemDetails,
            'customer_details'    => $customerDetails,
            'callbacks'           => [
                'finish'  => route('payments.success'),
                'error'   => route('payments.error'),
                'pending' => route('payments.pending'),
            ],
            'expiry' => [
                'unit'   => 'hours',
                'length' => 24,
            ],
        ];

        try {
            return Snap::getSnapToken($payload);
        } catch (\Exception $e) {
            Log::error('Midtrans SnapToken creation error: ' . $e->getMessage());
            // Return dummy string if Midtrans keys not set or error occurs in local dev
            return 'dummy_snap_token_' . Str::random(20);
        }
    }

    /**
     * Generate order ID
     */
    public function generateOrderId(string $bookingId, string $bookingType): string
    {
        $prefix = match ($bookingType) {
            'travel'           => 'TRV',
            'rental'           => 'RNT',
            'airport_transfer' => 'ATB',
            default            => 'ORD'
        };
        $timestamp = now()->format('YmdHis');
        return "{$prefix}-{$bookingId}-{$timestamp}";
    }

    /**
     * Get item details for payment
     */
    private function getItemDetails($booking, string $bookingType): array
    {
        $items = [];

        if ($bookingType === 'travel') {
            $origin      = $booking->route?->origin ?? 'Ende';
            $destination = $booking->route?->destination ?? 'Tujuan';
            $items[] = [
                'id'            => "travel-{$booking->id}",
                'price'         => (int) max(1, $booking->total_price ?? 0),
                'quantity'      => 1,
                'name'          => "Travel - {$origin} ke {$destination}",
                'brand'         => 'ASR GO',
                'category'      => 'travel',
                'merchant_name' => 'ASR GO',
            ];
        } elseif ($bookingType === 'airport_transfer') {
            $items[] = [
                'id'            => "airport-{$booking->id}",
                'price'         => (int) max(1, $booking->total_price ?? 0),
                'quantity'      => 1,
                'name'          => "Airport Transfer ASR GO",
                'brand'         => 'ASR GO',
                'category'      => 'airport_transfer',
                'merchant_name' => 'ASR GO',
            ];
        } else {
            $vehicleName = $booking->armada?->vehicle_type ?? 'Mobil Rental';
            $items[] = [
                'id'            => "rental-{$booking->id}",
                'price'         => (int) max(1, $booking->total_price ?? 0),
                'quantity'      => 1,
                'name'          => "Rental - {$vehicleName}",
                'brand'         => 'ASR GO',
                'category'      => 'rental',
                'merchant_name' => 'ASR GO',
            ];
        }

        return $items;
    }

    /**
     * Get customer details
     */
    private function getCustomerDetails($booking): array
    {
        $user = $booking->user;

        return [
            'first_name'      => $user?->name ?? 'Pelanggan',
            'email'           => $user?->email ?? 'user@example.com',
            'phone'           => $user?->phone ?? '08123456789',
            'billing_address' => [
                'first_name'   => $user?->name ?? 'Pelanggan',
                'email'        => $user?->email ?? 'user@example.com',
                'phone'        => $user?->phone ?? '08123456789',
                'address'      => 'Indonesia',
                'city'         => 'Ende',
                'postal_code'  => '86300',
                'country_code' => 'ID',
            ],
        ];
    }

    /**
     * Record payment in database
     */
    public function recordPayment($booking, string $bookingType, string $orderId, string $snapToken): Payment
    {
        $bookingTypeFQCN = match ($bookingType) {
            'travel'           => TravelBooking::class,
            'rental'           => RentalBooking::class,
            'airport_transfer' => AirportTransferBooking::class,
            default            => $bookingType,
        };

        $payment = Payment::create([
            'user_id'            => $booking->user_id,
            'booking_id'         => $booking->id,
            'booking_type'       => $bookingTypeFQCN,
            'transaction_id'     => $orderId,
            'amount'             => $booking->total_price ?? 0,
            'payment_method'     => 'midtrans',
            'midtrans_reference' => $orderId,
            'status'             => 'pending',
        ]);

        cache()->put("midtrans_snap_{$orderId}", $snapToken, now()->addHours(24));

        return $payment;
    }

    /**
     * Handle Midtrans notification/callback
     */
    public function handleNotification(array $notification): array
    {
        $orderId           = $notification['order_id'] ?? null;
        $transactionStatus = $notification['transaction_status'] ?? 'pending';
        $transactionId     = $notification['transaction_id'] ?? null;

        $payment = Payment::where('midtrans_reference', $orderId)->first();

        if (!$payment) {
            return ['success' => false, 'message' => 'Payment not found'];
        }

        $status = $this->mapTransactionStatus($transactionStatus);
        $payment->update([
            'status'                  => $status,
            'midtrans_transaction_id' => $transactionId,
            'paid_at'                 => in_array($transactionStatus, ['settlement', 'capture']) ? now() : null,
        ]);

        if ($status === 'success') {
            $booking = $payment->booking;
            if ($booking) {
                $booking->update(['status' => 'confirmed']);

                if (array_key_exists('payment_status', $booking->getAttributes())) {
                    $booking->update(['payment_status' => 'paid']);
                }

                try {
                    $revenueService = app(RevenueShareService::class);
                    if ($payment->booking_type === TravelBooking::class) {
                        $revenueService->createTravelRevenueSharing($booking, $payment);
                    } elseif ($payment->booking_type === RentalBooking::class) {
                        $revenueService->createRentalRevenueSharing($booking, $payment);
                    }
                    // Airport transfer doesn't have revenue sharing for now
                } catch (\Exception $e) {
                    Log::error('Revenue sharing creation failed: ' . $e->getMessage());
                }
            }
        }

        return ['success' => true, 'message' => 'Payment status updated'];
    }

    public function isValidNotification(array $notification): bool
    {
        if (empty(config('midtrans.server_key'))) {
            return true;
        }

        $orderId     = $notification['order_id'] ?? '';
        $statusCode  = $notification['status_code'] ?? '';
        $grossAmount = $notification['gross_amount'] ?? '';
        $serverKey   = config('midtrans.server_key');
        $signature   = $notification['signature_key'] ?? '';

        $hashed = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        return $hashed === $signature;
    }

    public function checkPaymentStatus(string $orderId): array
    {
        try {
            $status = Transaction::status($orderId);
            return [
                'success'            => true,
                'transaction_status' => $status->transaction_status,
                'payment_type'       => $status->payment_type,
                'transaction_id'     => $status->transaction_id,
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function mapTransactionStatus(string $transactionStatus): string
    {
        return match ($transactionStatus) {
            'capture', 'settlement' => 'success',
            'pending'              => 'pending',
            'deny', 'expire', 'cancel' => 'failed',
            default                 => 'pending',
        };
    }
}
