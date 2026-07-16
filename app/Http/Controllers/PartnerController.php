<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Armada;
use App\Models\RevenueSharing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    /**
     * Get the current authenticated partner
     */
    private function getPartner()
    {
        $user = Auth::user();
        return Mitra::where('email', $user->email)->first();
    }

    /**
     * Display partners (admin)
     */
    public function index(Request $request)
    {
        $partners = Mitra::query();

        if ($request->has('search')) {
            $search = $request->search;
            $partners->where('name', 'like', "%$search%")
                     ->orWhere('city', 'like', "%$search%");
        }

        $partners = $partners->withCount('armadas')->get();
        return view('partners.index', compact('partners'));
    }

    /**
     * Show create form (admin)
     */
    public function create()
    {
        return view('partners.create');
    }

    /**
     * Store partner (admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:mitras',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'bank_name' => 'required|string',
            'bank_account' => 'required|string',
            'bank_holder' => 'required|string',
        ]);

        Mitra::create($validated);
        return redirect()->route('partners.index')
                       ->with('success', 'Partner added successfully');
    }

    /**
     * Show partner details (admin)
     */
    public function show(Mitra $partner)
    {
        $partner->load('armadas');
        return view('partners.show', compact('partner'));
    }

    /**
     * Show edit form (admin)
     */
    public function edit(Mitra $partner)
    {
        return view('partners.edit', compact('partner'));
    }

    /**
     * Update partner (admin)
     */
    public function update(Request $request, Mitra $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:mitras,email,' . $partner->id,
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'bank_name' => 'required|string',
            'bank_account' => 'required|string',
            'bank_holder' => 'required|string',
        ]);

        $partner->update($validated);
        return redirect()->route('partners.index')
                       ->with('success', 'Partner updated successfully');
    }

    /**
     * Delete partner (admin)
     */
    public function destroy(Mitra $partner)
    {
        $partner->delete();
        return redirect()->route('partners.index')
                       ->with('success', 'Partner deleted successfully');
    }

    /**
     * Show partner dashboard
     */
    public function dashboard()
    {
        $partner = $this->getPartner();

        if (!$partner) {
            abort(404, 'Partner profile not found');
        }

        $totalArmadas = Armada::where('mitra_id', $partner->id)->count();

        $totalDrivers = Armada::where('mitra_id', $partner->id)
            ->whereNotNull('driver_name')
            ->count();

        $totalEarnings = RevenueSharing::where('mitra_id', $partner->id)
            ->where('status', 'completed')
            ->sum('mitra_amount');

        $pendingPayouts = RevenueSharing::where('mitra_id', $partner->id)
            ->where('status', 'pending')
            ->sum('mitra_amount');

        $recentTransactions = RevenueSharing::where('mitra_id', $partner->id)
            ->latest()
            ->take(10)
            ->get();

        // Service breakdown - query through armadas belonging to this partner
        $partnerArmadaIds = Armada::where('mitra_id', $partner->id)->pluck('id');

        $travelBookings = \App\Models\TravelBooking::whereIn('assigned_armada_id', $partnerArmadaIds)->count();
        $rentalBookings = \App\Models\RentalBooking::whereIn('assigned_armada_id', $partnerArmadaIds)->count();
        $airportBookings = \App\Models\AirportTransferBooking::whereIn('assigned_armada_id', $partnerArmadaIds)->count();

        // Armada status summary
        $armadaTersedia = Armada::where('mitra_id', $partner->id)
            ->where('status', 'tersedia')->count();
        $armadaJalan = Armada::where('mitra_id', $partner->id)
            ->where('status', 'jalan')->count();
        $armadaMaintenance = Armada::where('mitra_id', $partner->id)
            ->where('status', 'maintenance')->count();

        // Revenue trend (last 7 days)
        $revenueTrend = RevenueSharing::where('mitra_id', $partner->id)
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, SUM(mitra_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('partner.dashboard', compact(
            'partner',
            'totalArmadas',
            'totalDrivers',
            'totalEarnings',
            'pendingPayouts',
            'recentTransactions',
            'travelBookings',
            'rentalBookings',
            'airportBookings',
            'armadaTersedia',
            'armadaJalan',
            'armadaMaintenance',
            'revenueTrend'
        ));
    }

    /**
     * Show partner armada management
     */
    public function armadas()
    {
        $partner = $this->getPartner();

        if (!$partner) {
            abort(404, 'Partner profile not found');
        }

        $armadas = Armada::where('mitra_id', $partner->id)
            ->latest()
            ->get();

        return view('partner.armadas', compact('armadas'));
    }

    /**
     * Store armada for partner
     */
    public function storeArmada(Request $request)
    {
        $partner = $this->getPartner();

        if (!$partner) {
            abort(404, 'Partner profile not found');
        }

        $validated = $request->validate([
            'plate_number' => 'required|string|unique:armadas',
            'driver_name' => 'required|string|max:255',
            'driver_phone' => 'nullable|string',
            'vehicle_type' => 'required|string|max:255',
            'seat_capacity' => 'required|integer|min:1|max:30',
            'status' => 'nullable|in:tersedia,jalan,maintenance',
        ]);

        Armada::create([
            'mitra_id' => $partner->id,
            'plate_number' => $validated['plate_number'],
            'driver_name' => $validated['driver_name'],
            'driver_phone' => $validated['driver_phone'] ?? null,
            'vehicle_type' => $validated['vehicle_type'],
            'seat_capacity' => $validated['seat_capacity'],
            'status' => $validated['status'] ?? 'tersedia',
        ]);

        return redirect()->route('partner.armadas')
                       ->with('success', 'Armada added successfully');
    }

    /**
     * Show edit armada form
     */
    public function editArmada(Armada $armada)
    {
        $partner = $this->getPartner();

        if (!$partner || $armada->mitra_id !== $partner->id) {
            abort(403, 'Unauthorized');
        }

        return view('partner.armada-edit', compact('armada'));
    }

    /**
     * Update armada
     */
    public function updateArmada(Request $request, Armada $armada)
    {
        $partner = $this->getPartner();

        if (!$partner || $armada->mitra_id !== $partner->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'plate_number' => 'required|string|unique:armadas,plate_number,' . $armada->id,
            'driver_name' => 'required|string|max:255',
            'driver_phone' => 'nullable|string',
            'vehicle_type' => 'required|string|max:255',
            'seat_capacity' => 'required|integer|min:1|max:30',
            'status' => 'nullable|in:tersedia,jalan,maintenance',
        ]);

        $armada->update($validated);

        return redirect()->route('partner.armadas')
                       ->with('success', 'Armada updated successfully');
    }

    /**
     * Show partner driver management
     */
    public function drivers()
    {
        $partner = $this->getPartner();

        if (!$partner) {
            abort(404, 'Partner profile not found');
        }

        $drivers = Armada::where('mitra_id', $partner->id)
            ->whereNotNull('driver_name')
            ->with('mitra')
            ->latest()
            ->get();

        return view('partner.drivers', compact('drivers'));
    }

    /**
     * Store driver (creates armada with driver info) for partner
     */
    public function storeDriver(Request $request)
    {
        $partner = $this->getPartner();

        if (!$partner) {
            abort(404, 'Partner profile not found');
        }

        $validated = $request->validate([
            'driver_name' => 'required|string|max:255',
            'driver_phone' => 'nullable|string',
            'plate_number' => 'required|string|unique:armadas',
            'vehicle_type' => 'required|string|max:255',
            'seat_capacity' => 'required|integer|min:1|max:30',
            'status' => 'nullable|in:tersedia,jalan,maintenance',
        ]);

        Armada::create([
            'mitra_id' => $partner->id,
            'driver_name' => $validated['driver_name'],
            'driver_phone' => $validated['driver_phone'] ?? null,
            'plate_number' => $validated['plate_number'],
            'vehicle_type' => $validated['vehicle_type'],
            'seat_capacity' => $validated['seat_capacity'],
            'status' => $validated['status'] ?? 'tersedia',
        ]);

        return redirect()->route('partner.drivers')
                       ->with('success', 'Driver added successfully');
    }

    /**
     * Show edit driver form
     */
    public function editDriver(Armada $armada)
    {
        $partner = $this->getPartner();

        if (!$partner || $armada->mitra_id !== $partner->id) {
            abort(403, 'Unauthorized');
        }

        return view('partner.driver-edit', compact('armada'));
    }

    /**
     * Update driver
     */
    public function updateDriver(Request $request, Armada $armada)
    {
        $partner = $this->getPartner();

        if (!$partner || $armada->mitra_id !== $partner->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'driver_name' => 'required|string|max:255',
            'driver_phone' => 'nullable|string',
            'plate_number' => 'required|string|unique:armadas,plate_number,' . $armada->id,
            'vehicle_type' => 'required|string|max:255',
            'seat_capacity' => 'required|integer|min:1|max:30',
            'status' => 'nullable|in:tersedia,jalan,maintenance',
        ]);

        $armada->update($validated);

        return redirect()->route('partner.drivers')
                       ->with('success', 'Driver updated successfully');
    }

    /**
     * Show partner revenue / earnings dashboard
     */
    public function revenue()
    {
        $partner = $this->getPartner();

        if (!$partner) {
            abort(404, 'Partner profile not found');
        }

        $revenueSharings = RevenueSharing::where('mitra_id', $partner->id)
            ->latest()
            ->paginate(15);

        $totalEarnings = RevenueSharing::where('mitra_id', $partner->id)
            ->where('status', 'completed')
            ->sum('mitra_amount');

        $pendingPayouts = RevenueSharing::where('mitra_id', $partner->id)
            ->where('status', 'pending')
            ->sum('mitra_amount');

        $completedPayouts = $revenueSharings->where('status', 'completed')->count();

        return view('partners.revenue', compact(
            'partner',
            'revenueSharings',
            'totalEarnings',
            'pendingPayouts',
            'completedPayouts'
        ));
    }
}
