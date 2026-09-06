<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
use App\Models\User;

class Tenant extends Model
{
    use HasFactory;

    protected $table = 'tenants';

    protected $fillable = [
        'user_id',
        'name',
        'id_card',
        'phone',
        'email',
        'line_user_id',
        'line_link_code',
        'line_link_code_expires_at',
        'room_id',
        'move_in_date',
        'deposit',
        'status',
        'description',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'deposit' => 'decimal:2',
        'line_link_code_expires_at' => 'datetime',
    ];

    /**
     * บัญชีผู้ใช้ที่เชื่อมกับผู้เช่า
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ห้องพักของผู้เช่า
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}