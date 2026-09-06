<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Tenant;
use App\Models\Room;
use App\Models\MeterReading;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * แสดงรายการบิล
     */
    public function index()
    {
        $bills = Bill::with([
            'tenant',
            'room'
        ])
            ->orderByDesc('due_date')
            ->get();

        return view(
            'bills.index',
            compact('bills')
        );
    }


    /**
     * แสดงหน้าเพิ่มบิล
     */
    public function create()
    {
        $tenants = Tenant::with('room')
            ->where('status', 'พักอาศัย')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | โหลดข้อมูลมิเตอร์ทั้งหมดเพื่อใช้ในหน้าเพิ่มบิล
        |--------------------------------------------------------------------------
        */

        $meterReadings = MeterReading::with([
            'tenant',
            'room'
        ])
            ->orderByDesc('created_at')
            ->get();

        return view(
            'bills.create',
            compact(
                'tenants',
                'meterReadings'
            )
        );
    }


    /**
     * บันทึกบิล
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => [
                'required',
                'exists:tenants,id'
            ],

            'room_id' => [
                'required',
                'exists:rooms,id'
            ],

            'billing_month' => [
                'required',
                'string',
                'max:50'
            ],

            'rent' => [
                'required',
                'numeric',
                'min:0'
            ],

            'water' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'electricity' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'other_charge' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'due_date' => [
                'required',
                'date'
            ],

            'status' => [
                'required',
                'in:ค้างชำระ,ชำระแล้ว,เกินกำหนด'
            ],

            'description' => [
                'nullable',
                'string'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | ตรวจสอบว่าผู้เช่าอยู่ห้องที่เลือกจริง
        |--------------------------------------------------------------------------
        */

        $tenant = Tenant::findOrFail(
            $validated['tenant_id']
        );

        if ((int) $tenant->room_id !== (int) $validated['room_id']) {

            return back()
                ->withInput()
                ->withErrors([
                    'room_id' =>
                        'ห้องพักไม่ตรงกับห้องของผู้เช่าที่เลือก'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | ดึงข้อมูลมิเตอร์ของผู้เช่า + ห้อง + เดือน
        |--------------------------------------------------------------------------
        */

        $meterReading = MeterReading::where(
                'tenant_id',
                $validated['tenant_id']
            )
            ->where(
                'room_id',
                $validated['room_id']
            )
            ->where(
                'billing_month',
                $validated['billing_month']
            )
            ->latest('id')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | ถ้ามีมิเตอร์ ให้ใช้ค่าน้ำและค่าไฟจากมิเตอร์
        |--------------------------------------------------------------------------
        */

        if ($meterReading) {

            $validated['water'] =
                (float) $meterReading->water_charge;

            $validated['electricity'] =
                (float) $meterReading->electricity_charge;

        } else {

            /*
            |--------------------------------------------------------------------------
            | ถ้าไม่มีมิเตอร์ ใช้ค่าจากฟอร์ม
            |--------------------------------------------------------------------------
            */

            $validated['water'] =
                $validated['water'] ?? 0;

            $validated['electricity'] =
                $validated['electricity'] ?? 0;
        }


        /*
        |--------------------------------------------------------------------------
        | ค่าใช้จ่ายอื่น
        |--------------------------------------------------------------------------
        */

        $validated['other_charge'] =
            $validated['other_charge'] ?? 0;


        /*
        |--------------------------------------------------------------------------
        | คำนวณยอดรวม
        |--------------------------------------------------------------------------
        */

        $validated['total'] =
            (float) $validated['rent']
            +
            (float) $validated['water']
            +
            (float) $validated['electricity']
            +
            (float) $validated['other_charge'];


        /*
        |--------------------------------------------------------------------------
        | ป้องกันสร้างบิลซ้ำ
        |--------------------------------------------------------------------------
        */

        $duplicateBill = Bill::where(
                'tenant_id',
                $validated['tenant_id']
            )
            ->where(
                'room_id',
                $validated['room_id']
            )
            ->where(
                'billing_month',
                $validated['billing_month']
            )
            ->exists();

        if ($duplicateBill) {

            return back()
                ->withInput()
                ->withErrors([
                    'billing_month' =>
                        'ผู้เช่ารายนี้มีใบแจ้งค่าใช้จ่ายของเดือนนี้แล้ว'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | บันทึกบิล
        |--------------------------------------------------------------------------
        */

        Bill::create($validated);


        /*
        |--------------------------------------------------------------------------
        | กลับหน้ารายการ
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('bills.index')
            ->with(
                'success',
                'สร้างใบแจ้งค่าใช้จ่ายเรียบร้อยแล้ว'
            );
    }


    /**
     * แสดงรายละเอียดบิล
     */
    public function show(string $id)
    {
        $bill = Bill::with([
            'tenant',
            'room'
        ])
            ->findOrFail($id);

        return view(
            'bills.show',
            compact('bill')
        );
    }


    /**
     * แสดงหน้าแก้ไขบิล
     */
    public function edit(string $id)
    {
        $bill = Bill::findOrFail($id);

        $tenants = Tenant::with('room')
            ->where('status', 'พักอาศัย')
            ->orderBy('name')
            ->get();

        $meterReadings = MeterReading::with([
            'tenant',
            'room'
        ])
            ->orderByDesc('created_at')
            ->get();

        return view(
            'bills.edit',
            compact(
                'bill',
                'tenants',
                'meterReadings'
            )
        );
    }


    /**
     * อัปเดตบิล
     */
    public function update(
        Request $request,
        string $id
    ) {
        $bill = Bill::findOrFail($id);


        $validated = $request->validate([
            'tenant_id' => [
                'required',
                'exists:tenants,id'
            ],

            'room_id' => [
                'required',
                'exists:rooms,id'
            ],

            'billing_month' => [
                'required',
                'string',
                'max:50'
            ],

            'rent' => [
                'required',
                'numeric',
                'min:0'
            ],

            'water' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'electricity' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'other_charge' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'due_date' => [
                'required',
                'date'
            ],

            'status' => [
                'required',
                'in:ค้างชำระ,ชำระแล้ว,เกินกำหนด'
            ],

            'description' => [
                'nullable',
                'string'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | ตรวจสอบผู้เช่ากับห้อง
        |--------------------------------------------------------------------------
        */

        $tenant = Tenant::findOrFail(
            $validated['tenant_id']
        );

        if ((int) $tenant->room_id !== (int) $validated['room_id']) {

            return back()
                ->withInput()
                ->withErrors([
                    'room_id' =>
                        'ห้องพักไม่ตรงกับห้องของผู้เช่าที่เลือก'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | ดึงมิเตอร์
        |--------------------------------------------------------------------------
        */

        $meterReading = MeterReading::where(
                'tenant_id',
                $validated['tenant_id']
            )
            ->where(
                'room_id',
                $validated['room_id']
            )
            ->where(
                'billing_month',
                $validated['billing_month']
            )
            ->latest('id')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | ใช้ค่าน้ำ/ไฟจากมิเตอร์
        |--------------------------------------------------------------------------
        */

        if ($meterReading) {

            $validated['water'] =
                (float) $meterReading->water_charge;

            $validated['electricity'] =
                (float) $meterReading->electricity_charge;

        } else {

            $validated['water'] =
                $validated['water'] ?? 0;

            $validated['electricity'] =
                $validated['electricity'] ?? 0;
        }


        $validated['other_charge'] =
            $validated['other_charge'] ?? 0;


        /*
        |--------------------------------------------------------------------------
        | คำนวณยอดรวมใหม่
        |--------------------------------------------------------------------------
        */

        $validated['total'] =
            (float) $validated['rent']
            +
            (float) $validated['water']
            +
            (float) $validated['electricity']
            +
            (float) $validated['other_charge'];


        /*
        |--------------------------------------------------------------------------
        | ตรวจสอบบิลซ้ำ
        |--------------------------------------------------------------------------
        */

        $duplicateBill = Bill::where(
                'tenant_id',
                $validated['tenant_id']
            )
            ->where(
                'room_id',
                $validated['room_id']
            )
            ->where(
                'billing_month',
                $validated['billing_month']
            )
            ->where(
                'id',
                '!=',
                $bill->id
            )
            ->exists();


        if ($duplicateBill) {

            return back()
                ->withInput()
                ->withErrors([
                    'billing_month' =>
                        'ผู้เช่ารายนี้มีใบแจ้งค่าใช้จ่ายของเดือนนี้แล้ว'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | อัปเดตบิล
        |--------------------------------------------------------------------------
        */

        $bill->update($validated);


        return redirect()
            ->route('bills.index')
            ->with(
                'success',
                'แก้ไขใบแจ้งค่าใช้จ่ายเรียบร้อยแล้ว'
            );
    }


    /**
     * ลบบิล
     */
    public function destroy(string $id)
    {
        $bill = Bill::findOrFail($id);

        $bill->delete();

        return redirect()
            ->route('bills.index')
            ->with(
                'success',
                'ลบใบแจ้งค่าใช้จ่ายเรียบร้อยแล้ว'
            );
    }
}