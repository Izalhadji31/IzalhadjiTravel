<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Armada;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminArmadaController extends Controller
{
    /**
     * Get all armadas
     */
    public function index(Request $request)
    {
        $armadas = Armada::query();

        if ($request->has('status')) {
            $armadas->where('status', $request->status);
        }

        if ($request->has('mitra_id')) {
            $armadas->where('mitra_id', $request->mitra_id);
        }

        $armadas = $armadas->with('mitra')
                           ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $armadas,
        ]);
    }

    /**
     * Get single armada
     */
    public function show(Armada $armada)
    {
        $armada->load('mitra');

        return response()->json([
            'success' => true,
            'data' => $armada,
        ]);
    }

    /**
     * Create armada
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mitra_id' => 'required|exists:mitras,id',
            'driver_name' => 'required|string|max:255',
            'driver_phone' => 'required|string|max:20',
            'plate_number' => 'required|string|max:20|unique:armadas',
            'vehicle_type' => 'required|string|max:100',
            'seat_capacity' => 'required|integer|min:1|max:100',
            'purchase_date' => 'nullable|date',
            'last_maintenance_date' => 'nullable|date',
        ]);

        $armada = Armada::create($validated);
        $armada->load('mitra');

        return response()->json([
            'success' => true,
            'message' => 'Armada created successfully',
            'data' => $armada,
        ], 201);
    }

    /**
     * Update armada
     */
    public function update(Request $request, Armada $armada)
    {
        $validated = $request->validate([
            'mitra_id' => 'exists:mitras,id',
            'driver_name' => 'string|max:255',
            'driver_phone' => 'string|max:20',
            'plate_number' => ['string', 'max:20', Rule::unique('armadas')->ignore($armada->id)],
            'vehicle_type' => 'string|max:100',
            'seat_capacity' => 'integer|min:1|max:100',
            'status' => Rule::in(['tersedia', 'jalan', 'maintenance']),
            'purchase_date' => 'nullable|date',
            'last_maintenance_date' => 'nullable|date',
        ]);

        $armada->update($validated);
        $armada->load('mitra');

        return response()->json([
            'success' => true,
            'message' => 'Armada updated successfully',
            'data' => $armada,
        ]);
    }

    /**
     * Delete armada
     */
    public function destroy(Armada $armada)
    {
        $armada->delete();

        return response()->json([
            'success' => true,
            'message' => 'Armada deleted successfully',
        ]);
    }

    /**
     * Get armada by status
     */
    public function getByStatus($status)
    {
        if (!in_array($status, ['tersedia', 'jalan', 'maintenance'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status',
            ], 400);
        }

        $armadas = Armada::where('status', $status)
                        ->with('mitra')
                        ->get();

        return response()->json([
            'success' => true,
            'data' => $armadas,
            'count' => $armadas->count(),
        ]);
    }

    /**
     * Update armada status
     */
    public function updateStatus(Request $request, Armada $armada)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['tersedia', 'jalan', 'maintenance'])],
        ]);

        $oldStatus = $armada->status;
        $armada->update($validated);

        return response()->json([
            'success' => true,
            'message' => "Armada status updated from {$oldStatus} to {$validated['status']}",
            'data' => $armada,
        ]);
    }

    /**
     * Get available armadas for assignment
     */
    public function getAvailable(Request $request)
    {
        $armadas = Armada::available()
                        ->with('mitra');

        if ($request->has('min_seats')) {
            $armadas->where('seat_capacity', '>=', $request->min_seats);
        }

        $armadas = $armadas->get();

        return response()->json([
            'success' => true,
            'data' => $armadas,
            'count' => $armadas->count(),
        ]);
    }
}
