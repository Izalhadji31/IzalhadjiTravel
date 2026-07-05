<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'user_id', 'company_id', 'booking_code', 'pickup_location', 'dropoff_location',
    'pickup_latitude', 'pickup_longitude', 'dropoff_latitude', 'dropoff_longitude',
    'scheduled_date', 'departure_time', 'number_of_passengers', 'transfer_type',
    'return_date', 'assigned_armada_id', 'assigned_driver_id', 'base_price',
    'total_price', 'discount', 'voucher_id', 'status', 'special_requests', 'notes',
    'trip_tracking_id', 'actual_pickup_time', 'actual_dropoff_time',
    'passenger_name', 'passenger_phone', 'flight_number', 'airline', 'flight_arrival_time'
])]
class AirportTransferBooking extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected function casts(): array
    {
        return [
            'scheduled_date' => 'datetime',
            'departure_time' => 'datetime',
            'return_date' => 'datetime',
            'flight_arrival_time' => 'datetime',
            'actual_pickup_time' => 'datetime',
            'actual_dropoff_time' => 'datetime',
            'base_price' => 'decimal:2',
            'total_price' => 'decimal:2',
            'discount' => 'decimal:2',
            'pickup_latitude' => 'decimal:8',
            'pickup_longitude' => 'decimal:8',
            'dropoff_latitude' => 'decimal:8',
            'dropoff_longitude' => 'decimal:8',
        ];
    }

    /**
     * Relationships
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function assignedArmada(): BelongsTo
    {
        return $this->belongsTo(Armada::class, 'assigned_armada_id');
    }

    public function assignedDriver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'assigned_driver_id');
    }

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }

    public function tripTracking(): BelongsTo
    {
        return $this->belongsTo(TripTracking::class);
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'booking');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
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
        return $query->where('status', 'confirmed')->where('scheduled_date', '>', now());
    }

    public function scopeToday($query)
    {
        return $query->whereDate('scheduled_date', today());
    }

    /**
     * Methods
     */

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isRoundTrip(): bool
    {
        return $this->transfer_type === 'round_trip';
    }

    public function calculateFinalPrice(): float
    {
        return $this->total_price - $this->discount;
    }
};
