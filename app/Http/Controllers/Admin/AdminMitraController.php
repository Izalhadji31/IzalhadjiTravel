<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminMitraController extends Controller
{
    /**
     * Get all mitras
     */
    public function index(Request $request)
    {
        $mitras = Mitra::query();

        if ($request->has('active')) {
            $mitras->where('is_active', $request->boolean('active'));
        }

        if ($request->has('search')) {
            $search = $request->search;
            $mitras->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $mitras = $mitras->with('armadas')
                        ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $mitras,
        ]);
    }

    /**
     * Get single mitra
     */
    public function show(Mitra $mitra)
    {
        $mitra->load(['armadas']);

        return response()->json([
            'success' => true,
            'data' => $mitra,
        ]);
    }

    /**
     * Create mitra
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:mitras',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'bank_name' => 'required|string|max:100',
            'bank_account' => 'required|string|max:50|unique:mitras',
            'bank_holder' => 'required|string|max:255',
            'revenue_share_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $mitra = Mitra::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mitra created successfully',
            'data' => $mitra,
        ], 201);
    }

    /**
     * Update mitra
     */
    public function update(Request $request, Mitra $mitra)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'phone' => 'string|max:20',
            'email' => ['email', Rule::unique('mitras')->ignore($mitra->id)],
            'address' => 'string',
            'city' => 'string|max:100',
            'bank_name' => 'string|max:100',
            'bank_account' => ['string', 'max:50', Rule::unique('mitras')->ignore($mitra->id)],
            'bank_holder' => 'string|max:255',
            'is_active' => 'boolean',
            'revenue_share_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $mitra->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mitra updated successfully',
            'data' => $mitra,
        ]);
    }

    /**
     * Delete mitra
     */
    public function destroy(Mitra $mitra)
    {
        // Check if has active armadas
        if ($mitra->armadas()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete mitra with active armadas',
            ], 400);
        }

        $mitra->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mitra deleted successfully',
        ]);
    }

    /**
     * Get mitra earnings summary
     */
    public function getEarnings(Mitra $mitra)
    {
        $earnings = \App\Models\RevenueSharing::where('mitra_id', $mitra->id)
                                            ->where('status', 'completed')
                                            ->get();

        $totalEarnings = $earnings->sum('mitra_amount');
        $totalTransactions = $earnings->count();

        return response()->json([
            'success' => true,
            'data' => [
                'mitra_id' => $mitra->id,
                'mitra_name' => $mitra->name,
                'total_earnings' => $totalEarnings,
                'total_transactions' => $totalTransactions,
                'average_earning' => $totalTransactions > 0 ? $totalEarnings / $totalTransactions : 0,
                'armada_count' => $mitra->armadas->count(),
            ],
        ]);
    }

    /**
     * Activate/Deactivate mitra
     */
    public function toggleStatus(Mitra $mitra)
    {
        $mitra->update(['is_active' => !$mitra->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Mitra status updated',
            'is_active' => $mitra->is_active,
        ]);
    }
}
