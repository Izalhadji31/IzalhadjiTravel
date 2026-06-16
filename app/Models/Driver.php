<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'sim_number',
        'sim_expiry',
        'address',
        'photo',
        'status',
        'rating',
        'total_trips',
        'balance',
        'partner_id',
        'last_seen_at',
    ];

    protected function casts(): array
    {
        return [
            'sim_expiry' => 'date',
            'rating' => 'float',
            'balance' => 'decimal:2',
            'last_seen_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Mitra::class, 'partner_id');
    }

    public function armada(): HasOne
    {
        return $this->hasOne(Armada::class, 'driver_phone', 'phone');
    }

    public function trips(): HasMany
    {
        return $this->hasMany(TripTracking::class);
    }
}
