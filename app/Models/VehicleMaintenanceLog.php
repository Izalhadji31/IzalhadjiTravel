<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleMaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'armada_id',
        'maintenance_type',
        'description',
        'cost',
        'maintenance_date',
        'scheduled_next_at',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'cost' => 'decimal:2',
            'maintenance_date' => 'datetime',
            'scheduled_next_at' => 'datetime',
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
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeRecent($query)
    {
        return $query->latest('maintenance_date');
    }

    public function scopeByArmada($query, $armadaId)
    {
        return $query->where('armada_id', $armadaId);
    }

    /**
     * Methods
     */
    public function getMaintenanceTypeBadge()
    {
        return match ($this->maintenance_type) {
            'Oil change' => 'badge-info',
            'Tire rotation' => 'badge-primary',
            'Battery' => 'badge-warning',
            'General inspection' => 'badge-secondary',
            default => 'badge-light'
        };
    }

    public function isOverdue()
    {
        return $this->status === 'scheduled' && $this->scheduled_next_at?->isPast();
    }
}
