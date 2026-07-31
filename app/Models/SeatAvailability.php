<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class SeatAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'travel_date',
        'armada_id',
        'seat_number',
        'status',
        'locked_by',
        'locked_until',
        'travel_booking_id',
    ];

    protected function casts(): array
    {
        return [
            'travel_date' => 'date',
            'locked_until' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function armada(): BelongsTo
    {
        return $this->belongsTo(Armada::class);
    }

    public function lockedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'locked_by');
    }

    public function travelBooking(): BelongsTo
    {
        return $this->belongsTo(TravelBooking::class);
    }

    /**
     * Scopes
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
                    ->where(function ($q) {
                        $q->whereNull('locked_until')
                          ->orWhere('locked_until', '<', now());
                    });
    }

    public function scopeBooked($query)
    {
        return $query->where('status', 'booked');
    }

    public function scopeLocked($query)
    {
        return $query->where('status', 'locked')
                    ->where('locked_until', '>', now());
    }

    public function scopeForRoute($query, $routeId, $travelDate)
    {
        return $query->where('route_id', $routeId)
                    ->where('travel_date', $travelDate);
    }

    public function scopeForArmada($query, $armadaId)
    {
        return $query->where('armada_id', $armadaId);
    }

    /**
     * Check if seat is available for booking
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available' && 
               ($this->locked_until === null || $this->locked_until->isPast());
    }

    /**
     * Check if seat is locked by current user
     */
    public function isLockedByUser($userId): bool
    {
        return $this->status === 'locked' && 
               $this->locked_by === $userId && 
               $this->locked_until && 
               $this->locked_until->isFuture();
    }

    /**
     * Lock seat for temporary hold
     */
    public function lockSeat($userId, $minutes = 15): bool
    {
        if (!$this->isAvailable()) {
            return false;
        }

        $this->update([
            'status' => 'locked',
            'locked_by' => $userId,
            'locked_until' => now()->addMinutes($minutes),
        ]);

        // Clear cache for this route/date
        $this->clearAvailabilityCache();

        return true;
    }

    /**
     * Unlock seat
     */
    public function unlockSeat(): bool
    {
        if ($this->status !== 'locked') {
            return false;
        }

        $this->update([
            'status' => 'available',
            'locked_by' => null,
            'locked_until' => null,
        ]);

        // Clear cache for this route/date
        $this->clearAvailabilityCache();

        return true;
    }

    /**
     * Book seat
     */
    public function bookSeat($travelBookingId): bool
    {
        if (!$this->isAvailable() && !$this->isLockedByUser($travelBookingId)) {
            return false;
        }

        $this->update([
            'status' => 'booked',
            'locked_by' => null,
            'locked_until' => null,
            'travel_booking_id' => $travelBookingId,
        ]);

        // Clear cache for this route/date
        $this->clearAvailabilityCache();

        return true;
    }

    /**
     * Release expired locks
     */
    public static function releaseExpiredLocks(): int
    {
        $released = static::where('status', 'locked')
                          ->where('locked_until', '<', now())
                          ->update([
                              'status' => 'available',
                              'locked_by' => null,
                              'locked_until' => null,
                          ]);

        if ($released > 0) {
            Cache::flush(); // Clear all cache when releasing locks
        }

        return $released;
    }

    /**
     * Get available seats for route and date
     */
    public static function getAvailableSeats($routeId, $travelDate, $armadaId = null): array
    {
        $cacheKey = "seat_availability_{$routeId}_{$travelDate}_{$armadaId}";
        
        return Cache::remember($cacheKey, 300, function () use ($routeId, $travelDate, $armadaId) {
            $query = static::forRoute($routeId, $travelDate);
            
            if ($armadaId) {
                $query->forArmada($armadaId);
            }
            
            return $query->available()->pluck('seat_number')->toArray();
        });
    }

    /**
     * Get booked seats for route and date
     */
    public static function getBookedSeats($routeId, $travelDate, $armadaId = null): array
    {
        $cacheKey = "seat_booked_{$routeId}_{$travelDate}_{$armadaId}";
        
        return Cache::remember($cacheKey, 300, function () use ($routeId, $travelDate, $armadaId) {
            $query = static::forRoute($routeId, $travelDate);
            
            if ($armadaId) {
                $query->forArmada($armadaId);
            }
            
            return $query->booked()->pluck('seat_number')->toArray();
        });
    }

    /**
     * Get locked seats for route and date
     */
    public static function getLockedSeats($routeId, $travelDate, $armadaId = null): array
    {
        $cacheKey = "seat_locked_{$routeId}_{$travelDate}_{$armadaId}";
        
        return Cache::remember($cacheKey, 60, function () use ($routeId, $travelDate, $armadaId) {
            $query = static::forRoute($routeId, $travelDate);
            
            if ($armadaId) {
                $query->forArmada($armadaId);
            }
            
            return $query->locked()->pluck('seat_number')->toArray();
        });
    }

    /**
     * Initialize seat availability for a new trip
     */
    public static function initializeSeats($routeId, $travelDate, $armadaId, $totalSeats = 6): void
    {
        for ($seatNumber = 1; $seatNumber <= $totalSeats; $seatNumber++) {
            self::create([
                'route_id' => $routeId,
                'travel_date' => $travelDate,
                'armada_id' => $armadaId,
                'seat_number' => $seatNumber,
                'status' => 'available',
            ]);
        }

        // Clear cache for this route/date
        Cache::forget("seat_availability_{$routeId}_{$travelDate}_{$armadaId}");
    }

    /**
     * Clear availability cache for this seat's route/date
     */
    protected function clearAvailabilityCache(): void
    {
        $patterns = [
            "seat_availability_{$this->route_id}_{$this->travel_date}_*",
            "seat_booked_{$this->route_id}_{$this->travel_date}_*",
            "seat_locked_{$this->route_id}_{$this->travel_date}_*",
        ];

        foreach ($patterns as $pattern) {
            // This is a simplified cache clearing - in production you might want a more sophisticated approach
            Cache::forget(str_replace('*', $this->armada_id ?? 'null', $pattern));
        }
    }
}
