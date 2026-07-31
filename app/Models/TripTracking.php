<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_booking_id',
        'armada_id',
        'user_id',
        'start_latitude',
        'start_longitude',
        'end_latitude',
        'end_longitude',
        'start_address',
        'end_address',
        'total_distance',
        'average_speed',
        'duration_minutes',
        'start_time',
        'end_time',
        'status',
        'route_polyline',
    ];

    protected function casts(): array
    {
        return [
            'start_latitude' => 'decimal:8',
            'start_longitude' => 'decimal:8',
            'end_latitude' => 'decimal:8',
            'end_longitude' => 'decimal:8',
            'total_distance' => 'decimal:2',
            'average_speed' => 'decimal:2',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function rentalBooking(): BelongsTo
    {
        return $this->belongsTo(RentalBooking::class);
    }

    public function armada(): BelongsTo
    {
        return $this->belongsTo(Armada::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scopes
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByArmada($query, $armadaId)
    {
        return $query->where('armada_id', $armadaId);
    }

    public function scopeByBooking($query, $bookingId)
    {
        return $query->where('rental_booking_id', $bookingId);
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('start_time', [$startDate, $endDate]);
    }

    /**
     * Methods
     */
    public function calculateFuel()
    {
        // Calculate estimated fuel consumption (km per liter)
        $fuelConsumption = $this->total_distance / 8; // Average 8 km per liter
        return round($fuelConsumption, 2);
    }

    public function getDurationFormatted()
    {
        $minutes = $this->duration_minutes;
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        
        return $hours . 'h ' . $mins . 'm';
    }
}
