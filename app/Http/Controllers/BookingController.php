<?php

namespace App\Http\Controllers;

use App\Models\TravelBooking;
use App\Models\RentalBooking;
use App\Models\AirportTransferBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display all bookings for the current user (unified view)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status', 'all');

        // Get travel bookings
        $travelBookings = TravelBooking::where('user_id', $user->id)
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->get()
            ->map(fn($b) => (object) [
                'id' => $b->id,
                'type' => 'travel',
                'type_label' => 'Travel',
                'booking_code' => $b->booking_code,
                'status' => $b->status,
                'total_price' => $b->total_price,
                'date' => $b->scheduled_date,
                'detail' => $b->route ? ($b->route->origin_city . ' → ' . $b->route->destination_city) : '-',
                'show_route' => route('bookings.show', $b->id),
            ]);

        // Get rental bookings
        $rentalBookings = RentalBooking::where('user_id', $user->id)
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->get()
            ->map(fn($b) => (object) [
                'id' => $b->id,
                'type' => 'rental',
                'type_label' => 'Rental',
                'booking_code' => $b->booking_code,
                'status' => $b->status,
                'total_price' => $b->total_price,
                'date' => $b->start_date,
                'detail' => $b->route ? ($b->route->origin_city . ' → ' . $b->route->destination_city) : '-',
                'show_route' => route('bookings.show', $b->id),
            ]);

        // Get airport transfer bookings
        $airportBookings = AirportTransferBooking::where('user_id', $user->id)
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->get()
            ->map(fn($b) => (object) [
                'id' => $b->id,
                'type' => 'airport_transfer',
                'type_label' => 'Airport Transfer',
                'booking_code' => $b->booking_code,
                'status' => $b->status,
                'total_price' => $b->total_price,
                'date' => $b->scheduled_date,
                'detail' => ($b->pickup_location ?? '-') . ' → ' . ($b->dropoff_location ?? '-'),
                'show_route' => route('bookings.show', $b->id),
            ]);

        // Merge and sort
        $allBookings = $travelBookings->merge($rentalBookings)->merge($airportBookings);

        if ($status === 'all') {
            $allBookings = $allBookings->sortByDesc('date');
        }

        // Manual pagination
        $perPage = 10;
        $page = $request->get('page', 1);
        $total = $allBookings->count();
        $bookings = $allBookings->forPage($page, $perPage)->values();

        $pagination = new \Illuminate\Pagination\LengthAwarePaginator(
            $bookings,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('bookings.index', compact('bookings', 'pagination', 'status'));
    }

    /**
     * Universal booking show — detect type and render the correct detail view.
     */
    public function show(Request $request, $id)
    {
        $user = Auth::user();

        $travel = TravelBooking::where('id', $id)->where('user_id', $user->id)->first();
        if ($travel) {
            $this->authorize('view', $travel);
            $travel->load(['user', 'route', 'armada']);

            return view('bookings.travel-show', ['booking' => $travel]);
        }

        $rental = RentalBooking::where('id', $id)->where('user_id', $user->id)->first();
        if ($rental) {
            $this->authorize('view', $rental);
            $rental->load(['user', 'route', 'armada']);

            return view('bookings.rental-show', ['booking' => $rental]);
        }

        $airport = AirportTransferBooking::where('id', $id)->where('user_id', $user->id)->first();
        if ($airport) {
            $airport->load(['user']);

            return view('bookings.airport-transfer-show', ['booking' => $airport]);
        }

        abort(404, 'Booking not found');
    }
}
