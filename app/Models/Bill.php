<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'room_id',
        'billing_month',
        'rent',
        'water',
        'electricity',
        'other_charge',
        'total',
        'due_date',
        'status',
        'description',
    ];

    protected $casts = [
        'rent' => 'decimal:2',
        'water' => 'decimal:2',
        'electricity' => 'decimal:2',
        'other_charge' => 'decimal:2',
        'total' => 'decimal:2',
        'due_date' => 'date',
    ];

    /**
     * ใบแจ้งค่าใช้จ่ายเป็นของผู้เช่า
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * ใบแจ้งค่าใช้จ่ายเป็นของห้องพัก
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * ใบแจ้งค่าใช้จ่ายมีรายการชำระเงิน
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}