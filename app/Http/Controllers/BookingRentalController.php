<?php

namespace App\Http\Controllers;

use App\Models\RentalBooking;
use App\Models\Route;
use App\Models\RentalPrice;
use App\Models\VehicleType;
use App\Models\Armada;
use App\Models\Voucher;
use App\Models\Addon;
use App\Models\AddonCategory;
use App\Models\RentalBookingAddon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingRentalController extends Controller
{
    /**
     * Display rental bookings
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $bookings = RentalBooking::query();

        if ($user->role !== 'admin') {
            $bookings->where('user_id', $user->id);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $bookings->where('status', $request->status);
        }

        $bookings = $bookings->with(['user', 'route', 'armada', 'vehicleType'])
                             ->latest()
                             ->paginate(10);

        return view('bookings.rental', compact('bookings'));
    }

    /**
     * Show search form (Traveloka-style)
     */
    public function search()
    {
        $vehicleTypes = VehicleType::active()->sorted()->get();
        $cities = Route::select('origin_city')->distinct()->pluck('origin_city');

        return view('bookings.rental-search', compact('vehicleTypes', 'cities'));
    }

    /**
     * Search available vehicles
     */
    public function searchResults(Request $request)
    {
        $validated = $request->validate([
            'pickup_city' => 'required|string',
            'dropoff_city' => 'required|string',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'vehicle_type_id' => 'nullable|exists:vehicle_types,id',
            'rental_type' => 'required|in:with_driver,without_driver',
        ]);

        // Check same-day booking restriction (minimum 12 hours)
        $pickupDatetime = \Carbon\Carbon::parse($validated['start_date'] . ' ' . $validated['start_time']);
        if ($pickupDatetime->diffInHours(now()) < 12) {
            return back()->with('error', 'Same-day booking must be at least 12 hours in advance');
        }

        // Get base price from route or use default
        $route = Route::where('origin_city', $validated['pickup_city'])
                      ->where('destination_city', $validated['dropoff_city'])
                      ->first();

        $basePrice = $route ? $route->rentalPrices?->first()?->price_without_driver : 500000;

        // Calculate duration
        $start = \Carbon\Carbon::parse($validated['start_date'] . ' ' . $validated['start_time']);
        $end = \Carbon\Carbon::parse($validated['end_date'] . ' ' . $validated['end_time']);
        $days = ceil($start->diffInHours($end) / 24);

        // Calculate addon prices
        $addonTotal = 0;
        $addonItems = [];
        if (isset($validated['addons'])) {
            foreach ($validated['addons'] as $addonData) {
                $addon = Addon::find($addonData['addon_id']);
                if ($addon) {
                    $price = $addon->calculatePrice($days);
                    $addonTotal += $price * $addonData['quantity'];
                    $addonItems[] = [
                        'addon_id' => $addon->id,
                        'quantity' => $addonData['quantity'],
                        'price_at_booking' => $price,
                    ];
                }
            }
        }

        // Recalculate total price with addons
        $baseTotalPrice = $validated['total_price'];
        $finalTotalPrice = $baseTotalPrice + $addonTotal;

        // Get vehicle type
        $vehicleType = null;
        if (isset($validated['vehicle_type_id'])) {
            $vehicleType = VehicleType::find($validated['vehicle_type_id']);
            $basePrice = $vehicleType ? $vehicleType->calculatePrice($basePrice) : $basePrice;
        }

        // Calculate driver fee
        $driverFee = 0;
        if ($validated['rental_type'] === 'with_driver') {
            $driverFee = 100000 * $days; // Assuming 100k per day for driver
        }

        $totalPrice = ($basePrice * $days) + $driverFee;

        // Get available armadas with mitra and reviews
        $availableArmadas = Armada::where('status', 'active')
                                  ->whereHas('mitra', function ($query) use ($validated) {
                                      $query->where('city', $validated['pickup_city'])->where('is_active', true);
                                  })
                                  ->with(['mitra', 'reviews' => function ($query) {
                                      $query->latest()->limit(5);
                                  }])
                                  ->when($vehicleType, function ($query) use ($vehicleType) {
                                      // Filter by vehicle type if implemented
                                  })
                                  ->get();

        return view('bookings.rental-results', [
            'searchParams' => $validated,
            'vehicleType' => $vehicleType,
            'basePrice' => $basePrice,
            'driverFee' => $driverFee,
            'totalPrice' => $finalTotalPrice,
            'addonTotal' => $addonTotal,
            'days' => $days,
            'availableArmadas' => $availableArmadas,
        ]);
    }

    /**
     * Show create form (legacy - redirect to search)
     */
    public function create(Request $request)
    {
        // If coming from search results with pre-filled data
        if ($request->has('pickup_city')) {
            $vehicleTypes = VehicleType::active()->sorted()->get();
            $selectedArmada = $request->armada_id ? Armada::find($request->armada_id) : null;
            $addonCategories = AddonCategory::active()->sorted()->with('addons')->get();

            return view('bookings.rental-book', [
                'vehicleTypes' => $vehicleTypes,
                'selectedArmada' => $selectedArmada,
                'addonCategories' => $addonCategories,
                'searchParams' => $request->all(),
            ]);
        }

        return redirect()->route('bookings.rental.search');
    }

    /**
     * Store booking
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Check identity verification
        if (!$user->is_identity_verified) {
            return redirect()->route('profile.edit')
                           ->with('error', 'Please verify your identity before booking');
        }

        $validated = $request->validate([
            'pickup_city' => 'required|string',
            'dropoff_city' => 'required|string',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'vehicle_type_id' => 'nullable|exists:vehicle_types,id',
            'rental_type' => 'required|in:with_driver,without_driver',
            'pickup_location' => 'required|string',
            'dropoff_location' => 'required|string',
            'pickup_address' => 'nullable|string',
            'dropoff_address' => 'nullable|string',
            'special_requests' => 'nullable|string',
            'is_for_guest' => 'boolean',
            'guest_name' => 'nullable|required_if:is_for_guest,true|string',
            'guest_phone' => 'nullable|required_if:is_for_guest,true|string',
            'guest_email' => 'nullable|required_if:is_for_guest,true|email',
            'pickup_instructions' => 'nullable|string',
            'total_price' => 'required|numeric|min:0',
            'assigned_armada_id' => 'nullable|exists:armadas,id',
            'addons' => 'nullable|array',
            'addons.*.addon_id' => 'required|exists:addons,id',
            'addons.*.quantity' => 'required|integer|min:1|max:10',
        ]);

        // Check same-day booking restriction
        $pickupDatetime = \Carbon\Carbon::parse($validated['start_date'] . ' ' . $validated['start_time']);
        if ($pickupDatetime->diffInHours(now()) < 12) {
            return back()->with('error', 'Same-day booking must be at least 12 hours in advance');
        }

        // Calculate duration for addon pricing
        $start = \Carbon\Carbon::parse($validated['start_date'] . ' ' . $validated['start_time']);
        $end = \Carbon\Carbon::parse($validated['end_date'] . ' ' . $validated['end_time']);
        $days = ceil($start->diffInHours($end) / 24);

        // Calculate addon prices
        $addonTotal = 0;
        $addonItems = [];
        if (isset($validated['addons'])) {
            foreach ($validated['addons'] as $addonData) {
                $addon = Addon::find($addonData['addon_id']);
                if ($addon) {
                    $price = $addon->calculatePrice($days);
                    $addonTotal += $price * $addonData['quantity'];
                    $addonItems[] = [
                        'addon_id' => $addon->id,
                        'quantity' => $addonData['quantity'],
                        'price_at_booking' => $price,
                    ];
                }
            }
        }

        // Recalculate total price with addons
        $baseTotalPrice = $validated['total_price'];
        $finalTotalPrice = $baseTotalPrice + $addonTotal;

        // Generate voucher code
        $voucherCode = RentalBooking::generateVoucherCode();

        $booking = RentalBooking::create([
            'user_id' => $user->id,
            'route_id' => null, // City-based, no specific route
            'vehicle_id' => $validated['assigned_armada_id'] ?? null,
            'pickup_city' => $validated['pickup_city'],
            'dropoff_city' => $validated['dropoff_city'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'vehicle_type_id' => $validated['vehicle_type_id'],
            'rental_type' => $validated['rental_type'],
            'pickup_location' => $validated['pickup_location'],
            'dropoff_location' => $validated['dropoff_location'],
            'pickup_address' => $validated['pickup_address'],
            'dropoff_address' => $validated['dropoff_address'],
            'special_requests' => $validated['special_requests'],
            'is_for_guest' => $validated['is_for_guest'] ?? false,
            'guest_name' => $validated['guest_name'],
            'guest_phone' => $validated['guest_phone'],
            'guest_email' => $validated['guest_email'],
            'pickup_instructions' => $validated['pickup_instructions'],
            'total_price' => $finalTotalPrice,
            'voucher_code' => $voucherCode,
            'status' => 'pending',
        ]);

        // Create e-voucher for the booking
        $eVoucher = Voucher::createEVoucher($booking, 30); // Valid for 30 days
        $booking->update(['voucher_id' => $eVoucher->id]);

        // Create addon records
        foreach ($addonItems as $addonItem) {
            RentalBookingAddon::create([
                'rental_booking_id' => $booking->id,
                'addon_id' => $addonItem['addon_id'],
                'quantity' => $addonItem['quantity'],
                'price_at_booking' => $addonItem['price_at_booking'],
            ]);
        }

        return redirect()->route('bookings.rental.show', $booking->id)
                       ->with('success', 'Rental booking created. Please complete payment');
    }

    /**
     * Show booking details
     */
    public function show(RentalBooking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load(['user', 'route', 'armada', 'vehicleType', 'voucher']);
        return view('bookings.rental-show', compact('booking'));
    }

    /**
     * Cancel booking
     */
    public function destroy(RentalBooking $booking)
    {
        $this->authorize('delete', $booking);

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Booking already cancelled');
        }

        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking cancelled successfully');
    }
}
