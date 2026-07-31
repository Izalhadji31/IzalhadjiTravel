<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'type',
        'voucher_type',
        'value',
        'max_discount',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
        'booking_id',
        'booking_type',
        'qr_code',
        'used_at',
        'metadata',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'used_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Relationships
     */
    public function rentalBooking()
    {
        return $this->belongsTo(RentalBooking::class, 'booking_id')->where('booking_type', RentalBooking::class);
    }

    public function travelBooking()
    {
        return $this->belongsTo(TravelBooking::class, 'booking_id')->where('booking_type', TravelBooking::class);
    }

    public function airportTransferBooking()
    {
        return $this->belongsTo(AirportTransferBooking::class, 'booking_id')->where('booking_type', AirportTransferBooking::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->whereDate('valid_from', '<=', now())
            ->whereDate('valid_until', '>=', now());
    }

    public function scopeDiscount($query)
    {
        return $query->where('voucher_type', 'discount');
    }

    public function scopeEVoucher($query)
    {
        return $query->where('voucher_type', 'e-voucher');
    }

    public function scopeUnused($query)
    {
        return $query->where('is_used', false);
    }

    public function scopeUsed($query)
    {
        return $query->where('is_used', true);
    }

    /**
     * Methods
     */
    public function isValid(): bool
    {
        return $this->is_active 
            && now()->isBetween($this->valid_from, $this->valid_until)
            && ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }

    public function isEVoucher(): bool
    {
        return $this->voucher_type === 'e-voucher';
    }

    public function isDiscount(): bool
    {
        return $this->voucher_type === 'discount';
    }

    public function markAsUsed(): void
    {
        $this->update([
            'is_used' => true,
            'used_at' => now(),
            'used_count' => $this->used_count + 1,
        ]);
    }

    /**
     * Generate QR code for e-voucher
     */
    public function generateQRCode(): string
    {
        if (!$this->qr_code) {
            $this->qr_code = 'QR-' . strtoupper(Str::random(16));
            $this->save();
        }
        return $this->qr_code;
    }

    /**
     * Generate unique voucher code
     */
    public static function generateCode(): string
    {
        return 'VC-' . strtoupper(Str::random(8)) . '-' . now()->format('Ymd');
    }

    /**
     * Create e-voucher for booking
     */
    public static function createEVoucher($booking, $validDays = 30): self
    {
        return self::create([
            'code' => self::generateCode(),
            'voucher_type' => 'e-voucher',
            'type' => 'percentage',
            'value' => 0, // No discount for e-voucher
            'valid_from' => now(),
            'valid_until' => now()->addDays($validDays),
            'is_active' => true,
            'is_used' => false,
            'booking_id' => $booking->id,
            'booking_type' => get_class($booking),
            'qr_code' => 'QR-' . strtoupper(Str::random(16)),
            'metadata' => [
                'booking_code' => $booking->booking_code ?? null,
                'customer_name' => $booking->user->name ?? null,
            ],
        ]);
    }
}
