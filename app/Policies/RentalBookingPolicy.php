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
        return $user->id === $booking->user_id || $user->role === 'admin';
    }

    /**
     * Determine if the user can delete the booking
     */
    public function delete(User $user, RentalBooking $booking): bool
    {
        return ($user->id === $booking->user_id || $user->role === 'admin') 
               && $booking->status === 'pending';
    }

    /**
     * Determine if the user can update the booking
     */
    public function update(User $user, RentalBooking $booking): bool
    {
        return $user->role === 'admin';
    }
}
