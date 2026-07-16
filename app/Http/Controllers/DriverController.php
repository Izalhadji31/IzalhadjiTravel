<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display drivers
     */
    public function index(Request $request)
    {
        $query = Armada::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('driver_name', 'like', "%$search%")
                  ->orWhere('driver_phone', 'like', "%$search%");
        }

        $drivers = $query->with('mitra')->get();
        $totalDrivers = $drivers->count();
        $availableDrivers = $drivers->where('status', 'tersedia')->count();
        $onDutyDrivers = $drivers->where('status', 'jalan')->count();
        $maintenanceDrivers = $drivers->where('status', 'maintenance')->count();

        return view('drivers.index', compact(
            'drivers',
            'totalDrivers',
            'availableDrivers',
            'onDutyDrivers',
            'maintenanceDrivers'
        ));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('drivers.create');
    }

    /**
     * Store driver
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'driver_name' => 'required|string|max:255',
            'driver_phone' => 'required|string',
            'plate_number' => 'required|string|unique:armadas',
            'vehicle_type' => 'required|string|max:255',
            'seat_capacity' => 'required|integer|min:1|max:30',
            'status' => 'nullable|in:tersedia,jalan,maintenance',
        ]);

        Armada::create(array_merge($validated, [
            'status' => $validated['status'] ?? 'tersedia',
        ]));

        return redirect()->route('drivers.index')
                       ->with('success', 'Driver added successfully');
    }

    /**
     * Show driver details
     */
    public function show(Armada $driver)
    {
        $driver->load('mitra');
        return view('drivers.show', compact('driver'));
    }

    /**
     * Show edit form
     */
    public function edit(Armada $driver)
    {
        return view('drivers.edit', compact('driver'));
    }

    /**
     * Update driver
     */
    public function update(Request $request, Armada $driver)
    {
        $validated = $request->validate([
            'driver_name' => 'required|string|max:255',
            'driver_phone' => 'required|string',
            'plate_number' => 'required|string|unique:armadas,plate_number,' . $driver->id,
            'vehicle_type' => 'required|string|max:255',
            'seat_capacity' => 'required|integer|min:1|max:30',
            'status' => 'required|in:tersedia,jalan,maintenance',
        ]);

        $driver->update($validated);
        return redirect()->route('drivers.index')
                       ->with('success', 'Driver updated successfully');
    }

    /**
     * Delete driver
     */
    public function destroy(Armada $driver)
    {
        $driver->delete();
        return redirect()->route('drivers.index')
                       ->with('success', 'Driver deleted successfully');
    }
}
