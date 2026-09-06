<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>รายละเอียดมิเตอร์ - หอพักธนัญญา</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 15px;
            font-family: Arial, "Tahoma", sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,.08);
        }

        h1 {
            color: #198754;
            margin-top: 0;
            margin-bottom: 25px;
        }

        h2 {
            font-size: 20px;
            margin-top: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }

        .label {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .value {
            font-size: 18px;
            font-weight: bold;
        }

        .meter {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 15px;
        }

        .meter-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .meter-row:last-child {
            border-bottom: none;
        }

        .charge {
            color: #198754;
            font-weight: bold;
        }

        .total {
            background: #e9f7ef;
            border-left: 5px solid #198754;
            padding: 20px;
            border-radius: 8px;
            margin-top: 25px;
        }

        .total-title {
            font-size: 18px;
        }

        .total-number {
            font-size: 30px;
            font-weight: bold;
            color: #198754;
            margin-top: 8px;
        }

        .description {
            background: #f8f9fa;
            padding: 18px;
            border-radius: 8px;
            min-height: 80px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .button {
            padding: 12px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
            display: inline-block;
        }

        .back {
            background: #6c757d;
            color: white;
        }

        .edit {
            background: #ffc107;
            color: #212529;
        }

        .delete {
            background: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 12px 20px;
            border-radius: 6px;
        }

        @media(max-width:600px) {

            .info {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 20px;
            }

            .meter-row {
                flex-direction: column;
                gap: 5px;
            }

            .button-group {
                flex-direction: column;
            }

            .button,
            .delete {
                text-align: center;
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>📊 รายละเอียดข้อมูลมิเตอร์</h1>


        <h2>👤 ข้อมูลผู้เช่า</h2>

        <div class="info">

            <div class="info-box">

                <div class="label">
                    ผู้เช่า
                </div>

                <div class="value">

                    @if ($meterReading->tenant)
                        {{ $meterReading->tenant->name }}
                    @else
                        -
                    @endif

                </div>

            </div>


            <div class="info-box">

                <div class="label">
                    ห้องพัก
                </div>

                <div class="value">

                    @if ($meterReading->room)
                        ห้อง {{ $meterReading->room->room_number }}
                    @else
                        -
                    @endif

                </div>

            </div>


            <div class="info-box">

                <div class="label">
                    เดือนที่เรียกเก็บ
                </div>

                <div class="value">
                    {{ $meterReading->billing_month }}
                </div>

            </div>


            <div class="info-box">

                <div class="label">
                    วันที่บันทึก
                </div>

                <div class="value">
                    {{ $meterReading->created_at->format('d/m/Y') }}
                </div>

            </div>

        </div>


        <h2>💧 มิเตอร์น้ำ</h2>

        <div class="meter">

            <div class="meter-row">

                <span>
                    มิเตอร์ครั้งก่อน
                </span>

                <strong>
                    {{ number_format($meterReading->water_previous, 2) }}
                </strong>

            </div>


            <div class="meter-row">

                <span>
                    มิเตอร์ปัจจุบัน
                </span>

                <strong>
                    {{ number_format($meterReading->water_current, 2) }}
                </strong>

            </div>


            <div class="meter-row">

                <span>
                    💧 ใช้น้ำ
                </span>

                <strong>
                    {{ number_format($meterReading->water_unit, 2) }}
                    หน่วย
                </strong>

            </div>


            <div class="meter-row">

                <span>
                    ราคาต่อหน่วย
                </span>

                <strong>
                    {{ number_format($meterReading->water_rate, 2) }}
                    บาท
                </strong>

            </div>


            <div class="meter-row">

                <span>
                    ค่าน้ำ
                </span>

                <strong class="charge">

                    {{ number_format($meterReading->water_charge, 2) }}

                    บาท

                </strong>

            </div>

        </div>


        <h2>⚡ มิเตอร์ไฟฟ้า</h2>

        <div class="meter">

            <div class="meter-row">

                <span>
                    มิเตอร์ครั้งก่อน
                </span>

                <strong>
                    {{ number_format($meterReading->electricity_previous, 2) }}
                </strong>

            </div>


            <div class="meter-row">

                <span>
                    มิเตอร์ปัจจุบัน
                </span>

                <strong>
                    {{ number_format($meterReading->electricity_current, 2) }}
                </strong>

            </div>


            <div class="meter-row">

                <span>
                    ⚡ ใช้ไฟ
                </span>

                <strong>
                    {{ number_format($meterReading->electricity_unit, 2) }}
                    หน่วย
                </strong>

            </div>


            <div class="meter-row">

                <span>
                    ราคาต่อหน่วย
                </span>

                <strong>
                    {{ number_format($meterReading->electricity_rate, 2) }}
                    บาท
                </strong>

            </div>


            <div class="meter-row">

                <span>
                    ค่าไฟ
                </span>

                <strong class="charge">

                    {{ number_format($meterReading->electricity_charge, 2) }}

                    บาท

                </strong>

            </div>

        </div>


        <div class="total">

            <div class="total-title">
                💰 ค่าใช้จ่ายมิเตอร์รวม
            </div>

            <div class="total-number">

                {{ number_format($meterReading->total_charge, 2) }}

                บาท

            </div>

        </div>


        <h2>📝 รายละเอียดเพิ่มเติม</h2>

        <div class="description">

            @if ($meterReading->description)

                {{ $meterReading->description }}

            @else

                ไม่มีรายละเอียดเพิ่มเติม

            @endif

        </div>


        <div class="button-group">

            <a
                href="{{ route('meter-readings.index') }}"
                class="button back"
            >
                ← กลับรายการมิเตอร์
            </a>


            <a
                href="{{ route('meter-readings.edit', $meterReading->id) }}"
                class="button edit"
            >
                ✏️ แก้ไข
            </a>


            <form
                action="{{ route('meter-readings.destroy', $meterReading->id) }}"
                method="POST"
                onsubmit="return confirm('คุณต้องการลบข้อมูลมิเตอร์นี้หรือไม่?')"
                style="display:inline;"
            >

                @csrf

                @method('DELETE')

                <button
                    type="submit"
                    class="delete"
                >
                    🗑️ ลบข้อมูล
                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>