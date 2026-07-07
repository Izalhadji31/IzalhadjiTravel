<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'route_id', 'rental_type', 'with_driver', 'regency_count', 'base_price', 'driver_fee', 'total_price', 'booking_code', 'status', 'start_date', 'end_date', 'start_time', 'assigned_armada_id'])]
class RentalBooking extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'base_price' => 'decimal:2',
            'driver_fee' => 'decimal:2',
            'total_price' => 'decimal:2',
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
        return $query->where('start_date', '>=', now()->date)
                    ->whereIn('status', ['pending', 'confirmed']);
    }

    public function scopeWithDriver($query)
    {
        return $query->where('rental_type', 'with_driver');
    }

    public function scopeWithoutDriver($query)
    {
        return $query->where('rental_type', 'without_driver');
    }

    /**
     * Helper Methods
     */

    public function isWithDriver(): bool
    {
        return $this->rental_type === 'with_driver';
    }

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
