<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * แสดงรายการห้องพัก
     */
    public function index()
    {
        $rooms = Room::orderBy('room_number')->get();

        return view('rooms.index', compact('rooms'));
    }

    /**
     * แสดงหน้าเพิ่มห้องพัก
     */
    public function create()
    {
        return view('rooms.create');
    }

    /**
     * บันทึกห้องพัก
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number',
            'floor' => 'nullable|string|max:255',
            'room_type' => 'required|string|max:255',
            'rent' => 'required|numeric|min:0',
            'status' => 'required|in:ว่าง,มีผู้เช่า,จอง,ซ่อมแซม',
            'description' => 'nullable|string',
        ], [
            'room_number.required' => 'กรุณากรอกเลขห้อง',
            'room_number.unique' => 'เลขห้องนี้มีอยู่แล้ว',
            'rent.required' => 'กรุณากรอกค่าเช่า',
            'rent.numeric' => 'ค่าเช่าต้องเป็นตัวเลข',
        ]);

        Room::create($validated);

        return redirect()
            ->route('rooms.index')
            ->with('success', 'เพิ่มห้องพักเรียบร้อยแล้ว');
    }

    /**
     * แสดงข้อมูลห้องพัก
     */
    public function show(string $id)
    {
        $room = Room::findOrFail($id);

        return view('rooms.show', compact('room'));
    }

    /**
     * แสดงหน้าแก้ไขห้องพัก
     */
    public function edit(string $id)
    {
        $room = Room::findOrFail($id);

        return view('rooms.edit', compact('room'));
    }

    /**
     * อัปเดตข้อมูลห้องพัก
     */
    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
            'floor' => 'nullable|string|max:255',
            'room_type' => 'required|string|max:255',
            'rent' => 'required|numeric|min:0',
            'status' => 'required|in:ว่าง,มีผู้เช่า,จอง,ซ่อมแซม',
            'description' => 'nullable|string',
        ]);

        $room->update($validated);

        return redirect()
            ->route('rooms.index')
            ->with('success', 'แก้ไขข้อมูลห้องพักเรียบร้อยแล้ว');
    }

    /**
     * ลบห้องพัก
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);

        $room->delete();

        return redirect()
            ->route('rooms.index')
            ->with('success', 'ลบห้องพักเรียบร้อยแล้ว');
    }
}