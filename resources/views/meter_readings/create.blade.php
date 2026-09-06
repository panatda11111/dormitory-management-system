<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>เพิ่มข้อมูลมิเตอร์ - ระบบบริหารจัดการหอพัก</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 15px;
            font-family: Arial, Tahoma, sans-serif;
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
            box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
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

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 16px;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #198754;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .unit {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .result {
            background: #e9f7ef;
            border-left: 5px solid #198754;
            padding: 18px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .result-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .total {
            font-size: 24px;
            font-weight: bold;
            color: #198754;
            border-top: 1px solid #ccc;
            margin-top: 10px;
            padding-top: 12px;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 15px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .hint {
            color: #6c757d;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        button,
        .button {
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            font-size: 16px;
        }

        .save {
            background: #198754;
            color: white;
        }

        .back {
            background: #6c757d;
            color: white;
        }

        @media (max-width: 600px) {
            .row {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 20px;
            }

            .button-group {
                flex-direction: column;
            }

            .button {
                text-align: center;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>📊 เพิ่มข้อมูลมิเตอร์</h1>

        @if ($errors->any())
            <div class="error">

                <strong>⚠️ กรุณาตรวจสอบข้อมูล</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        <form
            action="{{ route('meter-readings.store') }}"
            method="POST"
        >

            @csrf

            <h2>👤 ข้อมูลผู้เช่า</h2>

            <div class="form-group">

                <label for="tenant_id">
                    ผู้เช่า *
                </label>

                <select name="tenant_id" id="tenant_id" required>

                    <option value="">
                        -- เลือกผู้เช่า --
                    </option>

                    @foreach ($tenants as $tenant)

                        <option
                            value="{{ $tenant->id }}"
                            data-room="{{ $tenant->room_id }}"
                            {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}
                        >

                            {{ $tenant->name }}

                            @if ($tenant->room)
                                - ห้อง {{ $tenant->room->room_number }}
                            @endif

                        </option>

                    @endforeach

                </select>

                <span class="hint">
                    เลือกผู้เช่าที่ต้องการบันทึกมิเตอร์
                </span>

            </div>


            <div class="form-group">

                <label for="room_id">
                    ห้องพัก *
                </label>

                <select name="room_id" id="room_id" required>

                    <option value="">
                        -- เลือกผู้เช่าก่อน --
                    </option>

                    @foreach ($rooms as $room)

                        <option
                            value="{{ $room->id }}"
                            {{ old('room_id') == $room->id ? 'selected' : '' }}
                        >

                            ห้อง {{ $room->room_number }}

                            @if ($room->floor)
                                - ชั้น {{ $room->floor }}
                            @endif

                        </option>

                    @endforeach

                </select>

            </div>


            <div class="form-group">

                <label for="billing_month">
                    📅 เดือนที่เรียกเก็บ *
                </label>

                <input
                    type="text"
                    name="billing_month"
                    id="billing_month"
                    value="{{ old('billing_month') }}"
                    placeholder="เช่น กันยายน 2569"
                    maxlength="50"
                    required
                >

                <span class="hint">
                    กรุณาระบุเดือนและปี เช่น กันยายน 2569
                </span>

            </div>


            <h2>💧 มิเตอร์น้ำ</h2>

            <div class="row">

                <div class="form-group">

                    <label for="water_previous">
                        มิเตอร์ครั้งก่อน
                    </label>

                    <input
                        type="number"
                        name="water_previous"
                        id="water_previous"
                        value="{{ old('water_previous', 0) }}"
                        min="0"
                        step="0.01"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="water_current">
                        มิเตอร์ปัจจุบัน
                    </label>

                    <input
                        type="number"
                        name="water_current"
                        id="water_current"
                        value="{{ old('water_current', 0) }}"
                        min="0"
                        step="0.01"
                        required
                    >

                </div>

            </div>


            <div class="row">

                <div class="form-group">

                    <label for="water_rate">
                        ราคาต่อหน่วย (บาท)
                    </label>

                    <input
                        type="number"
                        name="water_rate"
                        id="water_rate"
                        value="{{ old('water_rate', 6) }}"
                        min="0"
                        step="0.01"
                        required
                    >

                </div>


                <div class="unit">

                    💧 ใช้น้ำ

                    <strong id="water_unit">
                        0.00
                    </strong>

                    หน่วย

                </div>

            </div>


            <h2>⚡ มิเตอร์ไฟฟ้า</h2>

            <div class="row">

                <div class="form-group">

                    <label for="electricity_previous">
                        มิเตอร์ครั้งก่อน
                    </label>

                    <input
                        type="number"
                        name="electricity_previous"
                        id="electricity_previous"
                        value="{{ old('electricity_previous', 0) }}"
                        min="0"
                        step="0.01"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="electricity_current">
                        มิเตอร์ปัจจุบัน
                    </label>

                    <input
                        type="number"
                        name="electricity_current"
                        id="electricity_current"
                        value="{{ old('electricity_current', 0) }}"
                        min="0"
                        step="0.01"
                        required
                    >

                </div>

            </div>


            <div class="row">

                <div class="form-group">

                    <label for="electricity_rate">
                        ราคาต่อหน่วย (บาท)
                    </label>

                    <input
                        type="number"
                        name="electricity_rate"
                        id="electricity_rate"
                        value="{{ old('electricity_rate', 8) }}"
                        min="0"
                        step="0.01"
                        required
                    >

                </div>


                <div class="unit">

                    ⚡ ใช้ไฟ

                    <strong id="electricity_unit">
                        0.00
                    </strong>

                    หน่วย

                </div>

            </div>


            <div class="result">

                <div class="result-row">

                    <span>💧 ค่าน้ำ</span>

                    <strong>
                        <span id="water_charge">
                            0.00
                        </span>
                        บาท
                    </strong>

                </div>


                <div class="result-row">

                    <span>⚡ ค่าไฟ</span>

                    <strong>
                        <span id="electricity_charge">
                            0.00
                        </span>
                        บาท
                    </strong>

                </div>


                <div class="result-row total">

                    <span>💰 รวมทั้งหมด</span>

                    <span>
                        <span id="total_charge">
                            0.00
                        </span>
                        บาท
                    </span>

                </div>

            </div>


            <h2>📝 รายละเอียด</h2>

            <div class="form-group">

                <label for="description">
                    รายละเอียดเพิ่มเติม
                </label>

                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    placeholder="รายละเอียดเพิ่มเติม (ถ้ามี)"
                >{{ old('description') }}</textarea>

            </div>


            <div class="button-group">

                <button type="submit" class="save">
                    💾 บันทึกข้อมูลมิเตอร์
                </button>

                <a
                    href="{{ route('meter-readings.index') }}"
                    class="button back"
                >
                    ← ยกเลิก
                </a>

            </div>

        </form>

    </div>

</div>


<script>

const tenantSelect =
    document.getElementById('tenant_id');

const roomSelect =
    document.getElementById('room_id');

const waterPrevious =
    document.getElementById('water_previous');

const waterCurrent =
    document.getElementById('water_current');

const waterRate =
    document.getElementById('water_rate');

const electricityPrevious =
    document.getElementById('electricity_previous');

const electricityCurrent =
    document.getElementById('electricity_current');

const electricityRate =
    document.getElementById('electricity_rate');


function numberValue(element)
{
    return parseFloat(element.value) || 0;
}


function calculate()
{
    const waterUnit =
        Math.max(
            0,
            numberValue(waterCurrent)
            -
            numberValue(waterPrevious)
        );

    const waterCharge =
        waterUnit *
        numberValue(waterRate);


    const electricityUnit =
        Math.max(
            0,
            numberValue(electricityCurrent)
            -
            numberValue(electricityPrevious)
        );

    const electricityCharge =
        electricityUnit *
        numberValue(electricityRate);


    const total =
        waterCharge +
        electricityCharge;


    document.getElementById('water_unit')
        .textContent =
        waterUnit.toFixed(2);


    document.getElementById('water_charge')
        .textContent =
        waterCharge.toLocaleString(
            'th-TH',
            {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }
        );


    document.getElementById('electricity_unit')
        .textContent =
        electricityUnit.toFixed(2);


    document.getElementById('electricity_charge')
        .textContent =
        electricityCharge.toLocaleString(
            'th-TH',
            {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }
        );


    document.getElementById('total_charge')
        .textContent =
        total.toLocaleString(
            'th-TH',
            {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }
        );
}


tenantSelect.addEventListener(
    'change',
    function()
    {
        const option =
            this.options[this.selectedIndex];

        const roomId =
            option.dataset.room;

        if (roomId)
        {
            roomSelect.value = roomId;
        }

        calculate();
    }
);


[
    waterPrevious,
    waterCurrent,
    waterRate,
    electricityPrevious,
    electricityCurrent,
    electricityRate
].forEach(
    function(element)
    {
        element.addEventListener(
            'input',
            calculate
        );
    }
);


calculate();

</script>

</body>

</html>