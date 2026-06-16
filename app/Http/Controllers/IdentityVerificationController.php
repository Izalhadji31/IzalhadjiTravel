<?php

namespace App\Http\Controllers;

use App\Models\IdentityVerification;
use App\Models\User;
use App\Services\IdentityVerificationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class IdentityVerificationController extends Controller
{
    protected $service;

    public function __construct(IdentityVerificationService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    /**
     * Show verification form
     */
    public function create(): View
    {
        $user = auth()->user();
        $verification = $user->identityVerification;
        $status = $this->service->getStatus($user);

        return view('identity.create', compact('verification', 'status'));
    }

    /**
     * Store identity verification
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'id_type' => 'required|in:KTP,SIM',
            'id_number' => 'required|string|unique:identity_verifications,id_number|max:20',
            'id_expiry_date' => 'nullable|date',
            'id_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $this->service->createOrUpdate(
                auth()->user(),
                $validated,
                $request->file('id_image')
            );

            return back()->with('success', 'Identity data saved. Awaiting verification.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to save identity: ' . $e->getMessage());
        }
    }

    /**
     * Show user verification status
     */
    public function show(): View
    {
        $user = auth()->user();
        $verification = $user->identityVerification;
        $status = $this->service->getStatus($user);

        return view('identity.show', compact('user', 'verification', 'status'));
    }

    /**
     * Admin: View pending verifications
     */
    public function adminPending(Request $request): View
    {
        $this->authorize('viewAny', IdentityVerification::class);

        $companyId = auth()->user()->company_id;
        $verifications = $this->service->getPendingVerifications($companyId);

        return view('admin.identity-pending', compact('verifications'));
    }

    /**
     * Admin: Approve verification
     */
    public function approve(Request $request, $verificationId): RedirectResponse
    {
        $this->authorize('update', IdentityVerification::class);

        $verification = IdentityVerification::findOrFail($verificationId);

        try {
            $this->service->approveVerification($verification, auth()->id());
            return back()->with('success', 'Identity verified successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to verify: ' . $e->getMessage());
        }
    }

    /**
     * Admin: Reject verification
     */
    public function reject(Request $request, $verificationId): RedirectResponse
    {
        $this->authorize('update', IdentityVerification::class);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $verification = IdentityVerification::findOrFail($verificationId);

        try {
            $this->service->rejectVerification($verification, $validated['rejection_reason']);
            return back()->with('success', 'Identity verification rejected');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject: ' . $e->getMessage());
        }
    }

    /**
     * Admin: Batch approve
     */
    public function batchApprove(Request $request): RedirectResponse
    {
        $this->authorize('update', IdentityVerification::class);

        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:identity_verifications,id',
        ]);

        try {
            $count = $this->service->batchApprove($validated['ids'], auth()->id());
            return back()->with('success', "$count verifications approved");
        } catch (\Exception $e) {
            return back()->with('error', 'Batch approval failed: ' . $e->getMessage());
        }
    }
}
