<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class QrCodeService
{
    /**
     * Generate QR code for booking
     */
    public function generateBookingQrCode($booking)
    {
        // Create unique token for this booking
        $token = Str::random(32);
        $qrData = route('ticket.verify', ['token' => $token]);

        // Generate QR code
        $qrCode = QrCode::format('png')
            ->size(200)
            ->errorCorrection('H')
            ->generate($qrData);

        // Store QR code
        $filename = 'qrcodes/booking-' . $booking->id . '-' . time() . '.png';
        Storage::disk('public')->put($filename, $qrCode);

        // Save to database
        $booking->update([
            'qr_code_token' => $token,
            'qr_code_url' => asset('storage/' . $filename),
            'qr_code_path' => $filename,
        ]);

        return $booking->qr_code_url;
    }

    /**
     * Verify QR code token
     */
    public function verifyQrCode($token)
    {
        $booking = \App\Models\TravelBooking::where('qr_code_token', $token)
            ->where('qr_code_status', '!=', 'used')
            ->first();

        if (!$booking) {
            return null;
        }

        return $booking;
    }

    /**
     * Mark QR code as used
     */
    public function markAsUsed($booking)
    {
        $booking->update([
            'qr_code_status' => 'used',
            'qr_code_used_at' => now(),
        ]);

        return true;
    }

    /**
     * Generate batch QR codes
     */
    public function generateBatchQrCodes($bookings)
    {
        foreach ($bookings as $booking) {
            $this->generateBookingQrCode($booking);
        }

        return true;
    }

    /**
     * Generate mobile check-in QR code
     */
    public function generateCheckInQrCode($tripTracking)
    {
        $qrData = route('mobile.checkin', ['trip_id' => $tripTracking->id, 'pin' => $tripTracking->checkin_pin]);

        $qrCode = QrCode::format('png')
            ->size(200)
            ->generate($qrData);

        $filename = 'checkins/trip-' . $tripTracking->id . '.png';
        Storage::disk('public')->put($filename, $qrCode);

        $tripTracking->update(['checkin_qr_code' => asset('storage/' . $filename)]);

        return $tripTracking->checkin_qr_code;
    }
}
