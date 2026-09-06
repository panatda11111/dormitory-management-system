<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>รายละเอียดใบแจ้งค่าใช้จ่าย</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, "Tahoma", sans-serif;
            background: #f4f6f8;
            color: #1f2937;
        }

        .container {
            width: 100%;
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: #ffffff;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0 0 8px;
            font-size: 26px;
        }

        .header p {
            margin: 0;
            color: #6b7280;
        }

        .status {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            white-space: nowrap;
        }

        .status-paid {
            background: #dcfce7;
            color: #166534;
        }

        .status-unpaid {
            background: #fef3c7;
            color: #92400e;
        }

        .status-overdue {
            background: #fee2e2;
            color: #991b1b;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 30px;
        }

        .info-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 16px;
        }

        .info-label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .info-value {
            font-size: 16px;
            font-weight: bold;
        }

        .section-title {
            margin: 25px 0 15px;
            font-size: 19px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 13px 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f9fafb;
            font-weight: bold;
        }

        .amount {
            text-align: right;
            font-weight: bold;
        }

        .total-row td {
            font-size: 17px;
            font-weight: bold;
        }

        .remaining {
            background: #f9fafb;
            border-radius: 10px;
            padding: 18px;
            margin-top: 20px;
        }

        .remaining-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin: 8px 0;
        }

        .remaining-row.final {
            padding-top: 12px;
            margin-top: 12px;
            border-top: 1px solid #d1d5db;
            font-size: 20px;
            font-weight: bold;
        }

        .payments-table {
            margin-top: 10px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #d1d5db;
            color: #374151;
            background: #ffffff;
        }

        .btn:hover {
            background: #f3f4f6;
        }

        @media (max-width: 650px) {
            .container {
                margin: 20px auto;
                padding: 0 12px;
            }

            .card {
                padding: 20px;
            }

            .header {
                flex-direction: column;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            th,
            td {
                white-space: nowrap;
            }

            .remaining-row {
                flex-direction: column;
                gap: 4px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="card">

            <div class="header">
                <div>
                    <h1>🧾 รายละเอียดใบแจ้งค่าใช้จ่าย</h1>
                    <p>ตรวจสอบรายละเอียดค่าใช้จ่ายของคุณ</p>
                </div>

                @if ($remainingAmount <= 0)
                    <span class="status status-paid">✓ ชำระแล้ว</span>
                @elseif ($bill->due_date && now()->startOfDay()->gt($bill->due_date))
                    <span class="status status-overdue">เกินกำหนด</span>
                @else
                    <span class="status status-unpaid">ค้างชำระ</span>
                @endif
            </div>

            <h2 class="section-title">👤 ข้อมูลผู้เช่า</h2>

            <div class="info-grid">

                <div class="info-box">
                    <div class="info-label">ชื่อผู้เช่า</div>
                    <div class="info-value">
                        {{ $tenant->name }}
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-label">ห้องพัก</div>
                    <div class="info-value">
                        {{ $tenant->room->room_number ?? '-' }}
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-label">เดือนที่เรียกเก็บ</div>
                    <div class="info-value">
                        {{ $bill->billing_month }}
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-label">วันครบกำหนด</div>
                    <div class="info-value">
                        {{ $bill->due_date ? $bill->due_date->format('d/m/Y') : '-' }}
                    </div>
                </div>

            </div>

            <h2 class="section-title">💰 รายละเอียดค่าใช้จ่าย</h2>

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>รายการ</th>
                            <th class="amount">จำนวนเงิน</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>ค่าเช่าห้อง</td>
                            <td class="amount">
                                {{ number_format($bill->rent, 2) }} บาท
                            </td>
                        </tr>

                        <tr>
                            <td>ค่าน้ำ</td>
                            <td class="amount">
                                {{ number_format($bill->water, 2) }} บาท
                            </td>
                        </tr>

                        <tr>
                            <td>ค่าไฟ</td>
                            <td class="amount">
                                {{ number_format($bill->electricity, 2) }} บาท
                            </td>
                        </tr>

                        <tr>
                            <td>ค่าใช้จ่ายอื่น</td>
                            <td class="amount">
                                {{ number_format($bill->other_charge ?? 0, 2) }} บาท
                            </td>
                        </tr>

                        <tr class="total-row">
                            <td>ยอดรวมทั้งหมด</td>
                            <td class="amount">
                                {{ number_format($bill->total, 2) }} บาท
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

            <div class="remaining">

                <div class="remaining-row">
                    <span>ยอดรวม</span>
                    <strong>
                        {{ number_format($bill->total, 2) }} บาท
                    </strong>
                </div>

                <div class="remaining-row">
                    <span>ชำระแล้ว</span>
                    <strong>
                        {{ number_format($paidAmount, 2) }} บาท
                    </strong>
                </div>

                <div class="remaining-row final">
                    <span>ยอดคงเหลือ</span>
                    <strong>
                        {{ number_format($remainingAmount, 2) }} บาท
                    </strong>
                </div>

            </div>

            @if ($bill->payments->count() > 0)

                <h2 class="section-title">💳 ประวัติการชำระเงินของบิลนี้</h2>

                <div class="table-wrapper">

                    <table class="payments-table">

                        <thead>
                            <tr>
                                <th>วันที่ชำระ</th>
                                <th>วิธีการชำระเงิน</th>
                                <th>หมายเหตุ</th>
                                <th class="amount">จำนวนเงิน</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($bill->payments->sortByDesc('payment_date') as $payment)

                                <tr>
                                    <td>
                                        {{ $payment->payment_date
                                            ? $payment->payment_date->format('d/m/Y')
                                            : '-' }}
                                    </td>

                                    <td>
                                        {{ $payment->payment_method ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $payment->description ?? '-' }}
                                    </td>

                                    <td class="amount">
                                        {{ number_format($payment->amount, 2) }} บาท
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="remaining" style="margin-top: 25px;">
                    ยังไม่มีประวัติการชำระเงินสำหรับใบแจ้งค่าใช้จ่ายนี้
                </div>

            @endif

            @if ($bill->description)

                <h2 class="section-title">📝 หมายเหตุ</h2>

                <div class="info-box">
                    {{ $bill->description }}
                </div>

            @endif

            <div class="actions">

                <a href="{{ route('tenant.bills') }}" class="btn">
                    ← กลับใบแจ้งค่าใช้จ่ายของฉัน
                </a>

                <a href="{{ route('tenant.payments') }}" class="btn">
                    💳 ประวัติการชำระเงิน
                </a>

            </div>

        </div>

    </div>

</body>

</html>