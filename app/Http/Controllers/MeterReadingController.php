<?php

namespace App\Http\Controllers;

use App\Models\MeterReading;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Http\Request;

class MeterReadingController extends Controller
{
    /**
     * แสดงรายการมิเตอร์ทั้งหมด
     */
    public function index()
    {
        $meterReadings = MeterReading::with([
            'room',
            'tenant'
        ])
            ->orderByDesc('id')
            ->get();

        return view(
            'meter_readings.index',
            compact('meterReadings')
        );
    }

    /**
     * แสดงหน้าเพิ่มข้อมูลมิเตอร์
     */
    public function create()
    {
        $tenants = Tenant::with('room')
            ->where('status', 'พักอาศัย')
            ->orderBy('name')
            ->get();

        $rooms = Room::orderBy('room_number')
            ->get();

        return view(
            'meter_readings.create',
            compact('tenants', 'rooms')
        );
    }

    /**
     * บันทึกข้อมูลมิเตอร์
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => [
                'required',
                'exists:rooms,id',
            ],

            'tenant_id' => [
                'nullable',
                'exists:tenants,id',
            ],

            'billing_month' => [
                'required',
                'string',
                'max:50',
            ],

            'water_previous' => [
                'required',
                'numeric',
                'min:0',
            ],

            'water_current' => [
                'required',
                'numeric',
                'min:0',
            ],

            'water_rate' => [
                'required',
                'numeric',
                'min:0',
            ],

            'electricity_previous' => [
                'required',
                'numeric',
                'min:0',
            ],

            'electricity_current' => [
                'required',
                'numeric',
                'min:0',
            ],

            'electricity_rate' => [
                'required',
                'numeric',
                'min:0',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ], [
            'room_id.required' =>
                'กรุณาเลือกห้องพัก',

            'room_id.exists' =>
                'ไม่พบข้อมูลห้องพัก',

            'tenant_id.exists' =>
                'ไม่พบข้อมูลผู้เช่า',

            'billing_month.required' =>
                'กรุณาระบุเดือนที่เรียกเก็บเงิน',

            'water_previous.required' =>
                'กรุณาระบุเลขมิเตอร์น้ำครั้งก่อน',

            'water_current.required' =>
                'กรุณาระบุเลขมิเตอร์น้ำครั้งปัจจุบัน',

            'water_rate.required' =>
                'กรุณาระบุอัตราค่าน้ำ',

            'electricity_previous.required' =>
                'กรุณาระบุเลขมิเตอร์ไฟครั้งก่อน',

            'electricity_current.required' =>
                'กรุณาระบุเลขมิเตอร์ไฟครั้งปัจจุบัน',

            'electricity_rate.required' =>
                'กรุณาระบุอัตราค่าไฟ',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ตรวจสอบเลขมิเตอร์
        |--------------------------------------------------------------------------
        */

