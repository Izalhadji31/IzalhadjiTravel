<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use App\Models\TravelBooking;
use App\Models\RentalBooking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RefundRejected;
use App\Notifications\RefundApproved;

class AdminRefundController extends Controller
{
    /**
     * List all refunds (admin)
     */
    public function index()
    {
        $refunds = Refund::with(['user', 'payment'])
            ->latest()
            ->paginate(20);

        return view('admin.refunds', compact('refunds'));
    }

    /**
     * Approve a refund
     */
    public function approve(Refund $refund)
    {
        if ($refund->status !== 'pending') {
            return back()->with('error', 'This refund has already been processed.');
        }

        $refund->approve();

        // Update payment status to refunded
        $payment = $refund->payment;
        if ($payment) {
            $payment->update(['status' => 'refunded']);
        }

        // Update booking status to refunded
        $booking = $refund->refundable;
        if ($booking) {
            $booking->update(['status' => 'refunded']);
        }

        // Notify user
        if ($refund->user) {
            // Notification::send($refund->user, new RefundApproved($refund));
        }

        return back()->with('success', 'Refund approved successfully.');
    }

    /**
     * Reject a refund
     */
    public function reject(Request $request, Refund $refund)
    {
        if ($refund->status !== 'pending') {
            return back()->with('error', 'This refund has already been processed.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $refund->reject($validated['rejection_reason']);

        // Notify user
        if ($refund->user) {
            // Notification::send($refund->user, new RefundRejected($refund));
        }

        return back()->with('success', 'Refund rejected. User has been notified.');
    }
}
