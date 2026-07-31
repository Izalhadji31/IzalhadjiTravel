<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Str;

#[Fillable(['user_id', 'route_id', 'vehicle_id', 'rental_type', 'regency_count', 'base_price', 'driver_fee', 'total_price', 'booking_code', 'status', 'start_date', 'start_time', 'end_date', 'end_time', 'assigned_armada_id', 'pickup_city', 'dropoff_city', 'pickup_location', 'dropoff_location', 'pickup_address', 'dropoff_address', 'pickup_lat', 'pickup_lng', 'dropoff_lat', 'dropoff_lng', 'vehicle_type_id', 'special_requests', 'is_for_guest', 'guest_name', 'guest_phone', 'guest_email', 'voucher_code', 'installment_months', 'pickup_instructions', 'driver_name', 'driver_phone', 'estimated_distance_km', 'voucher_id'])]
class RentalBooking extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'base_price' => 'decimal:2',
            'driver_fee' => 'decimal:2',
            'total_price' => 'decimal:2',
            'pickup_lat' => 'decimal:8',
            'pickup_lng' => 'decimal:8',
            'dropoff_lat' => 'decimal:8',
            'dropoff_lng' => 'decimal:8',
            'is_for_guest' => 'boolean',
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

    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }

    public function addons(): HasMany
    {
        return $this->hasMany(RentalBookingAddon::class, 'rental_booking_id');
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

    /**
     * Calculate duration in hours
     */
    public function getDurationInHours(): int
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }

        $start = $this->start_date->setTimeFromTimeString($this->start_time ?? '00:00');
        $end = $this->end_date->setTimeFromTimeString($this->end_time ?? '00:00');

        return $start->diffInHours($end);
    }

    /**
     * Calculate duration in days
     */
    public function getDurationInDays(): int
    {
        $hours = $this->getDurationInHours();
        return ceil($hours / 24);
    }

    /**
     * Check if booking is for guest
     */
    public function isGuestBooking(): bool
    {
        return $this->is_for_guest === true;
    }

    /**
     * Get pickup datetime
     */
    public function getPickupDatetime(): ?\Carbon\Carbon
    {
        if (!$this->start_date || !$this->start_time) {
            return null;
        }

        return $this->start_date->setTimeFromTimeString($this->start_time);
    }

    /**
     * Get dropoff datetime
     */
    public function getDropoffDatetime(): ?\Carbon\Carbon
    {
        if (!$this->end_date || !$this->end_time) {
            return null;
        }

        return $this->end_date->setTimeFromTimeString($this->end_time);
    }

    /**
     * Check if same-day booking
     */
    public function isSameDayBooking(): bool
    {
        if (!$this->start_date || !$this->end_date) {
            return false;
        }

        return $this->start_date->isSameDay($this->end_date);
    }

    /**
     * Check if booking is within 12 hours (same-day restriction)
     */
    public function isWithin12Hours(): bool
    {
        $pickup = $this->getPickupDatetime();
        if (!$pickup) {
            return false;
        }

        return $pickup->diffInHours(now()) < 12;
    }

    /**
     * Generate unique voucher code
     */
    public static function generateVoucherCode(): string
    {
        return 'RNT-' . strtoupper(Str::random(8)) . '-' . now()->format('Ymd');
    }
}
