<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Payment;
use App\Services\LineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * แสดงประวัติการชำระเงิน
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {

            // Admin เห็นประวัติการชำระเงินทั้งหมด
            $payments = Payment::with([
                'bill.tenant',
                'bill.room'
            ])
                ->orderByDesc('payment_date')
                ->orderByDesc('id')
                ->get();

        } else {

            // Tenant เห็นเฉพาะรายการชำระเงินของตัวเอง
            $tenant = $user->tenant;

            if (!$tenant) {
                $payments = collect();
            } else {

                $payments = Payment::whereHas('bill', function ($query) use ($tenant) {
                    $query->where('tenant_id', $tenant->id);
                })
                    ->with([
                        'bill.tenant',
                        'bill.room'
                    ])
                    ->orderByDesc('payment_date')
                    ->orderByDesc('id')
                    ->get();
            }
        }

        return view('payments.index', compact('payments'));
    }


    /**
     * แสดงฟอร์มชำระเงิน
     * Admin เท่านั้น
     */
    public function create(Bill $bill)
    {
        $paidAmount = (float) $bill->payments()->sum('amount');

        $remainingAmount = max(
            0,
            (float) $bill->total - $paidAmount
        );

        // ถ้าชำระครบแล้ว ไม่อนุญาตให้ชำระเพิ่ม
        if ($remainingAmount <= 0) {
            return redirect()
                ->route('bills.show', $bill->id)
                ->with(
                    'success',
                    'ใบแจ้งค่าใช้จ่ายรายการนี้ชำระครบแล้ว'
                );
        }

        return view(
            'payments.create',
            compact(
                'bill',
                'paidAmount',
                'remainingAmount'
            )
        );
    }


    /**
     * บันทึกการชำระเงิน
     * Admin เท่านั้น
     */
    public function store(
        Request $request,
        Bill $bill,
        LineService $lineService
    ) {
        // ยอดที่ชำระไปแล้ว
        $paidAmount = (float) $bill->payments()->sum('amount');

        // ยอดคงเหลือ
        $remainingAmount = max(
            0,
            (float) $bill->total - $paidAmount
        );

        // ถ้าชำระครบแล้ว
        if ($remainingAmount <= 0) {
            return redirect()
                ->route('bills.show', $bill->id)
                ->with(
                    'success',
                    'ใบแจ้งค่าใช้จ่ายรายการนี้ชำระครบแล้ว'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ตรวจสอบข้อมูลการชำระเงิน
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'amount' => [
                    'required',
                    'numeric',
                    'min:0.01',
                    'max:' . $remainingAmount,
                ],

                'payment_date' => [
                    'required',
                    'date',
                ],

                'payment_method' => [
                    'required',
                    'in:เงินสด,โอนเงิน,อื่นๆ',
                ],

                'description' => [
                    'nullable',
                    'string',
                ],
            ],
            [
                'amount.required' =>
                    'กรุณาระบุจำนวนเงินที่ชำระ',

                'amount.numeric' =>
                    'จำนวนเงินต้องเป็นตัวเลข',

                'amount.min' =>
                    'จำนวนเงินต้องมากกว่า 0 บาท',

                'amount.max' =>
                    'จำนวนเงินที่ชำระต้องไม่เกินยอดคงเหลือ',

                'payment_date.required' =>
                    'กรุณาระบุวันที่ชำระเงิน',

                'payment_method.required' =>
                    'กรุณาเลือกวิธีการชำระเงิน',

                'payment_method.in' =>
                    'วิธีการชำระเงินไม่ถูกต้อง',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | บันทึกการชำระเงิน
        |--------------------------------------------------------------------------
        */

        $payment = Payment::create([
            'bill_id' => $bill->id,
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'payment_method' => $validated['payment_method'],
            'description' => $validated['description'] ?? null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | คำนวณยอดใหม่
        |--------------------------------------------------------------------------
        */

        $newPaidAmount = (float) $bill
            ->payments()
            ->sum('amount');

        $newRemainingAmount = max(
            0,
            (float) $bill->total - $newPaidAmount
        );


        /*
        |--------------------------------------------------------------------------
        | อัปเดตสถานะใบแจ้งค่าใช้จ่าย
        |--------------------------------------------------------------------------
        */

        if ($newRemainingAmount <= 0) {

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


        /*
        |--------------------------------------------------------------------------
        | ส่ง LINE แจ้งเตือนการชำระเงิน
        |--------------------------------------------------------------------------
        */

        $tenant = $bill->tenant;

        if ($tenant && $tenant->line_user_id) {

            $statusText = $bill->status === 'ชำระแล้ว'
                ? 'ชำระแล้ว'
                : $bill->status;

            $message =
                "💳 ชำระเงินเรียบร้อยแล้ว\n\n"
                . "ผู้เช่า: {$tenant->name}\n"
                . "ห้อง: " . ($bill->room->room_number ?? '-') . "\n"
                . "รอบบิล: {$bill->billing_month}\n\n"
                . "ยอดที่ชำระครั้งนี้: "
                . number_format((float) $payment->amount, 2)
                . " บาท\n"
                . "ชำระสะสม: "
                . number_format($newPaidAmount, 2)
                . " บาท\n"
                . "ยอดคงเหลือ: "
                . number_format($newRemainingAmount, 2)
                . " บาท\n"
                . "สถานะ: {$statusText}\n\n"
                . "ขอบคุณที่ชำระค่าบริการ";

            try {

                $lineResult = $lineService->pushMessage(
                    $tenant->line_user_id,
                    $message
                );

                if (!$lineResult['success']) {

                    Log::warning(
                        'LINE payment notification failed',
                        [
                            'payment_id' => $payment->id,
                            'bill_id' => $bill->id,
                            'tenant_id' => $tenant->id,
                            'status' =>
                                $lineResult['status'] ?? null,
                        ]
                    );
                }

            } catch (\Throwable $e) {

                Log::error(
                    'LINE payment notification exception',
                    [
                        'payment_id' => $payment->id,
                        'bill_id' => $bill->id,
                        'tenant_id' => $tenant->id,
                        'error' => $e->getMessage(),
                    ]
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | กลับไปหน้าใบแจ้งค่าใช้จ่าย
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('bills.show', $bill->id)
            ->with(
                'success',
                'บันทึกการชำระเงินเรียบร้อยแล้ว'
            );
    }


    /**
     * แสดงรายละเอียดการชำระเงิน
     */
    public function show(string $id)
    {
        $payment = Payment::with([
            'bill.tenant',
            'bill.room'
        ])
            ->findOrFail($id);

        $user = Auth::user();

        // Tenant ต้องดูได้เฉพาะ Payment ของตัวเอง
        if ($user->role === 'tenant') {

            $tenant = $user->tenant;

            if (
                !$tenant ||
                !$payment->bill ||
                $payment->bill->tenant_id !== $tenant->id
            ) {
                abort(403);
            }
        }

        return view(
            'payments.show',
            compact('payment')
        );
    }


    /**
     * ลบรายการชำระเงิน
     * Admin เท่านั้น
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);

        $bill = $payment->bill;

        $payment->delete();


        /*
        |--------------------------------------------------------------------------
        | คำนวณยอดหลังลบรายการชำระเงิน
        |--------------------------------------------------------------------------
        */

        $paidAmount = (float) $bill
            ->payments()
            ->sum('amount');

        $remainingAmount = max(
            0,
            (float) $bill->total - $paidAmount
        );


        /*
        |--------------------------------------------------------------------------
        | อัปเดตสถานะ
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


        return redirect()
            ->route('payments.index')
            ->with(
                'success',
                'ลบรายการชำระเงินเรียบร้อยแล้ว'
            );
    }
}