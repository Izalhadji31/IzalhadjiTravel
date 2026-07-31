<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'phone', 'email', 'address', 'city', 'bank_name', 'bank_account', 'bank_holder', 'is_active', 'revenue_share_percentage', 'total_earnings'])]
class Mitra extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'revenue_share_percentage' => 'decimal:2',
            'total_earnings' => 'decimal:2',
        ];
    }

    /**
     * Relationships
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function armadas(): HasMany
    {
        return $this->hasMany(Armada::class);
    }

    public function revenueSharings(): HasMany
    {
        return $this->hasMany(RevenueSharing::class);
    }

    /**
     * Scopes
     */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
