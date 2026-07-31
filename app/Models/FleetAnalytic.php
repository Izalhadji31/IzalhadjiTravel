<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FleetAnalytic extends Model
{
    use HasFactory;

    protected $table = 'fleet_analytics';

    protected $fillable = [
        'armada_id',
        'date',
        'total_trips',
        'total_distance',
        'total_duration_minutes',
        'total_revenue',
        'fuel_consumption',
        'average_speed',
        'idle_time_minutes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'total_distance' => 'decimal:2',
            'total_revenue' => 'decimal:2',
            'fuel_consumption' => 'decimal:2',
            'average_speed' => 'decimal:2',
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
    public function scopeByArmada($query, $armadaId)
    {
        return $query->where('armada_id', $armadaId);
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Methods
     */
    public function getUtilizationPercentage()
    {
        // Calculate utilization: (active_hours / 24 hours) * 100
        $activeMinutes = $this->total_duration_minutes;
        $utilization = ($activeMinutes / 1440) * 100;
        return round($utilization, 2);
    }

    public function getIdlePercentage()
    {
        return 100 - $this->getUtilizationPercentage();
    }

    public function getRevenuePerKm()
    {
        if ($this->total_distance == 0) return 0;
        return round($this->total_revenue / $this->total_distance, 2);
    }

    public function getFuelEfficiency()
    {
        if ($this->fuel_consumption == 0) return 0;
        return round($this->total_distance / $this->fuel_consumption, 2);
    }
}
