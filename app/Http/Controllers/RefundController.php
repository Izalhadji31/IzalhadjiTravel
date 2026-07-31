<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use App\Models\TravelBooking;
use App\Models\RentalBooking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RefundController extends Controller
{
    /**
     * Tarif PPN yang dikenakan untuk pembatalan terlambat (< 24 jam sebelum keberangkatan).
     */
    const PPN_RATE = 0.11;

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

        // Hitung waktu keberangkatan & kebijakan refund
        $refundInfo = $this->calculateRefundPolicy($bookingModel, $bookingType, $payment->amount);

        return view('refunds.create', array_merge(
            compact('bookingModel', 'bookingType', 'payment'),
            $refundInfo
        ));
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

        // Cegah pengajuan refund ganda
        $existingRefund = Refund::where('refundable_id', $bookingModel->id)
            ->where('refundable_type', $bookingType === 'travel' ? TravelBooking::class : RentalBooking::class)
            ->where('user_id', $user->id)
            ->first();

        if ($existingRefund) {
            return back()->with('error', 'Pengembalian dana untuk pemesanan ini sudah pernah diajukan.');
        }

        // Hitung jumlah refund dengan kebijakan PPN
        $refundInfo = $this->calculateRefundPolicy($bookingModel, $bookingType, $payment->amount);

        Refund::create([
            'user_id'         => $user->id,
            'payment_id'      => $payment->id,
            'type'            => $bookingType,
            'refundable_id'   => $bookingModel->id,
            'refundable_type' => $bookingType === 'travel' ? TravelBooking::class : RentalBooking::class,
            'amount'          => $refundInfo['refundAmount'],
            'reason'          => $validated['reason'],
            'status'          => 'pending',
        ]);

        // Set booking ke cancelled setelah request refund diajukan
        $bookingModel->update(['status' => 'cancelled']);

        return redirect()->route('refunds.index')
            ->with('success', 'Permintaan pembatalan dan pengembalian dana berhasil diajukan. Tim kami akan memproses dalam 3-5 hari kerja.');
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

    /**
     * Hitung kebijakan refund berdasarkan waktu keberangkatan.
     * 
     * Aturan:
     * - Jika pembatalan dilakukan >= 24 jam sebelum keberangkatan: refund penuh (100%)
     * - Jika pembatalan dilakukan < 24 jam sebelum keberangkatan: refund dikurangi PPN 11%
     * 
     * @return array [hoursUntilDeparture, ppnRate, ppnAmount, refundAmount, isLateCancel]
     */
    private function calculateRefundPolicy($bookingModel, string $bookingType, float $originalAmount): array
    {
        // Tentukan tanggal/waktu keberangkatan
        if ($bookingType === 'travel') {
            // TravelBooking: scheduled_date + departure_time
            $departureDate = $bookingModel->scheduled_date
                ? Carbon::parse($bookingModel->scheduled_date)
                : null;
        } else {
            // RentalBooking: start_date + start_time
            $departureDate = $bookingModel->start_date
                ? Carbon::parse($bookingModel->start_date)
                : null;
        }

        if ($departureDate) {
            // Hitung jam yang tersisa hingga keberangkatan (negatif jika sudah lewat)
            $hoursUntilDeparture = Carbon::now()->diffInHours($departureDate, false);
        } else {
            // Jika tanggal tidak tersedia, anggap masih dalam window 24 jam (aman)
            $hoursUntilDeparture = 25;
        }

        // Pembatalan terlambat jika < 24 jam sebelum keberangkatan (termasuk sudah lewat)
        $isLateCancel = $hoursUntilDeparture < 24;

        $ppnRate   = $isLateCancel ? self::PPN_RATE : 0;
        $ppnAmount = round($originalAmount * $ppnRate, 2);
        $refundAmount = $originalAmount - $ppnAmount;

        return [
            'hoursUntilDeparture' => $hoursUntilDeparture,
            'ppnRate'             => $ppnRate,
            'ppnAmount'           => $ppnAmount,
            'refundAmount'        => $refundAmount,
            'isLateCancel'        => $isLateCancel,
        ];
    }
}
