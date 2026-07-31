<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['rental_booking_id', 'addon_id', 'quantity', 'price_at_booking'])]
class RentalBookingAddon extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'price_at_booking' => 'decimal:2',
        ];
    }

    /**
     * Relationships
     */
    public function rentalBooking(): BelongsTo
    {
        return $this->belongsTo(RentalBooking::class, 'rental_booking_id');
    }

    public function addon(): BelongsTo
    {
        return $this->belongsTo(Addon::class, 'addon_id');
    }

    /**
     * Helper Methods
     */
    public function getTotalPrice(): float
    {
        return $this->price_at_booking * $this->quantity;
    }
}
