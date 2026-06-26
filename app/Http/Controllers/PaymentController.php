<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\RentalBooking;
use App\Models\TravelBooking;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Show payment page for travel booking
     */
    public function showTravelPayment(TravelBooking $travelBooking): View
    {
        $this->authorize('view', $travelBooking);

        // Check if payment already exists and is pending
        $existingPayment = $travelBooking->payments()->where('status', '!=', 'failed')->first();
        
        if ($existingPayment && $existingPayment->status !== 'success') {
            return view('payments.travel-checkout', [
                'booking' => $travelBooking,
                'payment' => $existingPayment,
            ]);
        }

        // Generate snap token
        $orderId = now()->format('YmdHis') . '-' . $travelBooking->id;
        $snapToken = $this->paymentService->createSnapToken($travelBooking, 'travel');
        
        // Record payment
        $payment = $this->paymentService->recordPayment($travelBooking, 'travel', $orderId, $snapToken);

        return view('payments.travel-checkout', [
            'booking' => $travelBooking,
            'payment' => $payment,
            'snapToken' => $snapToken,
            'clientKey' => config('midtrans.client_key'),
        ]);
    }

    /**
     * Show payment page for rental booking
     */
    public function showRentalPayment(RentalBooking $rentalBooking): View
    {
        $this->authorize('view', $rentalBooking);

        // Check if payment already exists and is pending
        $existingPayment = $rentalBooking->payments()->where('status', '!=', 'failed')->first();
        
        if ($existingPayment && $existingPayment->status !== 'success') {
            return view('payments.rental-checkout', [
                'booking' => $rentalBooking,
                'payment' => $existingPayment,
            ]);
        }

        // Generate snap token
        $orderId = now()->format('YmdHis') . '-' . $rentalBooking->id;
        $snapToken = $this->paymentService->createSnapToken($rentalBooking, 'rental');
        
        // Record payment
        $payment = $this->paymentService->recordPayment($rentalBooking, 'rental', $orderId, $snapToken);

        return view('payments.rental-checkout', [
            'booking' => $rentalBooking,
            'payment' => $payment,
            'snapToken' => $snapToken,
            'clientKey' => config('midtrans.client_key'),
        ]);
    }

    /**
     * Handle Midtrans notification callback
     */
    public function handleNotification(Request $request): JsonResponse
    {
        try {
            $notification = $request->all();
            $result = $this->paymentService->handleNotification($notification);
            
            return response()->json($result, $result['success'] ? 200 : 400);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Payment success page
     */
    public function paymentSuccess(Request $request): View
    {
        $orderId = $request->query('order_id');
        $statusCode = $request->query('status_code');
        $transactionStatus = $request->query('transaction_status');

        $payment = Payment::where('midtrans_reference', $orderId)->first();

        if (!$payment) {
            abort(404, 'Payment not found');
        }

        // Verify payment status with Midtrans
        $statusCheck = $this->paymentService->checkPaymentStatus($orderId);

        // Send WhatsApp notification on payment success
        if ($payment->status === 'success') {
            try {
                $notificationService = app(\App\Services\BookingNotificationService::class);
                $notificationService->notifyPaymentSuccess($payment);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Payment notification failed: ' . $e->getMessage());
            }
        }

        return view('payments.success', [
            'payment' => $payment,
            'booking' => $payment->booking,
            'orderId' => $orderId,
            'transactionStatus' => $transactionStatus,
        ]);
    }

    /**
     * Payment error page
     */
    public function paymentError(Request $request): View
    {
        $orderId = $request->query('order_id');
        $statusCode = $request->query('status_code');

        $payment = Payment::where('midtrans_reference', $orderId)->first();

        return view('payments.error', [
            'payment' => $payment,
            'orderId' => $orderId,
        ]);
    }

    /**
     * Payment pending page
     */
    public function paymentPending(Request $request): View
    {
        $orderId = $request->query('order_id');
        $statusCode = $request->query('status_code');

        $payment = Payment::where('midtrans_reference', $orderId)->first();

        if (!$payment) {
            abort(404, 'Payment not found');
        }

        return view('payments.pending', [
            'payment' => $payment,
            'booking' => $payment->booking,
            'orderId' => $orderId,
        ]);
    }

    /**
     * Check payment status (AJAX)
     */
    public function checkStatus(Payment $payment)
    {
        $status = $this->paymentService->checkPaymentStatus($payment->midtrans_reference);

        if ($status['success']) {
            $this->paymentService->handleNotification([
                'order_id' => $payment->midtrans_reference,
                'transaction_status' => $status['transaction_status'],
                'payment_type' => $status['payment_type'],
                'transaction_id' => $payment->midtrans_transaction_id,
            ]);

            return response()->json([
                'success' => true,
                'status' => $payment->fresh()->status,
            ]);
        }

        return response()->json($status, 400);
    }

    /**
     * Retry payment
     */
    public function retryPayment(Payment $payment)
    {
        if ($payment->status === 'success') {
            return response()->json(['error' => 'Payment already successful'], 400);
        }

        $booking = $payment->booking;
        $bookingType = class_basename($booking);

        // Generate new snap token
        $orderId = now()->format('YmdHis') . '-' . $booking->id . '-retry';
        $snapToken = $this->paymentService->createSnapToken($booking, strtolower($bookingType));

        $payment->update([
            'midtrans_reference' => $orderId,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'snapToken' => $snapToken,
            'orderId' => $orderId,
        ]);
    }
}
