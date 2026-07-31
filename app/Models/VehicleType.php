<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'slug', 'capacity', 'base_price_multiplier', 'icon', 'description', 'image_url', 'is_active', 'sort_order'])]
class VehicleType extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'base_price_multiplier' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function rentalBookings(): HasMany
    {
        return $this->hasMany(RentalBooking::class, 'vehicle_type_id');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Helper Methods
     */
    public function calculatePrice(float $basePrice): float
    {
        return $basePrice * $this->base_price_multiplier;
    }
}
