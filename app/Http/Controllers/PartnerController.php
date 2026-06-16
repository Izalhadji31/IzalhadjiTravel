<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display partners
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
     * Show create form
     */
    public function create()
    {
        return view('partners.create');
    }

    /**
     * Store partner
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
     * Show partner details
     */
    public function show(Mitra $partner)
    {
        $partner->load('armadas');
        return view('partners.show', compact('partner'));
    }

    /**
     * Show edit form
     */
    public function edit(Mitra $partner)
    {
        return view('partners.edit', compact('partner'));
    }

    /**
     * Update partner
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
     * Delete partner
     */
    public function destroy(Mitra $partner)
    {
        $partner->delete();
        return redirect()->route('partners.index')
                       ->with('success', 'Partner deleted successfully');
    }
}
