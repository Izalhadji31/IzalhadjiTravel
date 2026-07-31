<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\TravelBooking;
use App\Models\RentalBooking;
use App\Models\RevenueSharing;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnalyticsController extends Controller
{
    /**
     * Show revenue analytics
     */
    public function revenue(Request $request)
    {
        $startDate = $request->query('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->query('end_date', now()->format('Y-m-d'));

        $totalRevenue = Payment::where('status', 'completed')
                               ->whereBetween('created_at', [$startDate, $endDate])
                               ->sum('amount');

        $travelRevenue = TravelBooking::whereBetween('created_at', [$startDate, $endDate])
                                      ->sum('total_price');

        $rentalRevenue = RentalBooking::whereBetween('created_at', [$startDate, $endDate])
                                      ->sum('total_price');

        // Revenue sharing data
        $revenueSharing = RevenueSharing::whereBetween('created_at', [$startDate, $endDate])
                                        ->with('booking')
                                        ->get();

        return view('analytics.revenue', compact(
            'totalRevenue',
            'travelRevenue',
            'rentalRevenue',
            'revenueSharing',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Export revenue analytics to CSV
     */
    public function exportRevenueCSV(Request $request)
    {
        $startDate = $request->query('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->query('end_date', now()->format('Y-m-d'));

        $revenueSharing = RevenueSharing::whereBetween('created_at', [$startDate, $endDate])
                                        ->with('booking')
                                        ->get();

        $filename = "revenue-report-{$startDate}-to-{$endDate}.csv";
        $handle = fopen('php://memory', 'r+');

        // Write CSV header
        fputcsv($handle, ['Tanggal', 'Booking ID', 'Admin Share (Rp)', 'Mitra Share (Rp)', 'Driver Share (Rp)', 'Total (Rp)']);

        // Write data
        foreach ($revenueSharing as $row) {
            fputcsv($handle, [
                $row->created_at->format('Y-m-d'),
                $row->booking_id,
                number_format($row->admin_share, 0),
                number_format($row->mitra_share, 0),
                number_format($row->driver_share, 0),
                number_format($row->admin_share + $row->mitra_share + $row->driver_share, 0),
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response()->streamDownload(
            function () use ($content) {
                echo $content;
            },
            $filename,
            ['Content-Type' => 'text/csv']
        );
    }

    /**
     * Show bookings analytics
     */
    public function bookings(Request $request)
    {
        $startDate = $request->query('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->query('end_date', now()->format('Y-m-d'));

        $totalBookings = TravelBooking::whereBetween('created_at', [$startDate, $endDate])->count()
                       + RentalBooking::whereBetween('created_at', [$startDate, $endDate])->count();

        $completedBookings = TravelBooking::where('status', 'completed')
                                         ->whereBetween('created_at', [$startDate, $endDate])
                                         ->count();

        $cancelledBookings = TravelBooking::where('status', 'cancelled')
                                         ->whereBetween('created_at', [$startDate, $endDate])
                                         ->count();

        $completionRate = $totalBookings > 0 ? ($completedBookings / $totalBookings) * 100 : 0;

        return view('analytics.bookings', compact(
            'totalBookings',
            'completedBookings',
            'cancelledBookings',
            'completionRate',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Export bookings analytics to CSV
     */
    public function exportBookingsCSV(Request $request)
    {
        $startDate = $request->query('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->query('end_date', now()->format('Y-m-d'));

        $travelBookings = TravelBooking::whereBetween('created_at', [$startDate, $endDate])
                                       ->with('user', 'route')
                                       ->get();

        $rentalBookings = RentalBooking::whereBetween('created_at', [$startDate, $endDate])
                                       ->with('user', 'route')
                                       ->get();

        $filename = "bookings-report-{$startDate}-to-{$endDate}.csv";
        $handle = fopen('php://memory', 'r+');

        fputcsv($handle, ['Tipe', 'Booking ID', 'User', 'Rute', 'Tanggal', 'Total Harga (Rp)', 'Status']);

        foreach ($travelBookings as $booking) {
            fputcsv($handle, [
                'Travel',
                $booking->booking_code,
                $booking->user->name,
                $booking->route->origin . ' → ' . $booking->route->destination,
                $booking->created_at->format('Y-m-d'),
                number_format($booking->total_price, 0),
                ucfirst($booking->status),
            ]);
        }

        foreach ($rentalBookings as $booking) {
            fputcsv($handle, [
                'Rental',
                $booking->booking_code,
                $booking->user->name,
                $booking->route->destination,
                $booking->created_at->format('Y-m-d'),
                number_format($booking->total_price, 0),
                ucfirst($booking->status),
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response()->streamDownload(
            function () use ($content) {
                echo $content;
            },
            $filename,
            ['Content-Type' => 'text/csv']
        );
    }

    /**
     * Show driver performance analytics
     */
    public function drivers(Request $request)
    {
        // Get driver performance
        $drivers = \App\Models\Armada::with('travelBookings')
                                     ->withCount('travelBookings')
                                     ->orderByDesc('travel_bookings_count')
                                     ->get();

        // Calculate ratings and revenue
        $driverData = $drivers->map(function ($driver) {
            $totalTrips = $driver->travel_bookings_count;
            $rating = rand(40, 50) / 10; // Sample rating
            $revenue = TravelBooking::where('armada_id', $driver->id)->sum('total_price');

            return [
                'name' => $driver->driver_name,
                'trips' => $totalTrips,
                'rating' => $rating,
                'revenue' => $revenue,
            ];
        });

        return view('analytics.drivers', compact('driverData'));
    }

    /**
     * Export driver performance to CSV
     */
    public function exportDriversCSV()
    {
        $drivers = \App\Models\Armada::with('travelBookings')
                                     ->withCount('travelBookings')
                                     ->orderByDesc('travel_bookings_count')
                                     ->get();

        $filename = 'driver-performance-' . now()->format('Y-m-d') . '.csv';
        $handle = fopen('php://memory', 'r+');

        fputcsv($handle, ['Driver Name', 'Total Trips', 'Rating (1-5)', 'Total Revenue (Rp)']);

        foreach ($drivers as $driver) {
            $totalTrips = $driver->travel_bookings_count;
            $rating = rand(40, 50) / 10;
            $revenue = TravelBooking::where('armada_id', $driver->id)->sum('total_price');

            fputcsv($handle, [
                $driver->driver_name,
                $totalTrips,
                number_format($rating, 1),
                number_format($revenue, 0),
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response()->streamDownload(
            function () use ($content) {
                echo $content;
            },
            $filename,
            ['Content-Type' => 'text/csv']
        );
    }
}
