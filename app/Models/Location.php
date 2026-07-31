<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name', 'city', 'province', 'latitude', 'longitude',
        'address', 'postal_code', 'type', 'is_active'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'is_active' => 'boolean',
    ];

    public function fromRoutes(): HasMany
    {
        return $this->hasMany(Route::class, 'from_location_id');
    }

    public function toRoutes(): HasMany
    {
        return $this->hasMany(Route::class, 'to_location_id');
    }
}
