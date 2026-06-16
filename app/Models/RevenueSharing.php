<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['booking_id', 'booking_type', 'payment_id', 'mitra_id', 'admin_amount', 'mitra_amount', 'driver_amount', 'admin_percentage', 'mitra_percentage', 'driver_percentage', 'status', 'paid_at'])]
class RevenueSharing extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'admin_amount' => 'decimal:2',
            'mitra_amount' => 'decimal:2',
            'driver_amount' => 'decimal:2',
            'admin_percentage' => 'decimal:2',
            'mitra_percentage' => 'decimal:2',
            'driver_percentage' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    /**
     * Relationships
     */

    public function booking(): MorphTo
    {
        return $this->morphTo();
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function mitra(): BelongsTo
    {
        return $this->belongsTo(Mitra::class);
    }

    /**
     * Scopes
     */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeForMitra($query, $mitraId)
    {
        return $query->where('mitra_id', $mitraId);
    }

    /**
     * Helper Methods
     */

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        // Update mitra total earnings
        $this->mitra->increment('total_earnings', $this->mitra_amount);
    }

    public function getTotalAmount(): float
    {
        return $this->admin_amount + $this->mitra_amount + $this->driver_amount;
    }
}
