<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['route_id', 'price_per_seat', 'is_active'])]
class TravelPrice extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected function casts(): array
    {
        return [
            'price_per_seat' => 'decimal:2',
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

    public function getPriceAttribute(): mixed
    {
        return $this->price_per_seat;
    }
}
