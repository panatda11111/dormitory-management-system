<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;

class RoomApiController extends Controller
{
    /**
     * แสดงรายการห้องพักทั้งหมด
     */
    public function index()
    {
        $rooms = Room::orderBy('room_number')->get();

        return response()->json([
            'success' => true,
            'data' => $rooms,
        ]);
    }
}