<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use App\Models\TravelBooking;
use App\Models\RentalBooking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundController extends Controller
{
    /**
     * Tampilkan daftar permintaan pengembalian dana milik user.
     */
    public function index()
    {
        $user = Auth::user();
        $refunds = Refund::with(['user', 'payment'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        return view('refunds.index', compact('refunds'));
    }

    /**
     * Tampilkan formulir pengembalian dana untuk pemesanan.
     */
    public function create($booking)
    {
        $user = Auth::user();

        $bookingModel = TravelBooking::with(['user', 'payments'])
            ->where('id', $booking)
            ->where('user_id', $user->id)
            ->first();

        $bookingType = 'travel';

        if (!$bookingModel) {
            $bookingModel = RentalBooking::with(['user', 'payments'])
                ->where('id', $booking)
                ->where('user_id', $user->id)
                ->first();
            $bookingType = 'rental';
        }

        if (!$bookingModel) {
            abort(404, 'Booking not found');
        }

        // Pastikan pembayaran berhasil tersedia.
        $payment = $bookingModel->payments()->where('status', 'success')->latest()->first();

        if (!$payment) {
            return back()->with('error', 'Tidak ada pembayaran selesai untuk pemesanan ini.');
        }

        // Cegah pengajuan pengembalian dana ganda.
        $existingRefund = Refund::where('refundable_id', $bookingModel->id)
            ->where('refundable_type', $bookingType === 'travel' ? TravelBooking::class : RentalBooking::class)
            ->where('user_id', $user->id)
            ->first();

        if ($existingRefund) {
            return back()->with('error', 'Pengembalian dana untuk pemesanan ini sudah pernah diajukan.');
        }

        return view('refunds.create', compact('bookingModel', 'bookingType', 'payment'));
    }

    /**
     * Simpan permintaan pengembalian dana.
     */
    public function store(Request $request, $booking)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'reason' => 'required|string|max:2000',
        ]);

        $bookingModel = TravelBooking::with(['user', 'payments'])
            ->where('id', $booking)
            ->where('user_id', $user->id)
            ->first();

        $bookingType = 'travel';

        if (!$bookingModel) {
            $bookingModel = RentalBooking::with(['user', 'payments'])
                ->where('id', $booking)
                ->where('user_id', $user->id)
                ->first();
            $bookingType = 'rental';
        }

        if (!$bookingModel) {
            abort(404, 'Booking not found');
        }

        $payment = $bookingModel->payments()->where('status', 'success')->latest()->first();

        if (!$payment) {
            return back()->with('error', 'Tidak ada pembayaran selesai untuk pemesanan ini.');
        }

        Refund::create([
            'user_id' => $user->id,
            'payment_id' => $payment->id,
            'type' => $bookingType,
            'refundable_id' => $bookingModel->id,
            'refundable_type' => $bookingType === 'travel' ? TravelBooking::class : RentalBooking::class,
            'amount' => $payment->amount,
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return redirect()->route('refunds.index')
            ->with('success', 'Permintaan pengembalian dana berhasil diajukan.');
    }

    /**
     * Tampilkan status pengembalian dana.
     */
    public function show($booking)
    {
        $user = Auth::user();

        $refund = Refund::with(['user', 'payment'])
            ->where('refundable_id', $booking)
            ->where('user_id', $user->id)
            ->first();

        if (!$refund) {
            abort(404, 'Refund not found');
        }

        return view('refunds.show', compact('refund'));
    }
}
