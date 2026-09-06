<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeterReading extends Model
{
    protected $fillable = [
        'room_id',
        'tenant_id',
        'billing_month',
        'water_previous',
        'water_current',
        'water_unit',
        'water_rate',
        'water_charge',
        'electricity_previous',
        'electricity_current',
        'electricity_unit',
        'electricity_rate',
        'electricity_charge',
        'total_charge',
        'description',
    ];

    protected $casts = [
        'water_previous' => 'decimal:2',
        'water_current' => 'decimal:2',
        'water_unit' => 'decimal:2',
        'water_rate' => 'decimal:2',
        'water_charge' => 'decimal:2',

        'electricity_previous' => 'decimal:2',
        'electricity_current' => 'decimal:2',
        'electricity_unit' => 'decimal:2',
        'electricity_rate' => 'decimal:2',
        'electricity_charge' => 'decimal:2',

        'total_charge' => 'decimal:2',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}