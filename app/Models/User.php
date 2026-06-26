<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'phone', 'role', 'is_verified', 'is_identity_verified'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasUuids, Notifiable, HasRoles;

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    public function getIsIdentityVerifiedAttribute(): bool
    {
        return (bool) $this->is_verified;
    }

    public function setIsIdentityVerifiedAttribute(bool $value): void
    {
        $this->attributes['is_verified'] = $value;
    }

    /**
     * Relationships
     */
    
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function identityVerification(): HasOne
    {
        return $this->hasOne(IdentityVerification::class);
    }

    public function travelBookings(): HasMany
    {
        return $this->hasMany(TravelBooking::class);
    }

    public function rentalBookings(): HasMany
    {
        return $this->hasMany(RentalBooking::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function verifiedIdentities(): HasMany
    {
        return $this->hasMany(IdentityVerification::class, 'verified_by');
    }

    public function partnerProfile(): HasOne
    {
        return $this->hasOne(Mitra::class, 'email', 'email');
    }

    public function driverProfile(): HasOne
    {
        return $this->hasOne(Driver::class, 'user_id');
    }

    public function armada(): HasOne
    {
        return $this->hasOne(Armada::class, 'driver_phone', 'phone');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Helper Methods
     */

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPartner(): bool
    {
        return $this->role === 'partner';
    }

    public function isDriver(): bool
    {
        return $this->role === 'driver';
    }

    public function canBook(): bool
    {
        return $this->is_identity_verified && in_array($this->role, ['customer', 'partner']);
    }
}
