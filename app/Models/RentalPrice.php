<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['route_id', 'price_without_driver', 'driver_fee_per_regency', 'is_active'])]
class RentalPrice extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'price_without_driver' => 'decimal:2',
            'driver_fee_per_regency' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relationships
     */

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    /**
     * Scopes
     */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getVehicleTypeAttribute(): string
    {
        return $this->route?->route_type === 'rental' ? 'Rental' : 'Travel/Rental';
    }

    public function getPriceWithDriverAttribute(): mixed
    {
        return $this->price_without_driver + $this->driver_fee_per_regency;
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->route?->description;
    }
}
