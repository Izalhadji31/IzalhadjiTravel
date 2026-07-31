<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Review extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'booking_id',
        'rated_user_id',
        'rating',
        'comment',
        'review_type',
        'is_verified',
        'status',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'status' => 'string',
    ];

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ratedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rated_user_id');
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(TravelBooking::class, 'booking_id');
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Helper methods
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function approve(): void
    {
        $this->update(['status' => 'approved']);
    }

    public function reject(): void
    {
        $this->update(['status' => 'rejected']);
    }
}
