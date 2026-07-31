<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'armada_id',
        'driver_name',
        'driver_phone',
        'latitude',
        'longitude',
        'status',
        'current_activity',
        'total_trips',
        'total_earnings',
        'rating',
        'last_online_at',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'total_earnings' => 'decimal:2',
            'rating' => 'decimal:2',
            'last_online_at' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function armada(): BelongsTo
    {
        return $this->belongsTo(Armada::class);
    }

    /**
     * Scopes
     */
    public function scopeOnline($query)
    {
        return $query->whereIn('status', ['available', 'on_trip']);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeOnTrip($query)
    {
        return $query->where('status', 'on_trip');
    }

    public function scopeRecentlyOnline($query)
    {
        return $query->where('last_online_at', '>=', now()->subHour());
    }

    public function scopeByRating($query, $minRating = 4.5)
    {
        return $query->where('rating', '>=', $minRating);
    }

    /**
     * Methods
     */
    public function isOnline()
    {
        return $this->status !== 'offline' && 
               $this->last_online_at?->isAfter(now()->subMinutes(5));
    }

    public function getStatusBadge()
    {
        return match ($this->status) {
            'available' => 'badge-success',
            'on_trip' => 'badge-primary',
            'offline' => 'badge-secondary',
            'on_break' => 'badge-warning',
            default => 'badge-secondary'
        };
    }

    public function getEarningsToday()
    {
        // Calculate earnings for today
        return $this->total_earnings; // Simplified - should calculate from trips today
    }
}
