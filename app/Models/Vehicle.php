<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Vehicle extends Model
{
    use SoftDeletes, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';

    // Override the boot method to generate UUID automatically
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    protected $fillable = [
        'partner_id', 'plate_number', 'brand', 'model', 'year',
        'service_type', 'total_seats', 'daily_rate', 'color', 'vin',
        'registration_number', 'registration_expiry', 'insurance_expiry',
        'tax_expiry', 'photos', 'documents', 'status', 'is_verified', 'average_rating'
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
