<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'armada_id',
        'rental_booking_id',
        'latitude',
        'longitude',
        'address',
        'speed',
        'heading',
        'accuracy',
        'status',
        'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'speed' => 'decimal:2',
            'heading' => 'decimal:2',
            'accuracy' => 'decimal:2',
            'recorded_at' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function armada(): BelongsTo
    {
        return $this->belongsTo(Armada::class);
    }

    public function rentalBooking(): BelongsTo
    {
        return $this->belongsTo(RentalBooking::class);
    }

    /**
     * Scopes
     */
    public function scopeRecent($query): mixed
    {
        return $query->latest('recorded_at');
    }

    public function scopeByArmada($query, int $armadaId): mixed
    {
        return $query->where('armada_id', $armadaId);
    }

    public function scopeActive($query): mixed
    {
        return $query->where('status', 'active');
    }

    public function scopeInLastHour($query): mixed
    {
        return $query->where('recorded_at', '>=', now()->subHour());
    }

    /**
     * Methods
     */
    public function getDistanceFrom(float $latitude, float $longitude): float
    {
        $lat1 = deg2rad((float)$this->latitude);
        $lon1 = deg2rad((float)$this->longitude);
        $lat2 = deg2rad($latitude);
        $lon2 = deg2rad($longitude);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = 2 * asin(sqrt($a));
        $r = 6371; // Earth radius in km

        return $r * $c;
    }
}
