<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Room;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    /**
     * แสดงรายการผู้เช่า
     */
    public function index()
    {
        $tenants = Tenant::with('room')
            ->orderBy('name')
            ->get();

        return view('tenants.index', compact('tenants'));
    }

    /**
     * แสดงฟอร์มเพิ่มผู้เช่า
     */
    public function create()
    {
        // แสดงเฉพาะห้องที่มีสถานะ "ว่าง"
        $rooms = Room::where('status', 'ว่าง')
            ->orderBy('room_number')
            ->get();

        return view('tenants.create', compact('rooms'));
    }

    /**
     * บันทึกข้อมูลผู้เช่า
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            // เลขบัตรประชาชน 13 หลัก และห้ามซ้ำ
            'id_card' => 'required|digits:13|unique:tenants,id_card',

            'phone' => 'required|string|max:20',

            'email' => 'nullable|email|max:255',

            'room_id' => 'required|exists:rooms,id',

            'move_in_date' => 'required|date',

            'deposit' => 'required|numeric|min:0',

            'status' => 'required|in:พักอาศัย,ย้ายออก',

            'description' => 'nullable|string',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ตรวจสอบว่าห้องยังว่างอยู่หรือไม่
        |--------------------------------------------------------------------------
        */

        $room = Room::findOrFail($request->room_id);

        if ($room->status !== 'ว่าง') {

            return back()
                ->withInput()
                ->withErrors([
                    'room_id' => 'ห้องนี้ไม่ว่างแล้ว กรุณาเลือกห้องอื่น'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | บันทึกข้อมูลผู้เช่า
        |--------------------------------------------------------------------------
        */

        $tenant = Tenant::create($validated);

        /*
        |--------------------------------------------------------------------------
        | ถ้าผู้เช่าพักอาศัย ให้เปลี่ยนสถานะห้อง
        |--------------------------------------------------------------------------
        */

        if ($request->status === 'พักอาศัย') {

            $room->update([
                'status' => 'มีผู้เช่า'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | กลับไปหน้ารายการผู้เช่า
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('tenants.index')
            ->with('success', 'เพิ่มข้อมูลผู้เช่าเรียบร้อยแล้ว');
    }

    /**
     * แสดงข้อมูลผู้เช่า
     */
    public function show(string $id)
    {
        $tenant = Tenant::with('room')
            ->findOrFail($id);

        return view('tenants.show', compact('tenant'));
    }

    /**
     * แสดงหน้าแก้ไขผู้เช่า
     */
    public function edit(string $id)
    {
        $tenant = Tenant::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | แสดงห้องทั้งหมดในหน้าแก้ไข
        | เพื่อให้ผู้เช่าสามารถอยู่ห้องเดิมได้
        |--------------------------------------------------------------------------
        */

        $rooms = Room::orderBy('room_number')
            ->get();

        return view('tenants.edit', compact('tenant', 'rooms'));
    }

    /**
     * อัปเดตข้อมูลผู้เช่า
     */
    public function update(Request $request, string $id)
    {
        $tenant = Tenant::findOrFail($id);

        // จำห้องเดิมไว้ก่อน
        $oldRoomId = $tenant->room_id;

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            // ห้ามซ้ำกับผู้เช่าคนอื่น
            'id_card' => 'required|digits:13|unique:tenants,id_card,' . $id,

            'phone' => 'required|string|max:20',

            'email' => 'nullable|email|max:255',

            'room_id' => 'required|exists:rooms,id',

            'move_in_date' => 'required|date',

            'deposit' => 'required|numeric|min:0',

            'status' => 'required|in:พักอาศัย,ย้ายออก',

            'description' => 'nullable|string',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ตรวจสอบห้องใหม่
        |--------------------------------------------------------------------------
        */

        $newRoom = Room::findOrFail($request->room_id);

        /*
        | ถ้าเปลี่ยนไปห้องอื่น
        | ห้องใหม่ต้องว่าง
        */

        if (
            $oldRoomId != $request->room_id &&
            $newRoom->status !== 'ว่าง'
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'room_id' => 'ห้องที่เลือกไม่ว่างแล้ว กรุณาเลือกห้องอื่น'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | อัปเดตข้อมูลผู้เช่า
        |--------------------------------------------------------------------------
        */

        $tenant->update($validated);

        /*
        |--------------------------------------------------------------------------
        | ถ้าเปลี่ยนห้อง
        | ห้องเก่ากลับเป็นว่าง
        |--------------------------------------------------------------------------
        */

        if ($oldRoomId != $request->room_id) {

            Room::where('id', $oldRoomId)
                ->update([
                    'status' => 'ว่าง'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | อัปเดตสถานะห้องใหม่
        |--------------------------------------------------------------------------
        */

        if ($request->status === 'พักอาศัย') {

            $newRoom->update([
                'status' => 'มีผู้เช่า'
            ]);

        } else {

            $newRoom->update([
                'status' => 'ว่าง'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | กลับหน้ารายการ
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('tenants.index')
            ->with('success', 'แก้ไขข้อมูลผู้เช่าเรียบร้อยแล้ว');
    }

    /**
     * ลบผู้เช่า
     */
    public function destroy(string $id)
    {
        $tenant = Tenant::findOrFail($id);

        $roomId = $tenant->room_id;

        /*
        |--------------------------------------------------------------------------
        | ลบผู้เช่า
        |--------------------------------------------------------------------------
        */

        $tenant->delete();

        /*
        |--------------------------------------------------------------------------
        | หลังลบผู้เช่า ให้ห้องกลับเป็นว่าง
        |--------------------------------------------------------------------------
        */

        if ($roomId) {

            // ตรวจสอบว่ายังมีผู้เช่าคนอื่นอยู่ในห้องนี้หรือไม่
            $otherTenant = Tenant::where('room_id', $roomId)
                ->where('status', 'พักอาศัย')
                ->exists();

            if (!$otherTenant) {

                Room::where('id', $roomId)
                    ->update([
                        'status' => 'ว่าง'
                    ]);
            }
        }

        return redirect()
            ->route('tenants.index')
            ->with('success', 'ลบข้อมูลผู้เช่าเรียบร้อยแล้ว');
    }
}