<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PdfExportService
{
    /**
     * Generate invoice PDF
     */
    public function generateInvoice($booking, $payment)
    {
        $data = [
            'booking' => $booking,
            'payment' => $payment,
            'generated_at' => Carbon::now(),
            'company' => auth()->user()->company ?? null,
        ];

        return Pdf::loadView('exports.invoice', $data)
            ->setOption('enable-local-file-access', true)
            ->setPaper('a4')
            ->setOrientation('portrait')
            ->download('invoice-' . $booking->booking_code . '.pdf');
    }

    /**
     * Generate ticket PDF with QR code
     */
    public function generateTicket($booking)
    {
        $data = [
            'booking' => $booking,
            'qr_code' => $booking->qr_code_url ?? '',
            'generated_at' => Carbon::now(),
        ];

        return Pdf::loadView('exports.ticket', $data)
            ->setOption('enable-local-file-access', true)
            ->setPaper('a4')
            ->setOrientation('portrait')
            ->download('ticket-' . $booking->booking_code . '.pdf');
    }

    /**
     * Generate revenue report PDF
     */
    public function generateRevenueReport($startDate, $endDate)
    {
        $data = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'period' => $startDate->format('M Y') . ' - ' . $endDate->format('M Y'),
            'generated_at' => Carbon::now(),
        ];

        return Pdf::loadView('exports.revenue-report', $data)
            ->setOption('enable-local-file-access', true)
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->download('revenue-report-' . $startDate->format('Y-m-d') . '.pdf');
    }

    /**
     * Generate driver report PDF
     */
    public function generateDriverReport($startDate, $endDate)
    {
        $data = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'period' => $startDate->format('M Y') . ' - ' . $endDate->format('M Y'),
            'generated_at' => Carbon::now(),
        ];

        return Pdf::loadView('exports.driver-report', $data)
            ->setOption('enable-local-file-access', true)
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->download('driver-report-' . $startDate->format('Y-m-d') . '.pdf');
    }

    /**
     * Generate booking manifest PDF
     */
    public function generateManifest($travelBooking)
    {
        $data = [
            'booking' => $travelBooking,
            'passengers' => $travelBooking->passengers,
            'generated_at' => Carbon::now(),
        ];

        return Pdf::loadView('exports.manifest', $data)
            ->setOption('enable-local-file-access', true)
            ->setPaper('a4')
            ->setOrientation('portrait')
            ->download('manifest-' . $travelBooking->booking_code . '.pdf');
    }
}
