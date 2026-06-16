<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RentalPrice;
use App\Models\TravelPrice;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PublicController extends Controller
{
    /**
     * Show public landing page
     */
    public function home()
    {
        $travelRoutes = Schema::hasTable('routes')
            ? Route::active()->travel()->with('travelPrices')->take(6)->get()
            : collect();
        $rentalServices = Schema::hasTable('rental_prices')
            ? RentalPrice::active()->with('route')->take(6)->get()
            : collect();

        return view('public.home', compact('travelRoutes', 'rentalServices'));
    }

    /**
     * Show all travel routes publicly
     */
    public function travelList(Request $request)
    {
        $query = Route::active()->travel()->with(['travelPrices']);

        // Filter by origin
        if ($request->filled('origin')) {
            $query->where('origin_city', $request->origin);
        }

        // Filter by destination
        if ($request->filled('destination')) {
            $query->where('destination_city', $request->destination);
        }

        // Filter by price range
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $query->whereHas('travelPrices', function ($q) use ($request) {
                $q->whereBetween('price', [$request->price_min, $request->price_max]);
            });
        }

        // Sort
        $sortBy = $request->get('sort', 'destination_city');
        if (in_array($sortBy, ['destination_city', 'distance_km', 'created_at'])) {
            $query->orderBy($sortBy, $request->get('order', 'asc'));
        }

        $routes = $query->paginate(12);
        $origins = Route::active()->travel()->distinct()->pluck('origin_city');
        $destinations = Route::active()->travel()->distinct()->pluck('destination_city');

        return view('public.travel', compact('routes', 'origins', 'destinations'));
    }

    /**
     * Show all rental services publicly
     */
    public function rentalList(Request $request)
    {
        $query = RentalPrice::active()->with('route');

        // Filter by destination
        if ($request->filled('destination')) {
            $query->whereHas('route', function ($q) use ($request) {
                $q->where('destination_city', $request->destination);
            });
        }

        // Filter by price range
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $query->whereBetween('price_without_driver', [$request->price_min, $request->price_max]);
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        if (in_array($sortBy, ['price_without_driver', 'created_at'])) {
            $query->orderBy($sortBy, $request->get('order', 'asc'));
        }

        $rentals = $query->paginate(12);
        $destinations = Route::active()->rental()->distinct()->pluck('destination_city')->filter();

        $vehicleTypes = \App\Models\Armada::available()->distinct()->pluck('vehicle_type')->filter();

        return view('public.rental', compact('rentals', 'destinations', 'vehicleTypes'));
    }

    /**
     * Show price calculator
     */
    public function priceCalculator()
    {
        $routes = Route::active()->get();

        return view('public.price-calculator', compact('routes'));
    }

    /**
     * Calculate price via AJAX
     */
    public function calculatePrice(Request $request)
    {
        $validated = $request->validate([
            'service' => 'required|in:travel,rental',
            'route_id' => 'nullable|exists:routes,id',
            'destination' => 'nullable|string',
            'vehicle_type' => 'nullable|string',
            'with_driver' => 'nullable|boolean',
            'days' => 'nullable|integer|min:1',
        ]);

        $price = 0;

        if ($validated['service'] === 'travel' && $validated['route_id']) {
            $travelPrice = TravelPrice::where('route_id', $validated['route_id'])->first();
            if ($travelPrice) {
                $price = $travelPrice->price_per_seat;
            }
        } elseif ($validated['service'] === 'rental' && $validated['destination']) {
            $rentalPrice = RentalPrice::whereHas('route', fn($q) => $q->where('destination_city', $validated['destination']))
                ->first();

            if ($rentalPrice) {
                $withDriver = $validated['with_driver'] ?? false;
                $days = $validated['days'] ?? 1;
                $dailyPrice = $withDriver ? $rentalPrice->price_with_driver : $rentalPrice->price_without_driver;
                $price = $dailyPrice * $days;
            }
        }

        return response()->json([
            'success' => true,
            'price' => $price,
            'formatted_price' => 'Rp ' . number_format($price, 0, ',', '.'),
        ]);
    }

    /**
     * Show about page
     */
    public function about()
    {
        return view('public.about');
    }

    /**
     * Show contact page
     */
    public function contact()
    {
        return view('public.contact');
    }

    /**
     * Handle contact form submission
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Save to database or send email
        // For now, just redirect
        return redirect()
            ->route('public.contact')
            ->with('success', 'Terima kasih! Pesan Anda telah dikirim. Kami akan menghubungi Anda segera.');
    }

    /**
     * Show all available vehicles for rental
     */
    public function vehiclesList(Request $request)
    {
        $query = \App\Models\Armada::available()->with('mitra');

        // Filter by vehicle type
        if ($request->filled('vehicle_type')) {
            $query->where('vehicle_type', $request->vehicle_type);
        }

        // Filter by seat capacity
        if ($request->filled('min_capacity')) {
            $query->where('seat_capacity', '>=', $request->min_capacity);
        }

        // Sort
        $sortBy = $request->get('sort', 'vehicle_type');
        if (in_array($sortBy, ['vehicle_type', 'seat_capacity', 'created_at'])) {
            $query->orderBy($sortBy, $request->get('order', 'asc'));
        }

        $vehicles = $query->paginate(12);
        $vehicleTypes = \App\Models\Armada::available()->distinct()->pluck('vehicle_type');

        return view('public.vehicles', compact('vehicles', 'vehicleTypes'));
    }
}
