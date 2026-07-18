<?php

namespace App\Services;

use App\Models\IdentityVerification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class IdentityVerificationService
{
    /**
     * Create or update identity verification
     */
    public function createOrUpdate($user, array $data, ?UploadedFile $idImage = null)
    {
        $verification = IdentityVerification::updateOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => $data['full_name'] ?? $user->name,
                'id_type' => $data['id_type'], // KTP or SIM
                'id_number' => $data['id_number'],
                'id_expiry_date' => $data['id_expiry_date'] ?? null,
            ]
        );

        // Handle file upload
        if ($idImage) {
            // Delete old file if exists
            if ($verification->id_image_path) {
                Storage::disk('public')->delete($verification->id_image_path);
            }

            // Store new file
            $path = $idImage->store('identities/' . $user->id, 'public');
            $verification->update(['id_image_path' => $path]);
        }

        return $verification;
    }

    /**
     * Submit for verification
     */
    public function submitForVerification($user)
    {
        $verification = $user->identityVerification;

        if (!$verification) {
            throw new \Exception('No identity data found');
        }

        if ($verification->is_verified) {
            throw new \Exception('Already verified');
        }

        $verification->update([
            'is_verified' => false, // Set to pending
            'verified_at' => null,
        ]);

        return $verification;
    }

    /**
     * Approve verification (admin only)
     */
    public function approveVerification($verification, $adminId = null)
    {
        $verification->update([
            'is_verified' => true,
            'verified_by' => $adminId ?? auth()->id(),
            'verified_at' => now(),
        ]);

        // Update user as verified
        $verification->user->update(['is_verified' => true]);

        return $verification;
    }

    /**
     * Reject verification (admin only)
     */
    public function rejectVerification($verification, $reason = null)
    {
        $verification->update([
            'is_verified' => false,
            'rejection_reason' => $reason,
            'verified_at' => null,
        ]);

        return $verification;
    }

    /**
     * Get verification status
     */
    public function getStatus($user)
    {
        $verification = $user->identityVerification;

        if (!$verification) {
            return ['status' => 'not_submitted', 'message' => 'Identity not yet submitted'];
        }

        if ($verification->is_verified && $verification->verified_at) {
            return ['status' => 'verified', 'message' => 'Identity verified', 'verified_at' => $verification->verified_at];
        }

        if ($verification->rejection_reason) {
            return ['status' => 'rejected', 'message' => 'Verification rejected', 'reason' => $verification->rejection_reason];
        }

        return ['status' => 'pending', 'message' => 'Verification pending'];
    }

    /**
     * Get pending verifications for admin
     */
    public function getPendingVerifications($companyId = null)
    {
        $query = IdentityVerification::where('is_verified', false)
            ->whereNull('verified_at')
            ->with('user');

        if ($companyId) {
            $query->whereHas('user', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
        }

        return $query->paginate(15);
    }

    /**
     * Batch approve verifications
     */
    public function batchApprove($ids, $adminId = null)
    {
        $verifications = IdentityVerification::whereIn('id', $ids)->get();

        foreach ($verifications as $verification) {
            $this->approveVerification($verification, $adminId);
        }

        return count($verifications);
    }
}
