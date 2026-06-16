<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\TravelPrice;
use App\Models\RentalPrice;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Display routes
     */
    public function index(Request $request)
    {
        $routes = Route::where('is_active', true);

        if ($request->has('type') && $request->type !== 'all') {
            $routes->where('route_type', $request->type);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $routes->where(fn($query) => $query
                ->where('name', 'like', "%$search%")
                ->orWhere('origin_city', 'like', "%$search%")
                ->orWhere('destination_city', 'like', "%$search%"));
        }

        $routes = $routes->with(['travelPrices', 'rentalPrices'])
                         ->get();

        return view('routes.index', compact('routes'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('routes.create');
    }

    /**
     * Show route details
     */
    public function show(Route $route)
    {
        $route->load(['travelPrices', 'rentalPrices']);
        return view('routes.show', compact('route'));
    }

    /**
     * Store new route
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'origin_city' => 'nullable|string|max:100',
            'destination_city' => 'nullable|string|max:100',
            'route_type' => 'required|in:travel,rental,both',
            'distance_km' => 'required|numeric|min:0',
            'estimated_hours' => 'nullable|numeric|min:0',
        ]);

        $validated['service_type'] = $validated['route_type'] === 'rental' ? 'rental' : 'travel';
        $validated['base_price'] = 0;
        $validated['estimated_distance'] = $validated['distance_km'];

        Route::create($validated);
        return redirect()->route('routes.index')->with('success', 'Route created successfully');
    }

    /**
     * Show edit form
     */
    public function edit(Route $route)
    {
        return view('routes.edit', compact('route'));
    }

    /**
     * Update route
     */
    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'origin_city' => 'nullable|string|max:100',
            'destination_city' => 'nullable|string|max:100',
            'route_type' => 'required|in:travel,rental,both',
            'distance_km' => 'required|numeric|min:0',
            'estimated_hours' => 'nullable|numeric|min:0',
        ]);

        $validated['service_type'] = $validated['route_type'] === 'rental' ? 'rental' : 'travel';
        $validated['estimated_distance'] = $validated['distance_km'];

        $route->update($validated);
        return redirect()->route('routes.index')->with('success', 'Route updated successfully');
    }

    /**
     * Delete route
     */
    public function destroy(Route $route)
    {
        $route->delete();
        return redirect()->route('routes.index')->with('success', 'Route deleted successfully');
    }
}
