<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'route_id', 'number_of_seats', 'passenger_count', 'total_price', 'final_price', 'booking_code', 'status', 'payment_status', 'scheduled_date', 'departure_time', 'assigned_armada_id'])]
class TravelBooking extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected function casts(): array
    {
        return [
            'scheduled_date' => 'date',
            'departure_time' => 'datetime',
        ];
    }

    /**
     * Relationships
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function assignedArmada(): BelongsTo
    {
        return $this->belongsTo(Armada::class, 'assigned_armada_id');
    }

    public function armada(): BelongsTo
    {
        return $this->assignedArmada();
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'booking');
    }

    public function passengers(): HasMany
    {
        return $this->hasMany(BookingPassenger::class, 'travel_booking_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'booking_id');
    }

    public function revenueSharings(): MorphMany
    {
        return $this->morphMany(RevenueSharing::class, 'booking');
    }

    /**
     * Scopes
     */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_date', '>=', now()->date)
                    ->whereIn('status', ['pending', 'confirmed']);
    }

    /**
     * Helper Methods
     */

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function confirm(): void
    {
        $this->update(['status' => 'confirmed']);
    }

    public function complete(): void
    {
        $this->update(['status' => 'completed']);
    }

    public function cancel(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    public function getLastPayment(): ?Payment
    {
        return $this->payments()
                   ->where('status', 'success')
                   ->latest()
                   ->first();
    }
}
