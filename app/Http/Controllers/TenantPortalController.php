<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;

class TenantPortalController extends Controller
{
    /**
     * แสดงใบแจ้งค่าใช้จ่ายของผู้เช่า
     */
    public function bills()
    {
        $user = Auth::user();

        // ค้นหาข้อมูลผู้เช่าที่เชื่อมกับบัญชี Login
        $tenant = Tenant::with('room')
            ->where('user_id', $user->id)
            ->first();

        // ถ้ายังไม่มีข้อมูลผู้เช่า
        if (!$tenant) {
            return view('tenant.bills', [
                'tenant' => null,
                'bills' => collect(),
            ]);
        }

        // ดึงเฉพาะใบแจ้งค่าใช้จ่ายของผู้เช่าคนนี้
        $bills = Bill::where('tenant_id', $tenant->id)
            ->with([
                'room',
                'payments',
            ])
            ->orderByDesc('due_date')
            ->orderByDesc('id')
            ->get();

        return view(
            'tenant.bills',
            compact(
                'tenant',
                'bills'
            )
        );
    }


    /**
     * แสดงรายละเอียดใบแจ้งค่าใช้จ่ายของผู้เช่า
     */
    public function showBill(Bill $bill)
    {
        $user = Auth::user();

        // ค้นหาข้อมูลผู้เช่าที่เชื่อมกับบัญชี Login
        $tenant = Tenant::with('room')
            ->where('user_id', $user->id)
            ->first();

        // ถ้ายังไม่มีข้อมูลผู้เช่า
        if (!$tenant) {
            abort(403);
        }

        // ป้องกันผู้เช่าดู Bill ของผู้เช่าคนอื่น
        if ((int) $bill->tenant_id !== (int) $tenant->id) {
            abort(403);
        }

        // โหลดข้อมูลที่เกี่ยวข้อง
        $bill->load([
            'room',
            'payments',
        ]);

        return view(
            'tenant.bill-show',
            compact(
                'tenant',
                'bill'
            )
        );
    }


    /**
     * แสดงประวัติการชำระเงินของผู้เช่า
     */
    public function payments()
    {
        $user = Auth::user();

        // ค้นหาข้อมูลผู้เช่าที่เชื่อมกับบัญชี Login
        $tenant = Tenant::with('room')
            ->where('user_id', $user->id)
            ->first();

        // ถ้ายังไม่มีข้อมูลผู้เช่า
        if (!$tenant) {
            return view('tenant.payments', [
                'tenant' => null,
                'payments' => collect(),
            ]);
        }

        // ดึงเฉพาะการชำระเงินที่เป็นของผู้เช่าคนนี้
        $payments = Payment::whereHas('bill', function ($query) use ($tenant) {
                $query->where('tenant_id', $tenant->id);
            })
            ->with([
                'bill.room',
            ])
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->get();

        return view(
            'tenant.payments',
            compact(
                'tenant',
                'payments'
            )
        );
    }
}
