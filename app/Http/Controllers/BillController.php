<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Tenant;
use App\Models\MeterReading;
use App\Services\LineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BillController extends Controller
{
    /**
     * แสดงรายการใบแจ้งค่าใช้จ่าย
     */
    public function index()
    {
        $bills = Bill::with([
            'tenant',
            'room',
        ])
            ->withSum('payments', 'amount')
            ->orderByDesc('due_date')
            ->orderByDesc('id')
            ->get();

        return view('bills.index', compact('bills'));
    }

    /**
     * แสดงหน้าเพิ่มใบแจ้งค่าใช้จ่าย
     */
    public function create()
    {
        $tenants = Tenant::with('room')
            ->where('status', 'พักอาศัย')
            ->orderBy('name')
            ->get();

        $meterReadings = MeterReading::with([
            'tenant',
            'room',
        ])
            ->orderByDesc('id')
            ->get();

        return view(
            'bills.create',
            compact('tenants', 'meterReadings')
        );
    }

    /**
     * บันทึกใบแจ้งค่าใช้จ่าย
     */
    public function store(
        Request $request,
        LineService $lineService
    ) {
        $validated = $this->validateBill($request);

        // ตรวจสอบผู้เช่า
        $tenant = Tenant::with('room')
            ->where('status', 'พักอาศัย')
            ->findOrFail($validated['tenant_id']);

        // ตรวจสอบว่าห้องตรงกับผู้เช่า
        if ((int) $tenant->room_id !== (int) $validated['room_id']) {
            return back()
                ->withInput()
                ->withErrors([
                    'room_id' => 'ห้องพักไม่ตรงกับห้องของผู้เช่าที่เลือก',
                ]);
        }

        // ดึงข้อมูลมิเตอร์
        $meterReading = $this->getMeterReading($validated);

        /*
        |--------------------------------------------------------------------------
        | ใช้ค่าน้ำและค่าไฟจาก Meter Reading
        |--------------------------------------------------------------------------
        */
        if ($meterReading) {
            $validated['water'] =
                (float) $meterReading->water_charge;

            $validated['electricity'] =
                (float) $meterReading->electricity_charge;
        } else {
            return back()
                ->withInput()
                ->withErrors([
                    'billing_month' =>
                        'ไม่พบข้อมูลมิเตอร์ของผู้เช่า ห้องพัก และเดือนที่เลือก กรุณาตรวจสอบเดือนหรือบันทึกข้อมูลมิเตอร์ก่อน',
                ]);
        }

        // ค่าใช้จ่ายอื่น
        $validated['other_charge'] =
            (float) ($validated['other_charge'] ?? 0);

        // คำนวณยอดรวม
        $validated['total'] =
            $this->calculateTotal($validated);

        // ตรวจสอบบิลซ้ำ
        if ($this->billExists($validated)) {
            return back()
                ->withInput()
                ->withErrors([
                    'billing_month' =>
                        'ผู้เช่ารายนี้มีใบแจ้งค่าใช้จ่ายของเดือนนี้แล้ว',
                ]);
        }

        // สร้างใบแจ้งค่าใช้จ่าย
        $bill = Bill::create($validated);

        /*
        |--------------------------------------------------------------------------
        | แจ้งเตือน LINE เมื่อสร้างใบแจ้งค่าใช้จ่ายสำเร็จ
        |--------------------------------------------------------------------------
        |
        | ถ้าผู้เช่ามี line_user_id ระบบจะส่งข้อความแจ้งเตือนไปยัง LINE
        | หาก LINE ส่งไม่สำเร็จ จะไม่ทำให้การสร้าง Bill ล้มเหลว
        |
        |--------------------------------------------------------------------------
        */

        if ($tenant->line_user_id) {

            /*
            |--------------------------------------------------------------------------
            | ข้อความแจ้งเตือน LINE
            |--------------------------------------------------------------------------
            | แสดงรายละเอียดค่าใช้จ่ายครบถ้วน
            | - ค่าห้อง
            | - ค่าน้ำ
            | - ค่าไฟ
            | - ค่าใช้จ่ายอื่น
            | - ยอดรวม
            | - รอบบิล
            | - กำหนดชำระ
            |--------------------------------------------------------------------------
            */

            $message = "🧾 ใบแจ้งค่าใช้จ่ายประจำเดือน\n\n"
                . "👤 ผู้เช่า: {$tenant->name}\n"
                . "🏠 ห้อง: "
                . ($tenant->room->room_number ?? '-')
                . "\n"
                . "📅 รอบบิล: {$bill->billing_month}\n\n"
                . "💰 รายละเอียดค่าใช้จ่าย\n"
                . "🏠 ค่าห้อง: "
                . number_format((float) $bill->rent, 2)
                . " บาท\n"
                . "💧 ค่าน้ำ: "
                . number_format((float) $bill->water, 2)
                . " บาท\n"
                . "⚡ ค่าไฟ: "
                . number_format((float) $bill->electricity, 2)
                . " บาท\n"
                . "📦 ค่าใช้จ่ายอื่น: "
                . number_format((float) $bill->other_charge, 2)
                . " บาท\n"
                . "━━━━━━━━━━━━━━\n"
                . "💵 ยอดรวม: "
                . number_format((float) $bill->total, 2)
                . " บาท\n"
                . "⏰ กำหนดชำระ: "
                . (
                    $bill->due_date
                        ? $bill->due_date->format('d/m/Y')
                        : '-'
                )
                . "\n\n"
                . "กรุณาตรวจสอบรายละเอียดใบแจ้งค่าใช้จ่ายในระบบ";

            try {
                $lineResult = $lineService->pushMessage(
                    $tenant->line_user_id,
                    $message
                );

                if (!$lineResult['success']) {
                    Log::warning(
                        'LINE bill notification failed',
                        [
                            'bill_id' => $bill->id,
                            'tenant_id' => $tenant->id,
                            'status' =>
                                $lineResult['status'] ?? null,
                        ]
                    );
                }
            } catch (\Throwable $e) {
                Log::error(
                    'LINE bill notification exception',
                    [
                        'bill_id' => $bill->id,
                        'tenant_id' => $tenant->id,
                        'error' => $e->getMessage(),
                    ]
                );
            }
        }

        return redirect()
            ->route('bills.index')
            ->with(
                'success',
                'สร้างใบแจ้งค่าใช้จ่ายเรียบร้อยแล้ว'
            );
    }

    /**
     * แสดงรายละเอียดใบแจ้งค่าใช้จ่าย
     */
    public function show(string $id)
    {
        $bill = Bill::with([
            'tenant',
            'room',
            'payments',
        ])->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | คำนวณยอดการชำระเงินจริง
        |--------------------------------------------------------------------------
        */

        // ยอดที่ชำระแล้วทั้งหมด
        $paidAmount = (float) $bill
            ->payments()
            ->sum('amount');

        // ยอดคงเหลือ
        $remainingAmount = max(
            0,
            (float) $bill->total - $paidAmount
        );

        /*
        |--------------------------------------------------------------------------
        | ตรวจสอบสถานะให้ตรงกับยอดเงินจริง
        |--------------------------------------------------------------------------
        */

        if ($remainingAmount <= 0) {

            $bill->status = 'ชำระแล้ว';

        } elseif (
            $bill->due_date &&
            now()->startOfDay()->gt($bill->due_date)
        ) {

            $bill->status = 'เกินกำหนด';

        } else {

            $bill->status = 'ค้างชำระ';
        }

        $bill->save();

        return view(
            'bills.show',
            compact(
                'bill',
                'paidAmount',
                'remainingAmount'
            )
        );
    }

    /**
     * แสดงหน้าแก้ไขใบแจ้งค่าใช้จ่าย
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
            'room',
        ])
            ->orderByDesc('id')
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
     * อัปเดตใบแจ้งค่าใช้จ่าย
     */
    public function update(
        Request $request,
        string $id
    ) {
        $bill = Bill::findOrFail($id);

        $validated = $this->validateBill($request);

        // ตรวจสอบผู้เช่า
        $tenant = Tenant::with('room')
            ->where('status', 'พักอาศัย')
            ->findOrFail($validated['tenant_id']);

        // ตรวจสอบว่าห้องตรงกับผู้เช่า
        if ((int) $tenant->room_id !== (int) $validated['room_id']) {
            return back()
                ->withInput()
                ->withErrors([
                    'room_id' =>
                        'ห้องพักไม่ตรงกับห้องของผู้เช่าที่เลือก',
                ]);
        }

        // ดึงข้อมูลมิเตอร์
        $meterReading = $this->getMeterReading($validated);

        /*
        |--------------------------------------------------------------------------
        | ใช้ค่าน้ำและค่าไฟจาก Meter Reading
        |--------------------------------------------------------------------------
        */

        if ($meterReading) {
            $validated['water'] =
                (float) $meterReading->water_charge;

            $validated['electricity'] =
                (float) $meterReading->electricity_charge;
        } else {
            return back()
                ->withInput()
                ->withErrors([
                    'billing_month' =>
                        'ไม่พบข้อมูลมิเตอร์ของผู้เช่า ห้องพัก และเดือนที่เลือก กรุณาตรวจสอบเดือนหรือบันทึกข้อมูลมิเตอร์ก่อน',
                ]);
        }

        // ค่าใช้จ่ายอื่น
        $validated['other_charge'] =
            (float) ($validated['other_charge'] ?? 0);

        // คำนวณยอดรวมใหม่
        $validated['total'] =
            $this->calculateTotal($validated);

        // ตรวจสอบบิลซ้ำ
        if ($this->billExists(
            $validated,
            (int) $bill->id
        )) {
            return back()
                ->withInput()
                ->withErrors([
                    'billing_month' =>
                        'ผู้เช่ารายนี้มีใบแจ้งค่าใช้จ่ายของเดือนนี้แล้ว',
                ]);
        }

        // อัปเดตข้อมูล
        $bill->update($validated);

        /*
        |--------------------------------------------------------------------------
        | หลังแก้ไขบิล ให้ตรวจสอบยอดชำระใหม่
        |--------------------------------------------------------------------------
        */

        $paidAmount = (float) $bill
            ->payments()
            ->sum('amount');

        $remainingAmount = max(
            0,
            (float) $bill->total - $paidAmount
        );

        if ($remainingAmount <= 0) {

            $bill->status = 'ชำระแล้ว';

        } elseif (
            $bill->due_date &&
            now()->startOfDay()->gt($bill->due_date)
        ) {

            $bill->status = 'เกินกำหนด';

        } else {

            $bill->status = 'ค้างชำระ';
        }

        $bill->save();

        return redirect()
            ->route('bills.show', $bill->id)
            ->with(
                'success',
                'แก้ไขใบแจ้งค่าใช้จ่ายเรียบร้อยแล้ว'
            );
    }

    /**
     * ลบใบแจ้งค่าใช้จ่าย
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

    /**
     * ตรวจสอบข้อมูลใบแจ้งค่าใช้จ่าย
     */
    private function validateBill(Request $request): array
    {
        return $request->validate(
            [
                'tenant_id' => [
                    'required',
                    'exists:tenants,id',
                ],

                'room_id' => [
                    'required',
                    'exists:rooms,id',
                ],

                'billing_month' => [
                    'required',
                    'string',
                    'max:50',
                ],

                'rent' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'water' => [
                    'nullable',
                    'numeric',
                    'min:0',
                ],

                'electricity' => [
                    'nullable',
                    'numeric',
                    'min:0',
                ],

                'other_charge' => [
                    'nullable',
                    'numeric',
                    'min:0',
                ],

                'due_date' => [
                    'required',
                    'date',
                ],

                'status' => [
                    'required',
                    'in:ค้างชำระ,ชำระแล้ว,เกินกำหนด',
                ],

                'description' => [
                    'nullable',
                    'string',
                ],
            ],
            [
                'tenant_id.required' =>
                    'กรุณาเลือกผู้เช่า',

                'room_id.required' =>
                    'กรุณาเลือกห้องพัก',

                'billing_month.required' =>
                    'กรุณาระบุเดือนที่เรียกเก็บ',

                'rent.required' =>
                    'กรุณาระบุค่าเช่า',

                'due_date.required' =>
                    'กรุณาระบุวันครบกำหนด',

                'status.required' =>
                    'กรุณาเลือกสถานะใบแจ้งค่าใช้จ่าย',
            ]
        );
    }

    /**
     * ค้นหาข้อมูลมิเตอร์ของผู้เช่า
     */
    private function getMeterReading(
        array $data
    ): ?MeterReading {
        return MeterReading::where(
            'tenant_id',
            $data['tenant_id']
        )
            ->where(
                'room_id',
                $data['room_id']
            )
            ->where(
                'billing_month',
                $data['billing_month']
            )
            ->latest('id')
            ->first();
    }

    /**
     * คำนวณยอดรวม
     */
    private function calculateTotal(
        array $data
    ): float {
        return round(
            (float) ($data['rent'] ?? 0)
            + (float) ($data['water'] ?? 0)
            + (float) ($data['electricity'] ?? 0)
            + (float) ($data['other_charge'] ?? 0),
            2
        );
    }

    /**
     * ตรวจสอบว่ามีใบแจ้งค่าใช้จ่ายซ้ำหรือไม่
     */
    private function billExists(
        array $data,
        ?int $ignoreId = null
    ): bool {
        $query = Bill::where(
            'tenant_id',
            $data['tenant_id']
        )
            ->where(
                'room_id',
                $data['room_id']
            )
            ->where(
                'billing_month',
                $data['billing_month']
            );

        if ($ignoreId !== null) {
            $query->where(
                'id',
                '!=',
                $ignoreId
            );
        }

        return $query->exists();
    }
}
