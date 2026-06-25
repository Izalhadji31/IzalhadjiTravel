<?php

namespace App\Services;

use App\Models\Payment;
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
    public function createSnapToken($booking, string $bookingType): string
    {
        $transactionDetails = [
            'order_id' => $this->generateOrderId($booking->id, $bookingType),
            'gross_amount' => (int) $booking->total_price,
        ];

        $itemDetails = $this->getItemDetails($booking, $bookingType);

        $customerDetails = $this->getCustomerDetails($booking);

        $payload = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
            'enabled_payments' => $this->getEnabledPaymentMethods(),
            'callbacks' => [
                'finish' => config('midtrans.finish_redirect_url'),
                'error' => config('midtrans.error_redirect_url'),
                'pending' => config('midtrans.unfinish_redirect_url'),
            ],
            'expiry' => [
                'unit' => 'hours',
                'length' => 24,
            ],
        ];

        $snapToken = Snap::getSnapToken($payload);
        return $snapToken;
    }

    /**
     * Generate order ID
     */
    private function generateOrderId(int $bookingId, string $bookingType): string
    {
        $prefix = $bookingType === 'travel' ? 'TRV' : 'RNT';
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
            $items[] = [
                'id' => "travel-{$booking->id}",
                'price' => (int) $booking->total_price,
                'quantity' => 1,
                'name' => "Travel Booking - {$booking->route->origin} to {$booking->route->destination}",
                'brand' => 'ASR GO',
                'category' => 'travel',
                'merchant_name' => 'ASR GO',
            ];
        } else {
            $items[] = [
                'id' => "rental-{$booking->id}",
                'price' => (int) $booking->total_price,
                'quantity' => 1,
                'name' => "Rental Booking - {$booking->armada->vehicle_name}",
                'brand' => 'ASR GO',
                'category' => 'rental',
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
            'first_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '',
            'billing_address' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
                'address' => 'Indonesia',
                'city' => 'Ende',
                'postal_code' => '86300',
                'country_code' => 'ID',
            ],
        ];
    }

    /**
     * Get enabled payment methods
     */
    private function getEnabledPaymentMethods(): array
    {
        $methods = [
            'bank_transfer',
            'echannel',
            'permata',
            'bca_klikbca',
            'bca_clickpay',
            'cimb_clicks',
            'bni_eshop',
            'bri_epay',
            'gopay',
        ];

        if (config('midtrans.enable_pay_later')) {
            $methods[] = 'buy_now_pay_later';
        }

        if (config('midtrans.enable_installment')) {
            $methods[] = 'credit_card';
        }

        return $methods;
    }

    /**
     * Record payment in database
     */
    public function recordPayment($booking, string $bookingType, string $orderId, string $snapToken): Payment
    {
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'booking_type' => $bookingType,
            'amount' => $booking->total_price,
            'payment_method' => 'midtrans',
            'midtrans_reference' => $orderId,
            'status' => 'pending',
        ]);

        // Store snap token in session or cache for later use
        cache()->put("midtrans_snap_{$orderId}", $snapToken, now()->addHours(24));

        return $payment;
    }

    /**
     * Handle Midtrans notification/callback
     */
    public function handleNotification(array $notification): array
    {
        $orderId = $notification['order_id'];
        $transactionStatus = $notification['transaction_status'];
        $paymentType = $notification['payment_type'];
        $transactionId = $notification['transaction_id'];

        // Find payment by order ID
        $payment = Payment::where('midtrans_reference', $orderId)->first();

        if (!$payment) {
            return ['success' => false, 'message' => 'Payment not found'];
        }

        // Update payment status based on transaction status
        $status = $this->mapTransactionStatus($transactionStatus);
        $payment->update([
            'status' => $status,
            'midtrans_transaction_id' => $transactionId,
            'paid_at' => in_array($transactionStatus, ['settlement', 'capture']) ? now() : null,
        ]);

        // Update booking status if payment is successful
        if ($status === 'success') {
            $booking = $payment->booking;
            $booking->update(['status' => 'confirmed']);

            // Auto-create revenue sharing
            try {
                $revenueService = app(RevenueShareService::class);
                if ($payment->booking_type === 'App\\Models\\TravelBooking') {
                    $revenueService->createTravelRevenueSharing($booking, $payment);
                } elseif ($payment->booking_type === 'App\\Models\\RentalBooking') {
                    $revenueService->createRentalRevenueSharing($booking, $payment);
                }
            } catch (\Exception $e) {
                // Log error but don't fail payment
                \Log::error('Revenue sharing creation failed: ' . $e->getMessage());
            }
        }

        return ['success' => true, 'message' => 'Payment status updated'];
    }

    /**
     * Map Midtrans transaction status to payment status
     */
    private function mapTransactionStatus(string $transactionStatus): string
    {
        return match ($transactionStatus) {
            'capture', 'settlement' => 'success',
            'pending' => 'pending',
            'deny', 'cancel', 'expire' => 'failed',
            'refund' => 'refunded',
            default => 'unknown',
        };
    }

    /**
     * Check payment status from Midtrans
     */
    public function checkPaymentStatus(string $orderId): array
    {
        try {
            $status = Transaction::status($orderId);
            // Midtrans returns array or stdClass
            $transactionStatus = is_array($status) ? $status['transaction_status'] : $status->transaction_status;
            $paymentType = is_array($status) ? ($status['payment_type'] ?? 'unknown') : ($status->payment_type ?? 'unknown');
            
            return [
                'success' => true,
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Process refund
     */
    public function processRefund(Payment $payment, ?float $refundAmount = null): array
    {
        try {
            $params = [];
            
            if ($refundAmount) {
                $params['refund_amount'] = (int)($refundAmount * 100);
                Transaction::refund($payment->midtrans_transaction_id, $params);
            } else {
                Transaction::refund($payment->midtrans_transaction_id, []);
            }

            $payment->update(['status' => 'refunded']);

            return ['success' => true, 'message' => 'Refund processed successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
