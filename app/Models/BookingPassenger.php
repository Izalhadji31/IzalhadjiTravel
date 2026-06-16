<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingPassenger extends Model
{
    use HasFactory;

    protected $table = 'booking_passengers';
    
    protected $fillable = [
        'rental_booking_id',
        'name',
        'phone',
        'email',
        'id_type',
        'id_number',
    ];

    public function rentalBooking(): BelongsTo
    {
        return $this->belongsTo(RentalBooking::class);
    }
}
