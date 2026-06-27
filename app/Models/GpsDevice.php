<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['device_id', 'device_name', 'device_type', 'armada_id', 'api_key', 'is_active', 'last_contact_at', 'settings'])]
class GpsDevice extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'last_contact_at' => 'datetime',
            'settings' => 'array',
            'api_key' => 'hashed',
        ];
    }

    /**
     * Relationships
     */
    public function armada(): BelongsTo
    {
        return $this->belongsTo(Armada::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query): mixed
    {
        return $query->where('is_active', true);
    }

    public function scopeByDevice($query, string $deviceId): mixed
    {
        return $query->where('device_id', $deviceId);
    }

    /**
     * Check if device has recent contact (within given minutes)
     */
    public function isOnline(int $thresholdMinutes = 5): bool
    {
        if (!$this->last_contact_at) {
            return false;
        }
        return $this->last_contact_at->gt(now()->subMinutes($thresholdMinutes));
    }
}
