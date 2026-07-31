<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['category_id', 'name', 'slug', 'description', 'pricing_type', 'price', 'icon', 'image_url', 'is_active', 'sort_order', 'metadata'])]
class Addon extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'metadata' => 'array',
        ];
    }

    /**
     * Relationships
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(AddonCategory::class, 'category_id');
    }

    public function rentalBookings(): HasMany
    {
        return $this->hasMany(RentalBookingAddon::class, 'addon_id');
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

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Helper Methods
     */
    public function calculatePrice(int $days = 1): float
    {
        return match ($this->pricing_type) {
            'daily' => $this->price * $days,
            'fixed' => $this->price,
            'percentage' => $this->price, // Will be calculated on booking total
            default => $this->price,
        };
    }

    public function isDailyPricing(): bool
    {
        return $this->pricing_type === 'daily';
    }

    public function isFixedPricing(): bool
    {
        return $this->pricing_type === 'fixed';
    }

    public function isPercentagePricing(): bool
    {
        return $this->pricing_type === 'percentage';
    }
}
