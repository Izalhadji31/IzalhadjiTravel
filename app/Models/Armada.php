<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['mitra_id', 'driver_name', 'driver_phone', 'plate_number', 'vehicle_type', 'seat_capacity', 'status', 'purchase_date', 'last_maintenance_date'])]
class Armada extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'last_maintenance_date' => 'date',
        ];
    }

    /**
     * Relationships
     */

    public function mitra(): BelongsTo
    {
        return $this->belongsTo(Mitra::class);
    }

    public function travelAssignments(): HasMany
    {
        return $this->hasMany(TravelBooking::class, 'assigned_armada_id');
    }

    public function rentalAssignments(): HasMany
    {
        return $this->hasMany(RentalBooking::class, 'assigned_armada_id');
    }

    /**
     * Scopes
     */

    public function scopeAvailable($query)
    {
        return $query->where('status', 'tersedia');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'maintenance');
    }

    /**
     * Helper Methods
     */

    public function isAvailable(): bool
    {
        return $this->status === 'tersedia';
    }

    public function setToJalan(): void
    {
        $this->update(['status' => 'jalan']);
    }

    public function setToAvailable(): void
    {
        $this->update(['status' => 'tersedia']);
    }

    public function setToMaintenance(): void
    {
        $this->update(['status' => 'maintenance']);
    }
}
