<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'partner_id', 'plate_number', 'brand', 'model', 'year',
        'service_type', 'total_seats', 'daily_rate', 'color', 'vin',
        'registration_number', 'registration_expiry', 'insurance_expiry',
        'tax_expiry', 'photos', 'documents', 'status', 'is_verified'
    ];

    protected $casts = [
        'daily_rate' => 'float',
        'photos' => 'array',
        'documents' => 'array',
        'is_verified' => 'boolean',
        'average_rating' => 'float',
        'registration_expiry' => 'date',
        'insurance_expiry' => 'date',
        'tax_expiry' => 'date',
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function travelBookings(): HasMany
    {
        return $this->hasMany(TravelBooking::class);
    }

    public function rentalBookings(): HasMany
    {
        return $this->hasMany(RentalBooking::class);
    }
}
