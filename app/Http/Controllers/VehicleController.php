<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display vehicles
     */
    public function index(Request $request)
    {
        $vehicles = Armada::query();

        if ($request->has('status') && $request->status !== 'all') {
            $vehicles->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $vehicles->where('plate_number', 'like', "%$search%")
                     ->orWhere('driver_name', 'like', "%$search%");
        }

        $vehicles = $vehicles->with('mitra')->get();
        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('vehicles.create');
    }

    /**
     * Store vehicle
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|unique:armadas',
            'vehicle_type' => 'required|string',
            'seat_capacity' => 'required|integer|min:1',
            'driver_name' => 'required|string',
            'driver_phone' => 'required|string',
        ]);

        Armada::create($validated);
        return redirect()->route('vehicles.index')
                       ->with('success', 'Vehicle added successfully');
    }

    /**
     * Show vehicle details
     */
    public function show(Armada $vehicle)
    {
        $vehicle->load('mitra');
        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show edit form
     */
    public function edit(Armada $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * Update vehicle
     */
    public function update(Request $request, Armada $vehicle)
    {
        $validated = $request->validate([
            'vehicle_type' => 'required|string',
            'seat_capacity' => 'required|integer|min:1',
            'driver_name' => 'required|string',
            'driver_phone' => 'required|string',
            'status' => 'required|in:tersedia,jalan,maintenance',
        ]);

        $vehicle->update($validated);
        return redirect()->route('vehicles.index')
                       ->with('success', 'Vehicle updated successfully');
    }

    /**
     * Delete vehicle
     */
    public function destroy(Armada $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')
                       ->with('success', 'Vehicle deleted successfully');
    }
}
