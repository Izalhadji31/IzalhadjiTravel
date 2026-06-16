<?php

namespace App\Http\Controllers;

use App\Exports\BookingExport;
use App\Exports\RevenueExport;
use App\Exports\DriverExport;
use App\Services\PdfExportService;
use App\Models\TravelBooking;
use App\Models\RentalBooking;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ExportController extends Controller
{
    protected $pdfService;

    public function __construct(PdfExportService $pdfService)
    {
        $this->pdfService = $pdfService;
        $this->middleware('auth');
    }

    /**
     * Export bookings to Excel
     */
    public function bookingsExcel(Request $request)
    {
        $startDate = $request->get('start_date') ? Carbon::createFromFormat('Y-m-d', $request->get('start_date')) : null;
        $endDate = $request->get('end_date') ? Carbon::createFromFormat('Y-m-d', $request->get('end_date')) : null;

        return Excel::download(
            new BookingExport($startDate, $endDate),
            'bookings-' . Carbon::now()->format('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Export bookings to PDF
     */
    public function bookingsPdf(Request $request)
    {
        $startDate = $request->get('start_date') ? Carbon::createFromFormat('Y-m-d', $request->get('start_date')) : null;
        $endDate = $request->get('end_date') ? Carbon::createFromFormat('Y-m-d', $request->get('end_date')) : null;

        return Excel::download(
            new BookingExport($startDate, $endDate),
            'bookings-' . Carbon::now()->format('Y-m-d') . '.pdf'
        );
    }

    /**
     * Export revenue to Excel
     */
    public function revenueExcel(Request $request)
    {
        $startDate = $request->get('start_date') ? Carbon::createFromFormat('Y-m-d', $request->get('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->get('end_date') ? Carbon::createFromFormat('Y-m-d', $request->get('end_date')) : Carbon::now()->endOfMonth();

        return Excel::download(
            new RevenueExport($startDate, $endDate),
            'revenue-' . $startDate->format('Y-m') . '.xlsx'
        );
    }

    /**
     * Export revenue to PDF
     */
    public function revenuePdf(Request $request)
    {
        $startDate = $request->get('start_date') ? Carbon::createFromFormat('Y-m-d', $request->get('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->get('end_date') ? Carbon::createFromFormat('Y-m-d', $request->get('end_date')) : Carbon::now()->endOfMonth();

        return $this->pdfService->generateRevenueReport($startDate, $endDate);
    }

    /**
     * Export drivers to Excel
     */
    public function driversExcel()
    {
        $companyId = auth()->user()->company_id;

        return Excel::download(
            new DriverExport($companyId),
            'drivers-' . Carbon::now()->format('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Export drivers to PDF
     */
    public function driversPdf()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        return $this->pdfService->generateDriverReport($startDate, $endDate);
    }

    /**
     * Download invoice PDF
     */
    public function invoicePdf($bookingId)
    {
        $booking = TravelBooking::findOrFail($bookingId);
        $this->authorize('view', $booking);

        $payment = $booking->payments()->latest()->first();

        if (!$payment) {
            return back()->with('error', 'No payment found for this booking');
        }

        return $this->pdfService->generateInvoice($booking, $payment);
    }

    /**
     * Download ticket PDF with QR code
     */
    public function ticketPdf($bookingId)
    {
        $booking = TravelBooking::findOrFail($bookingId);
        $this->authorize('view', $booking);

        return $this->pdfService->generateTicket($booking);
    }

    /**
     * Download manifest PDF
     */
    public function manifestPdf($bookingId)
    {
        $booking = TravelBooking::findOrFail($bookingId);

        if (auth()->user()->id !== $booking->user_id) {
            $this->authorize('viewAny', TravelBooking::class);
        }

        return $this->pdfService->generateManifest($booking);
    }
}
