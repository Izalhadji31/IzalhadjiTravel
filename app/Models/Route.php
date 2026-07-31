<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'origin_city', 'destination_city', 'distance_km', 'estimated_hours', 'route_type', 'is_active'])]
class Route extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'distance_km' => 'decimal:2',
            'estimated_hours' => 'decimal:2',
        ];
    }

    /**
     * Relationships
     */

    public function travelPrices(): HasMany
    {
        return $this->hasMany(TravelPrice::class);
    }

    public function rentalPrices(): HasMany
    {
        return $this->hasMany(RentalPrice::class);
    }

    public function travelBookings(): HasMany
    {
        return $this->hasMany(TravelBooking::class);
    }

    public function rentalBookings(): HasMany
    {
        return $this->hasMany(RentalBooking::class);
    }

    /**
     * Scopes
     */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeTravel($query)
    {
        return $query->whereIn('route_type', ['travel', 'both']);
    }

    public function scopeRental($query)
    {
        return $query->whereIn('route_type', ['rental', 'both']);
    }

    public function getOriginAttribute(): ?string
    {
        return $this->origin_city;
    }

    public function getDestinationAttribute(): ?string
    {
        return $this->destination_city;
    }

    public function getDistanceAttribute(): mixed
    {
        return $this->distance_km;
    }

    public function getDurationAttribute(): mixed
    {
        return $this->estimated_hours;
    }

    public function getTypeAttribute(): ?string
    {
        return $this->route_type;
    }

    /**
     * Helper Methods
     */

    public function getTravelPrice(): ?TravelPrice
    {
        return $this->travelPrices()->where('is_active', true)->first();
    }

    public function getRentalPrice(): ?RentalPrice
    {
        return $this->rentalPrices()->where('is_active', true)->first();
    }
}
