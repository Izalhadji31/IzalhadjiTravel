<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'name', 'slug', 'email', 'phone', 'address', 'city', 'province', 'postal_code', 'country',
    'logo_path', 'description', 'subscription_plan', 'max_users', 'max_vehicles',
    'features_tracking', 'features_payment', 'features_analytics', 'monthly_fee',
    'subscription_start_date', 'subscription_end_date', 'status', 'is_verified',
    'verified_at', 'admin_user_id'
])]
class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected function casts(): array
    {
        return [
            'features_tracking' => 'boolean',
            'features_payment' => 'boolean',
            'features_analytics' => 'boolean',
            'is_verified' => 'boolean',
            'monthly_fee' => 'decimal:2',
            'subscription_start_date' => 'datetime',
            'subscription_end_date' => 'datetime',
            'verified_at' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Relationships
     */

    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function mitras(): HasMany
    {
        return $this->hasMany(Mitra::class);
    }

    public function routes(): HasMany
    {
        return $this->hasMany(Route::class);
    }

    public function travelBookings(): HasMany
    {
        return $this->hasMany(TravelBooking::class);
    }

    public function rentalBookings(): HasMany
    {
        return $this->hasMany(RentalBooking::class);
    }

    /**
     * Scopes
     */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeSubscriptionActive($query)
    {
        return $query->where('subscription_end_date', '>=', now())
                    ->whereIn('status', ['active', 'trial']);
    }

    /**
     * Helpers
     */

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    public function isSubscriptionActive(): bool
    {
        return $this->subscription_end_date && $this->subscription_end_date->isFuture();
    }

    public function canAddUser(): bool
    {
        return $this->users()->count() < $this->max_users;
    }

    public function canAddVehicle(): bool
    {
        return $this->mitras()->sum('vehicle_count') < $this->max_vehicles;
    }

    public function suspend(): void
    {
        $this->update(['status' => 'suspended']);
    }

    public function activate(): void
    {
        $this->update(['status' => 'active']);
    }

    public function verify(): void
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }
}
