<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        ใบแจ้งค่าใช้จ่าย
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 35px 20px;
            font-family: Arial, Tahoma, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        .container {
            max-width: 850px;
            margin: auto;
        }

        .invoice {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }

        /* ==============================
           Header
        ============================== */

        .header {
            text-align: center;
            border-bottom: 2px solid #198754;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 30px;
            color: #198754;
        }

        .invoice-number {
            margin-top: 8px;
            color: #6c757d;
            font-size: 14px;
        }

        /* ==============================
           ข้อมูลใบแจ้งค่าใช้จ่าย
        ============================== */

        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 30px;
        }

        .info-item {
            padding: 5px 0;
        }

        .info-label {
            font-weight: bold;
            color: #555;
        }

        /* ==============================
           ตารางค่าใช้จ่าย
        ============================== */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 13px;
        }

        th {
            background: #f1f3f5;
            font-weight: bold;
        }

        th:last-child,
        td.amount {
            text-align: right;
        }

        /* ==============================
           ยอดรวม
        ============================== */

        .total-box {
            margin-top: 20px;
            padding: 18px 20px;
            background: #e9f7ef;
            border-left: 5px solid #198754;
            border-radius: 7px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-label {
            font-size: 20px;
            font-weight: bold;
        }

        .total-value {
            font-size: 27px;
            font-weight: bold;
            color: #198754;
        }

        /* ==============================
           ข้อมูลการชำระเงิน
        ============================== */

        .payment-box {
            margin-top: 25px;
            padding: 20px;

            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .payment-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .payment-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .payment-row:last-child {
            border-bottom: none;
        }

        .paid-amount {
            color: #198754;
            font-weight: bold;
        }

        .remaining-amount {
            color: #dc3545;
            font-weight: bold;
        }

        /* ==============================
           สถานะ
        ============================== */

        .status {
            margin-top: 20px;
            padding: 13px;
            border-radius: 7px;

            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .status-paid {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-unpaid {
            background: #f8d7da;
            color: #842029;
        }

        .status-overdue {
            background: #fff3cd;
            color: #664d03;
        }

        /* ==============================
           รายละเอียดเพิ่มเติม
        ============================== */

        .description {
            margin-top: 25px;
            padding: 18px;

            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 7px;
        }

        .description-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* ==============================
           ปุ่ม
        ============================== */

        .buttons {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .button {
            display: inline-block;

            padding: 11px 18px;

            border: none;
            border-radius: 6px;

            text-decoration: none;

            font-size: 15px;
            cursor: pointer;

            font-family: inherit;
        }

        .back {
            background: #6c757d;
            color: white;
        }

        .edit {
            background: #0d6efd;
            color: white;
        }

        .payment {
            background: #ffc107;
            color: #212529;
            font-weight: bold;
        }

        .history {
            background: #6f42c1;
            color: white;
        }

        .print {
            background: #198754;
            color: white;
        }

        .button:hover {
            opacity: 0.9;
        }

        /* ==============================
           Responsive
        ============================== */

        @media (max-width: 600px) {

            body {
                padding: 20px 10px;
            }

            .invoice {
                padding: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .total-box {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .payment-row {
                flex-direction: column;
                gap: 5px;
            }

            .buttons {
                flex-direction: column;
            }

            .button {
                width: 100%;
                text-align: center;
            }

        }

        /* ==============================
           Print
        ============================== */

        @media print {

            @page {
                size: A4;
                margin: 15mm;
            }

            body {
                background: white;
                padding: 0;
            }

            .container {
                max-width: none;
            }

            .invoice {
                padding: 0;
                box-shadow: none;
                border-radius: 0;
            }

            .buttons {
                display: none;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <div class="invoice">

        {{-- =====================================================
             คำนวณยอดชำระ
        ====================================================== --}}

        @php

            $paidAmount = \App\Models\Payment::where(
                'bill_id',
                $bill->id
            )->sum('amount');

            $billTotal = (float) ($bill->total ?? 0);

            $paidAmount = (float) $paidAmount;

            $remainingAmount = max(
                0,
                $billTotal - $paidAmount
            );

        @endphp


        {{-- =====================================================
             หัวเอกสาร
        ====================================================== --}}

        <div class="header">

            <h1>
                🧾 ใบแจ้งค่าใช้จ่าย
            </h1>

            <div class="invoice-number">

                เลขที่ใบแจ้งค่าใช้จ่าย:
                #{{ $bill->id }}

            </div>

        </div>


        {{-- =====================================================
             ข้อมูลผู้เช่า
        ====================================================== --}}

        <div class="info-box">

            <div class="info-grid">

                <div class="info-item">

                    <span class="info-label">
                        👤 ผู้เช่า:
                    </span>

                    {{ $bill->tenant->name ?? '-' }}

                </div>


                <div class="info-item">

                    <span class="info-label">
                        🏠 ห้อง:
                    </span>

                    {{ $bill->room->room_number ?? '-' }}

                </div>


                <div class="info-item">

                    <span class="info-label">
                        📅 เดือนที่เรียกเก็บ:
                    </span>

                    {{ $bill->billing_month ?? '-' }}

                </div>


                <div class="info-item">

                    <span class="info-label">
                        📅 วันครบกำหนด:
                    </span>

                    @if($bill->due_date)

                        {{ $bill->due_date->format('d/m/Y') }}

                    @else

                        -

                    @endif

                </div>

            </div>

        </div>


        {{-- =====================================================
             รายการค่าใช้จ่าย
        ====================================================== --}}

        <table>

            <thead>

                <tr>

                    <th>
                        รายการค่าใช้จ่าย
                    </th>

                    <th>
                        จำนวนเงิน
                    </th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>
                        🏠 ค่าเช่าห้อง
                    </td>

                    <td class="amount">

                        {{ number_format(
                            (float) $bill->rent,
                            2
                        ) }}

                        บาท

                    </td>

                </tr>


                <tr>

                    <td>
                        💧 ค่าน้ำ
                    </td>

                    <td class="amount">

                        {{ number_format(
                            (float) $bill->water,
                            2
                        ) }}

                        บาท

                    </td>

                </tr>


                <tr>

                    <td>
                        ⚡ ค่าไฟ
                    </td>

                    <td class="amount">

                        {{ number_format(
                            (float) $bill->electricity,
                            2
                        ) }}

                        บาท

                    </td>

                </tr>


                <tr>

                    <td>
                        💰 ค่าใช้จ่ายอื่น
                    </td>

                    <td class="amount">

                        {{ number_format(
                            (float) ($bill->other_charge ?? 0),
                            2
                        ) }}

                        บาท

                    </td>

                </tr>

            </tbody>

        </table>


        {{-- =====================================================
             ยอดรวม
        ====================================================== --}}

        <div class="total-box">

            <div class="total-label">
                💰 ยอดรวมทั้งหมด
            </div>

            <div class="total-value">

                {{ number_format(
                    $billTotal,
                    2
                ) }}

                บาท

            </div>

        </div>


        {{-- =====================================================
             สรุปการชำระเงิน
        ====================================================== --}}

        <div class="payment-box">

            <div class="payment-title">
                💳 สรุปการชำระเงิน
            </div>


            <div class="payment-row">

                <span>
                    ยอดใบแจ้งค่าใช้จ่าย
                </span>

                <span>

                    {{ number_format(
                        $billTotal,
                        2
                    ) }}

                    บาท

                </span>

            </div>


            <div class="payment-row">

                <span>
                    ชำระแล้ว
                </span>

                <span class="paid-amount">

                    {{ number_format(
                        $paidAmount,
                        2
                    ) }}

                    บาท

                </span>

            </div>


            <div class="payment-row">

                <span>
                    ยอดคงเหลือ
                </span>

                <span class="remaining-amount">

                    {{ number_format(
                        $remainingAmount,
                        2
                    ) }}

                    บาท

                </span>

            </div>

        </div>


        {{-- =====================================================
             สถานะ
        ====================================================== --}}

        @if($remainingAmount <= 0)

            <div class="status status-paid">

                ✓ ชำระเงินครบถ้วนแล้ว

            </div>

        @elseif($bill->status === 'เกินกำหนด')

            <div class="status status-overdue">

                ⚠ เกินกำหนดชำระ

            </div>

        @else

            <div class="status status-unpaid">

                ! ค้างชำระ

            </div>

        @endif


        {{-- =====================================================
             รายละเอียดเพิ่มเติม
        ====================================================== --}}

        @if(!empty($bill->description))

            <div class="description">

                <div class="description-title">
                    📝 รายละเอียดเพิ่มเติม
                </div>

                <div>
                    {{ $bill->description }}
                </div>

            </div>

        @endif


        {{-- =====================================================
             ปุ่มจัดการ
        ====================================================== --}}

        <div class="buttons">

            {{-- กลับ --}}

            <a
                href="{{ route('bills.index') }}"
                class="button back"
            >
                ← กลับรายการ
            </a>


            {{-- แก้ไข --}}

            <a
                href="{{ route(
                    'bills.edit',
                    $bill->id
                ) }}"
                class="button edit"
            >
                ✏️ แก้ไข
            </a>


            {{-- ชำระเงิน --}}

            @if($remainingAmount > 0)

                <a
                    href="{{ route(
                        'payments.create',
                        $bill->id
                    ) }}"
                    class="button payment"
                >
                    💳 ชำระเงิน
                </a>

            @endif


            {{-- ประวัติการชำระ --}}

            <a
                href="{{ route('payments.index') }}"
                class="button history"
            >
                💳 ประวัติการชำระ
            </a>


            {{-- พิมพ์ --}}

            <button
                type="button"
                onclick="window.print()"
                class="button print"
            >
                🖨️ พิมพ์ใบแจ้งค่าใช้จ่าย
            </button>

        </div>

    </div>

</div>

</body>

</html>