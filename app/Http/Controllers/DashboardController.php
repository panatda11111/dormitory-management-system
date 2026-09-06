<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Tenant;
use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Dashboard ผู้เช่า
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'tenant') {

            // ค้นหาข้อมูลผู้เช่าที่เชื่อมกับบัญชี Login
            $tenant = Tenant::with('room')
                ->where('user_id', $user->id)
                ->first();

            // ถ้ายังไม่มีข้อมูลผู้เช่า
            if (!$tenant) {
                return view('dashboard-tenant', [
                    'tenant' => null,
                    'bills' => collect(),
                    'totalBills' => 0,
                    'unpaidBills' => 0,
                    'pendingAmount' => 0,
                    'totalPayments' => 0,
                    'totalPaid' => 0,
                ]);
            }

            // ใบแจ้งค่าใช้จ่ายของผู้เช่าคนนี้
            $bills = Bill::where('tenant_id', $tenant->id)
                ->with('payments')
                ->latest()
                ->get();

            $totalBills = $bills->count();

            // จำนวนใบแจ้งที่ยังมีเงินค้าง
            $unpaidBills = 0;

            // ยอดค้างชำระทั้งหมด
            $pendingAmount = 0;

            foreach ($bills as $bill) {

                $paidAmount = $bill->payments->sum('amount');

                $remainingAmount =
                    (float) $bill->total - (float) $paidAmount;

                if ($remainingAmount > 0) {
                    $unpaidBills++;
                    $pendingAmount += $remainingAmount;
                }
            }

            // ประวัติการชำระเงินของผู้เช่า
            $payments = Payment::whereHas('bill', function ($query) use ($tenant) {
                $query->where('tenant_id', $tenant->id);
            })->get();

            $totalPayments = $payments->count();

            $totalPaid = $payments->sum('amount');

            return view('dashboard-tenant', compact(
                'tenant',
                'bills',
                'totalBills',
                'unpaidBills',
                'pendingAmount',
                'totalPayments',
                'totalPaid'
            ));
        }


        /*
        |--------------------------------------------------------------------------
        | Dashboard Admin
        |--------------------------------------------------------------------------
        */

        $occupied = 'มีผู้เช่า';
        $available = 'ว่าง';
        $reserved = 'จอง';
        $maintenance = 'ซ่อมแซม';

        $totalRooms = Room::count();

        $occupiedRooms = Room::where('status', $occupied)->count();

        $availableRooms = Room::where('status', $available)->count();

        $reservedRooms = Room::where('status', $reserved)->count();

        $maintenanceRooms = Room::where('status', $maintenance)->count();


        // Tenant status
        $tenantActive = 'พักอาศัย';

        $totalTenants = Tenant::where(
            'status',
            $tenantActive
        )->count();


        // Bill status
        $paid = 'ชำระแล้ว';

        $unpaid = 'ค้างชำระ';

        $overdue = 'เกินกำหนด';

        $totalBills = Bill::count();

        $paidBills = Bill::where('status', $paid)->count();

        $unpaidBills = Bill::where('status', $unpaid)->count();

        $overdueBills = Bill::where('status', $overdue)->count();


        // รายรับทั้งหมด
        $totalIncome = Payment::sum('amount');


        // ยอดค้างชำระ
        $pendingAmount = 0;

        $pendingBills = Bill::whereIn(
            'status',
            [
                $unpaid,
                $overdue
            ]
        )
        ->with('payments')
        ->get();

        foreach ($pendingBills as $bill) {

            $paidAmount = $bill->payments->sum('amount');

            $remainingAmount =
                (float) $bill->total
                - (float) $paidAmount;

            if ($remainingAmount > 0) {
                $pendingAmount += $remainingAmount;
            }
        }


        // จำนวนรายการชำระเงิน
        $totalPayments = Payment::count();


        return view(
            'dashboard',
            compact(
                'totalRooms',
                'occupiedRooms',
                'availableRooms',
                'reservedRooms',
                'maintenanceRooms',
                'totalTenants',
                'totalBills',
                'paidBills',
                'unpaidBills',
                'overdueBills',
                'pendingAmount',
                'totalIncome',
                'totalPayments'
            )
        );
    }
}