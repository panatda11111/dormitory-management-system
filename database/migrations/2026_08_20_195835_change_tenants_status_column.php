<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'id_card',
        'phone',
        'email',
        'room_id',
        'move_in_date',
        'deposit',
        'status',
        'description',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'deposit' => 'decimal:2',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}