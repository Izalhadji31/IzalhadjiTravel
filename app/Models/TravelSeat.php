<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TravelSeat extends Model
{
    use HasFactory;

    protected $table = 'travel_seats';
    
    protected $fillable = [
        'travel_booking_id',
        'seat_number',
        'status',
        'passenger_id',
        'passenger_name',
        'passenger_phone',
    ];

    public function travelBooking(): BelongsTo
    {
        return $this->belongsTo(TravelBooking::class);
    }

    public function passenger(): BelongsTo
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }
}
