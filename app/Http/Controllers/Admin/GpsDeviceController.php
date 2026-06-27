<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GpsDevice;
use App\Models\Armada;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GpsDeviceController extends Controller
{
    /**
     * Display a listing of GPS devices
     */
    public function index(Request $request)
    {
        $devices = GpsDevice::with('armada')
            ->when($request->has('status'), function ($query) use ($request) {
                if ($request->status === 'active') {
                    $query->where('is_active', true);
                } elseif ($request->status === 'inactive') {
                    $query->where('is_active', false);
                }
            })
            ->when($request->has('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('device_id', 'like', "%{$search}%")
                      ->orWhere('device_name', 'like', "%{$search}%");
                });
            })
            ->orderBy('last_contact_at', 'desc')
            ->paginate(20);

        return view('admin.gps-devices', compact('devices'));
    }

    /**
     * Store a newly created GPS device
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string|max:100|unique:gps_devices',
            'device_name' => 'required|string|max:255',
            'device_type' => 'required|string|max:100',
            'armada_id' => 'nullable|exists:armadas,id',
            'is_active' => 'boolean',
            'settings' => 'nullable|array',
        ]);

        $validated['api_key'] = Str::random(40);
        $validated['is_active'] = $request->boolean('is_active', true);

        $device = GpsDevice::create($validated);

        return redirect()
            ->route('admin.gps-devices')
            ->with('success', "GPS device \"{$device->device_name}\" created successfully. API Key: {$device->api_key}")
            ->with('api_key', $device->api_key);
    }

    /**
     * Update the specified GPS device
     */
    public function update(Request $request, GpsDevice $device)
    {
        $validated = $request->validate([
            'device_id' => 'required|string|max:100|unique:gps_devices,device_id,' . $device->id,
            'device_name' => 'required|string|max:255',
            'device_type' => 'required|string|max:100',
            'armada_id' => 'nullable|exists:armadas,id',
            'is_active' => 'boolean',
            'settings' => 'nullable|array',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        $device->update($validated);

        return redirect()
            ->route('admin.gps-devices')
            ->with('success', "GPS device \"{$device->device_name}\" updated successfully.");
    }

    /**
     * Remove the specified GPS device
     */
    public function destroy(GpsDevice $device)
    {
        $name = $device->device_name;
        $device->delete();

        return redirect()
            ->route('admin.gps-devices')
            ->with('success', "GPS device \"{$name}\" deleted successfully.");
    }
}
