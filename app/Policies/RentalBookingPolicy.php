<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RentalBooking;

class RentalBookingPolicy
{
    /**
     * Determine if the user can view the booking
     */
    public function view(User $user, RentalBooking $booking): bool
    {
        // Check if user owns the booking (normalize UUIDs to strings for comparison)
        if ((string) $user->id === (string) $booking->user_id) {
            return true;
        }

        // Check if user is admin (via column or Spatie role)
        if ($user->role === 'admin') {
            return true;
        }

        // Check if user has admin role via Spatie Permissions
        if (method_exists($user, 'hasRole') && $user->hasRole('admin')) {
            return true;
        }

        // Check if user is super admin
        if (method_exists($user, 'hasRole') && $user->hasRole('super_admin')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can delete the booking
     */
    public function delete(User $user, RentalBooking $booking): bool
    {
        // Only pending bookings can be deleted
        if ($booking->status !== 'pending') {
            return false;
        }

        // User owns the booking
        if ((string) $user->id === (string) $booking->user_id) {
            return true;
        }

        // Admin can delete
        if ($user->role === 'admin') {
            return true;
        }

        if (method_exists($user, 'hasRole') && $user->hasRole('admin')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can update the booking
     */
    public function update(User $user, RentalBooking $booking): bool
    {
        // Check if user is admin (via column or Spatie role)
        if ($user->role === 'admin') {
            return true;
        }

        if (method_exists($user, 'hasRole') && $user->hasRole('admin')) {
            return true;
        }

        if (method_exists($user, 'hasRole') && $user->hasRole('super_admin')) {
            return true;
        }

        return false;
    }
}
