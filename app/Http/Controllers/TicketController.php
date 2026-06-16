<?php

namespace App\Http\Controllers;

use App\Models\TravelBooking;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class TicketController extends Controller
{
    protected $qrService;

    public function __construct(QrCodeService $qrService)
    {
        $this->qrService = $qrService;
    }

    /**
     * Show ticket for booking
     */
    public function show(TravelBooking $booking): View
    {
        $this->authorize('view', $booking);

        // Generate QR code if not exists
        if (!$booking->qr_code_url) {
            $this->qrService->generateBookingQrCode($booking);
        }

        $booking->load(['route', 'passengers', 'payments']);

        return view('tickets.show', compact('booking'));
    }

    /**
     * Get QR code image
     */
    public function qrCode(TravelBooking $booking): Response
    {
        $this->authorize('view', $booking);

        // Generate if doesn't exist
        if (!$booking->qr_code_url) {
            $this->qrService->generateBookingQrCode($booking);
        }

        $qrCodePath = str_replace('storage/', 'storage/', $booking->qr_code_path);
        $filePath = storage_path('app/public/' . $booking->qr_code_path);

        if (!file_exists($filePath)) {
            return response('QR code not found', 404);
        }

        return response()->file($filePath);
    }

    /**
     * Verify ticket via QR code token
     */
    public function verify(Request $request)
    {
        $token = $request->get('token');

        $booking = $this->qrService->verifyQrCode($token);

        if (!$booking) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or used ticket',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'booking' => [
                'id' => $booking->id,
                'code' => $booking->booking_code,
                'passenger' => $booking->user->name,
                'route' => $booking->route->from_location->city . ' → ' . $booking->route->to_location->city,
                'seats' => $booking->number_of_seats,
                'date' => $booking->scheduled_date->format('d-m-Y'),
            ]
        ]);
    }

    /**
     * Check in passenger using QR code
     */
    public function checkin(Request $request, TravelBooking $booking)
    {
        $this->authorize('checkin', $booking);

        $validated = $request->validate([
            'pin' => 'required|string|size:4',
        ]);

        // Verify PIN (optional security layer)
        if ($booking->checkin_pin !== $validated['pin']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid PIN',
            ], 401);
        }

        // Mark QR code as used
        $this->qrService->markAsUsed($booking);

        // Update booking status
        $booking->update([
            'status' => 'confirmed',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Passenger checked in successfully',
            'booking' => [
                'id' => $booking->id,
                'code' => $booking->booking_code,
                'passenger' => $booking->user->name,
                'status' => 'checked-in',
            ]
        ]);
    }

    /**
     * Download ticket as PDF
     */
    public function downloadPdf(TravelBooking $booking)
    {
        $this->authorize('view', $booking);

        // Generate QR if not exists
        if (!$booking->qr_code_url) {
            $this->qrService->generateBookingQrCode($booking);
        }

        $booking->load(['route', 'passengers', 'payments']);

        // Use PdfExportService
        $pdfService = app(\App\Services\PdfExportService::class);
        return $pdfService->generateTicket($booking);
    }
}
