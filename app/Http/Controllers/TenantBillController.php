<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Support\Facades\Auth;

class TenantBillController extends Controller
{
    /**
     * แสดงรายละเอียดใบแจ้งค่าใช้จ่ายของผู้เช่า
     */
    public function show(string $id)
    {
        // ตรวจสอบว่ามีผู้ใช้ Login อยู่
        $user = Auth::user();

        // ดึงข้อมูลผู้เช่าที่เชื่อมกับบัญชีที่ Login
        $tenant = $user->tenant;

        // ถ้ายังไม่มีข้อมูลผู้เช่า
        if (!$tenant) {
            abort(403, 'ไม่พบบัญชีผู้เช่าที่เชื่อมกับบัญชีนี้');
        }

        /*
        |--------------------------------------------------------------------------
        | ดึงบิลเฉพาะของผู้เช่าที่กำลัง Login
        |--------------------------------------------------------------------------
        */

        $bill = Bill::with([
            'tenant',
            'room',
            'payments',
        ])
            ->where('id', $id)
            ->where('tenant_id', $tenant->id)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | คำนวณยอดชำระ
        |--------------------------------------------------------------------------
        */

        $paidAmount = (float) $bill
            ->payments()
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | คำนวณยอดคงเหลือ
        |--------------------------------------------------------------------------
        */

        $remainingAmount = max(
            0,
            (float) $bill->total - $paidAmount
        );

        return view(
            'tenant.bills.show',
            compact(
                'bill',
                'tenant',
                'paidAmount',
                'remainingAmount'
            )
        );
    }
}