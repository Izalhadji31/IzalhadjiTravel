<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\TravelPrice;
use App\Models\RentalPrice;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminRouteController extends Controller
{
    /**
     * Get all routes
     */
    public function index(Request $request)
    {
        $routes = Route::query();

        if ($request->has('type') && $request->type !== 'all') {
            $routes->where('route_type', $request->type);
        }

        if ($request->has('active')) {
            $routes->where('is_active', $request->boolean('active'));
        }

        $routes = $routes->with(['travelPrices', 'rentalPrices'])
                        ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $routes,
        ]);
    }

    /**
     * Get single route
     */
    public function show(Route $route)
    {
        $route->load(['travelPrices', 'rentalPrices']);

        return response()->json([
            'success' => true,
            'data' => $route,
        ]);
    }

    /**
     * Create route
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:routes',
            'origin_city' => 'required|string|max:100',
            'destination_city' => 'required|string|max:100',
            'distance_km' => 'required|integer|min:1',
            'estimated_hours' => 'required|numeric|min:0.5',
            'route_type' => ['required', Rule::in(['travel', 'rental', 'both'])],
            'is_active' => 'boolean',
            'travel_price' => 'nullable|numeric|min:0',
            'rental_price_without_driver' => 'nullable|numeric|min:0',
            'rental_price_with_driver' => 'nullable|numeric|min:0',
        ]);

        $route = Route::create($validated);

        // Create travel price if provided
        if ($request->has('travel_price') && in_array($validated['route_type'], ['travel', 'both'])) {
            TravelPrice::create([
                'route_id' => $route->id,
                'price_per_seat' => $request->travel_price,
                'is_active' => true,
            ]);
        }

        // Create rental price if provided
        if ($request->has('rental_price_without_driver') && in_array($validated['route_type'], ['rental', 'both'])) {
            RentalPrice::create([
                'route_id' => $route->id,
                'price_without_driver' => $request->rental_price_without_driver,
                'driver_fee_per_regency' => $request->rental_price_with_driver ?? 100000,
                'is_active' => true,
            ]);
        }

        $route->load(['travelPrices', 'rentalPrices']);

        return response()->json([
            'success' => true,
            'message' => 'Route created successfully',
            'data' => $route,
        ], 201);
    }

    /**
     * Update route
     */
    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'name' => ['string', 'max:255', Rule::unique('routes')->ignore($route->id)],
            'origin_city' => 'string|max:100',
            'destination_city' => 'string|max:100',
            'distance_km' => 'integer|min:1',
            'estimated_hours' => 'numeric|min:0.5',
            'route_type' => Rule::in(['travel', 'rental', 'both']),
            'is_active' => 'boolean',
            'travel_price' => 'nullable|numeric|min:0',
            'rental_price_without_driver' => 'nullable|numeric|min:0',
            'rental_price_with_driver' => 'nullable|numeric|min:0',
        ]);

        // Remove price fields from route update
        $priceData = [];
        foreach (['travel_price', 'rental_price_without_driver', 'rental_price_with_driver'] as $key) {
            if (isset($validated[$key])) {
                $priceData[$key] = $validated[$key];
                unset($validated[$key]);
            }
        }

        $route->update($validated);

        // Update travel price
        if (isset($priceData['travel_price'])) {
            $travelPrice = $route->travelPrices()->where('is_active', true)->first();
            if ($travelPrice instanceof TravelPrice) {
                $travelPrice->update(['price_per_seat' => $priceData['travel_price']]);
            }
        }

        // Update rental price
        if (isset($priceData['rental_price_without_driver'])) {
            $rentalPrice = $route->rentalPrices()->where('is_active', true)->first();
            if ($rentalPrice instanceof RentalPrice) {
                $rentalPrice->update([
                    'price_without_driver' => $priceData['rental_price_without_driver'],
                    'driver_fee_per_regency' => $priceData['rental_price_with_driver'] ?? $rentalPrice->driver_fee_per_regency,
                ]);
            }
        }

        $route->load(['travelPrices', 'rentalPrices']);

        return response()->json([
            'success' => true,
            'message' => 'Route updated successfully',
            'data' => $route,
        ]);
    }

    /**
     * Delete route
     */
    public function destroy(Route $route)
    {
        $route->delete();

        return response()->json([
            'success' => true,
            'message' => 'Route deleted successfully',
        ]);
    }

    /**
     * Bulk update route status
     */
    public function bulkUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'route_ids' => 'required|array',
            'route_ids.*' => 'integer|exists:routes,id',
            'status' => 'required|boolean',
        ]);

        Route::whereIn('id', $validated['route_ids'])
            ->update(['is_active' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Routes status updated successfully',
            'updated_count' => count($validated['route_ids']),
        ]);
    }
}