        if (
            $validated['water_current']
            < $validated['water_previous']
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'water_current' =>
                        'เลขมิเตอร์น้ำครั้งปัจจุบันต้องไม่น้อยกว่าครั้งก่อน',
                ]);
        }

        if (
            $validated['electricity_current']
            < $validated['electricity_previous']
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'electricity_current' =>
                        'เลขมิเตอร์ไฟครั้งปัจจุบันต้องไม่น้อยกว่าครั้งก่อน',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | คำนวณหน่วยที่ใช้
        |--------------------------------------------------------------------------
        */

        $waterUnit =
            $validated['water_current']
            - $validated['water_previous'];

        $electricityUnit =
            $validated['electricity_current']
            - $validated['electricity_previous'];

        /*
        |--------------------------------------------------------------------------
        | คำนวณค่าใช้จ่าย
        |--------------------------------------------------------------------------
        */

        $waterCharge =
            $waterUnit
            * $validated['water_rate'];

        $electricityCharge =
            $electricityUnit
            * $validated['electricity_rate'];

        $totalCharge =
            $waterCharge
            + $electricityCharge;

        /*
        |--------------------------------------------------------------------------
        | บันทึกข้อมูล
        |--------------------------------------------------------------------------
        */

        MeterReading::create([
            'room_id' =>
                $validated['room_id'],

            'tenant_id' =>
                $validated['tenant_id'] ?? null,

            'billing_month' =>
                $validated['billing_month'],

            'water_previous' =>
                $validated['water_previous'],

            'water_current' =>
                $validated['water_current'],

            'water_unit' =>
                $waterUnit,

            'water_rate' =>
                $validated['water_rate'],

            'water_charge' =>
                $waterCharge,

            'electricity_previous' =>
                $validated['electricity_previous'],

            'electricity_current' =>
                $validated['electricity_current'],

            'electricity_unit' =>
                $electricityUnit,

            'electricity_rate' =>
                $validated['electricity_rate'],

            'electricity_charge' =>
                $electricityCharge,

            'total_charge' =>
                $totalCharge,

            'description' =>
                $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('meter-readings.index')
            ->with(
                'success',
                'บันทึกข้อมูลมิเตอร์เรียบร้อยแล้ว'
            );
    }

    /**
     * แสดงข้อมูลมิเตอร์
     */
    public function show(MeterReading $meterReading)
    {
        $meterReading->load([
            'room',
            'tenant'
        ]);

        return view(
            'meter_readings.show',
            compact('meterReading')
        );
    }

    /**
     * แสดงหน้าแก้ไขข้อมูลมิเตอร์
     */
    public function edit(MeterReading $meterReading)
    {
        $tenants = Tenant::with('room')
            ->orderBy('name')
            ->get();

        $rooms = Room::orderBy('room_number')
            ->get();

        return view(
            'meter_readings.edit',
            compact(
                'meterReading',
                'tenants',
                'rooms'
            )
        );
    }

    /**
     * อัปเดตข้อมูลมิเตอร์
     */
    public function update(
        Request $request,
        MeterReading $meterReading
    ) {
        $validated = $request->validate([
            'room_id' => [
                'required',
                'exists:rooms,id',
            ],

            'tenant_id' => [
                'nullable',
                'exists:tenants,id',
            ],

            'billing_month' => [
                'required',
                'string',
                'max:50',
            ],

            'water_previous' => [
                'required',
                'numeric',
                'min:0',
            ],

            'water_current' => [
                'required',
                'numeric',
                'min:0',
            ],

            'water_rate' => [
                'required',
                'numeric',
                'min:0',
            ],

            'electricity_previous' => [
                'required',
                'numeric',
                'min:0',
            ],

            'electricity_current' => [
                'required',
                'numeric',
                'min:0',
            ],

            'electricity_rate' => [
                'required',
                'numeric',
                'min:0',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ], [
            'room_id.required' =>
                'กรุณาเลือกห้องพัก',

            'room_id.exists' =>
                'ไม่พบข้อมูลห้องพัก',

            'tenant_id.exists' =>
                'ไม่พบข้อมูลผู้เช่า',

            'billing_month.required' =>
                'กรุณาระบุเดือนที่เรียกเก็บเงิน',

            'water_previous.required' =>
                'กรุณาระบุเลขมิเตอร์น้ำครั้งก่อน',

            'water_current.required' =>
                'กรุณาระบุเลขมิเตอร์น้ำครั้งปัจจุบัน',

            'water_rate.required' =>
                'กรุณาระบุอัตราค่าน้ำ',

            'electricity_previous.required' =>
                'กรุณาระบุเลขมิเตอร์ไฟครั้งก่อน',

            'electricity_current.required' =>
                'กรุณาระบุเลขมิเตอร์ไฟครั้งปัจจุบัน',

            'electricity_rate.required' =>
                'กรุณาระบุอัตราค่าไฟ',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ตรวจสอบเลขมิเตอร์
        |--------------------------------------------------------------------------
        */

        if (
            $validated['water_current']
            < $validated['water_previous']
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'water_current' =>
                        'เลขมิเตอร์น้ำครั้งปัจจุบันต้องไม่น้อยกว่าครั้งก่อน',
                ]);
        }

        if (
            $validated['electricity_current']
            < $validated['electricity_previous']
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'electricity_current' =>
                        'เลขมิเตอร์ไฟครั้งปัจจุบันต้องไม่น้อยกว่าครั้งก่อน',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | คำนวณหน่วยที่ใช้
        |--------------------------------------------------------------------------
        */

        $waterUnit =
            $validated['water_current']
            - $validated['water_previous'];

        $electricityUnit =
            $validated['electricity_current']
            - $validated['electricity_previous'];

        /*
        |--------------------------------------------------------------------------
        | คำนวณค่าใช้จ่าย
        |--------------------------------------------------------------------------
        */

        $waterCharge =
            $waterUnit
            * $validated['water_rate'];

        $electricityCharge =
            $electricityUnit
            * $validated['electricity_rate'];

        $totalCharge =
            $waterCharge
            + $electricityCharge;

        /*
        |--------------------------------------------------------------------------
        | อัปเดตข้อมูล
        |--------------------------------------------------------------------------
        */

        $meterReading->update([
            'room_id' =>
                $validated['room_id'],

            'tenant_id' =>
                $validated['tenant_id'] ?? null,

            'billing_month' =>
                $validated['billing_month'],

            'water_previous' =>
                $validated['water_previous'],

            'water_current' =>
                $validated['water_current'],

            'water_unit' =>
                $waterUnit,

            'water_rate' =>
                $validated['water_rate'],

            'water_charge' =>
                $waterCharge,

            'electricity_previous' =>
                $validated['electricity_previous'],

            'electricity_current' =>
                $validated['electricity_current'],

            'electricity_unit' =>
                $electricityUnit,

            'electricity_rate' =>
                $validated['electricity_rate'],

            'electricity_charge' =>
                $electricityCharge,

            'total_charge' =>
                $totalCharge,

            'description' =>
                $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('meter-readings.index')
            ->with(
                'success',
                'แก้ไขข้อมูลมิเตอร์เรียบร้อยแล้ว'
            );
    }

    /**
     * ลบข้อมูลมิเตอร์
     */
    public function destroy(MeterReading $meterReading)
    {
        $meterReading->delete();

        return redirect()
            ->route('meter-readings.index')
            ->with(
                'success',
                'ลบข้อมูลมิเตอร์เรียบร้อยแล้ว'
            );
    }
}