<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>เพิ่มใบแจ้งค่าใช้จ่าย - หอพักธนัญญา</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        .card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;
            color: #198754;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 16px;
            font-family: inherit;
            background: #fff;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #198754;
            box-shadow: 0 0 0 2px rgba(25, 135, 84, 0.1);
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .total {
            background: #e9f7ef;
            border-left: 5px solid #198754;
            padding: 18px;
            margin: 25px 0;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
        }

        .total-amount {
            color: #198754;
            font-size: 28px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .button {
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            display: inline-block;
        }

        .save {
            background: #198754;
            color: white;
        }

        .save:hover {
            background: #157347;
        }

        .back {
            background: #6c757d;
            color: white;
        }

        .back:hover {
            background: #5c636a;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .info {
            background: #cff4fc;
            color: #055160;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .success-info {
            background: #d1e7dd;
            color: #0f5132;
            padding: 12px;
            margin-top: 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        .warning-info {
            background: #fff3cd;
            color: #664d03;
            padding: 12px;
            margin-top: 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        .room-info {
            background: #e9f7ef;
            color: #198754;
            padding: 12px;
            margin-top: 8px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
        }

        .meter-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-top: 10px;
            border-radius: 8px;
            display: none;
        }

        .meter-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #198754;
        }

        .meter-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .meter-box {
            background: white;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .meter-label {
            font-size: 13px;
            color: #6c757d;
        }

        .meter-value {
            font-size: 18px;
            font-weight: bold;
            margin-top: 3px;
        }

        .hint {
            display: block;
            margin-top: 5px;
            color: #6c757d;
            font-size: 13px;
        }

        .required {
            color: red;
        }

        .readonly-input {
            background: #f8f9fa;
            cursor: not-allowed;
        }

        .loading {
            color: #6c757d;
            font-size: 14px;
            margin-top: 8px;
        }

        @media (max-width: 600px) {
            body {
                padding: 20px 10px;
            }

            .card {
                padding: 20px;
            }

            .row {
                grid-template-columns: 1fr;
            }

            .meter-grid {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }

            .button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>🧾 เพิ่มใบแจ้งค่าใช้จ่าย</h1>

        {{-- แสดงข้อผิดพลาด --}}
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

        {{-- ไม่มีผู้เช่า --}}
        @if ($tenants->count() === 0)
            <div class="info">
                ⚠️ ขณะนี้ยังไม่มีผู้เช่าที่มีสถานะ "พักอาศัย"
            </div>
        @endif

        <form
            action="{{ route('bills.store') }}"
            method="POST"
        >

            @csrf

            {{-- ==========================================
                 ผู้เช่า
            =========================================== --}}
            <div class="form-group">

                <label for="tenant_id">
                    👤 ผู้เช่า
                    <span class="required">*</span>
                </label>

                <select
                    name="tenant_id"
                    id="tenant_id"
                    required
                >

                    <option value="">
                        -- เลือกผู้เช่า --
                    </option>

                    @foreach ($tenants as $tenant)

                        @if ($tenant->room)

                            <option
                                value="{{ $tenant->id }}"

                                data-room-id="{{ $tenant->room->id }}"

                                data-room-number="{{ $tenant->room->room_number }}"

                                data-floor="{{ $tenant->room->floor ?? '' }}"

                                data-room-type="{{ $tenant->room->room_type ?? '' }}"

                                data-rent="{{ $tenant->room->rent ?? 0 }}"

                                {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}
                            >

                                {{ $tenant->name }}
                                - ห้อง {{ $tenant->room->room_number }}

                            </option>

                        @endif

                    @endforeach

                </select>

                <span class="hint">
                    👤 เลือกผู้เช่าที่ต้องการออกใบแจ้งค่าใช้จ่าย
                </span>

            </div>


            {{-- ==========================================
                 ห้องพัก
            =========================================== --}}
            <div class="form-group">

                <label for="room_id">
                    🏠 ห้องพัก
                    <span class="required">*</span>
                </label>

                <select
                    name="room_id"
                    id="room_id"
                    required
                >

                    <option value="">
                        -- เลือกผู้เช่าก่อน --
                    </option>

                </select>

                <div
                    id="roomInfo"
                    class="room-info"
                    style="display:none;"
                ></div>

            </div>


            {{-- ==========================================
                 เดือนที่เรียกเก็บ
            =========================================== --}}
            <div class="form-group">

                <label for="billing_month">
                    📅 เดือนที่เรียกเก็บ
                    <span class="required">*</span>
                </label>

                <select
                    name="billing_month"
                    id="billing_month"
                    required
                >

                    <option value="">
                        -- เลือกผู้เช่าก่อน --
                    </option>

                </select>

                <span class="hint">
                    📅 เลือกเฉพาะเดือนที่มีข้อมูลมิเตอร์ของผู้เช่าคนนั้น
                </span>

            </div>


            {{-- ==========================================
                 ข้อมูลมิเตอร์
            =========================================== --}}
            <div
                id="meterInfo"
                class="meter-info"
            >

                <div class="meter-title">
                    📊 ข้อมูลมิเตอร์
                </div>

                <div class="meter-grid">

                    <div class="meter-box">

                        <div class="meter-label">
                            💧 หน่วยน้ำ
                        </div>

                        <div
                            id="waterUnit"
                            class="meter-value"
                        >
                            0
                        </div>

                    </div>


                    <div class="meter-box">

                        <div class="meter-label">
                            💧 ค่าน้ำ
                        </div>

                        <div
                            id="waterCharge"
                            class="meter-value"
                        >
                            0.00 บาท
                        </div>

                    </div>


                    <div class="meter-box">

                        <div class="meter-label">
                            ⚡ หน่วยไฟ
                        </div>

                        <div
                            id="electricityUnit"
                            class="meter-value"
                        >
                            0
                        </div>

                    </div>


                    <div class="meter-box">

                        <div class="meter-label">
                            ⚡ ค่าไฟ
                        </div>

                        <div
                            id="electricityCharge"
                            class="meter-value"
                        >
                            0.00 บาท
                        </div>

                    </div>

                </div>

            </div>

            <div id="meterMessage"></div>


            {{-- ==========================================
                 ค่าเช่า + ค่าน้ำ
            =========================================== --}}
            <div class="row">

                <div class="form-group">

                    <label for="rent">
                        🏠 ค่าเช่า (บาท)
                        <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        name="rent"
                        id="rent"
                        value="{{ old('rent', 0) }}"
                        min="0"
                        step="0.01"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="water">
                        💧 ค่าน้ำ (บาท)
                        <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        name="water"
                        id="water"
                        value="{{ old('water', 0) }}"
                        min="0"
                        step="0.01"
                        readonly
                        class="readonly-input"
                    >

                    <span class="hint">
                        ระบบจะดึงจากข้อมูลมิเตอร์อัตโนมัติ
                    </span>

                </div>

            </div>


            {{-- ==========================================
                 ค่าไฟ + ค่าใช้จ่ายอื่น
            =========================================== --}}
            <div class="row">

                <div class="form-group">

                    <label for="electricity">
                        ⚡ ค่าไฟ (บาท)
                        <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        name="electricity"
                        id="electricity"
                        value="{{ old('electricity', 0) }}"
                        min="0"
                        step="0.01"
                        readonly
                        class="readonly-input"
                    >

                    <span class="hint">
                        ระบบจะดึงจากข้อมูลมิเตอร์อัตโนมัติ
                    </span>

                </div>


                <div class="form-group">

                    <label for="other_charge">
                        💰 ค่าใช้จ่ายอื่น (บาท)
                    </label>

                    <input
                        type="number"
                        name="other_charge"
                        id="other_charge"
                        value="{{ old('other_charge', 0) }}"
                        min="0"
                        step="0.01"
                    >

                </div>

            </div>


            {{-- ==========================================
                 ยอดรวม
            =========================================== --}}
            <div class="total">

                💰 ยอดรวมทั้งหมด:

                <span
                    id="total"
                    class="total-amount"
                >
                    0.00
                </span>

                บาท

            </div>


            {{-- ==========================================
                 วันครบกำหนด
            =========================================== --}}
            <div class="form-group">

                <label for="due_date">

                    📅 วันครบกำหนดชำระ

                    <span class="required">*</span>

                </label>

                <input
                    type="date"
                    name="due_date"
                    id="due_date"
                    value="{{ old('due_date') }}"
                    required
                >

            </div>


            {{-- ==========================================
                 สถานะ
            =========================================== --}}
            <div class="form-group">

                <label for="status">

                    📌 สถานะ

                    <span class="required">*</span>

                </label>

                <select
                    name="status"
                    id="status"
                    required
                >

                    <option
                        value="ค้างชำระ"
                        {{ old('status', 'ค้างชำระ') == 'ค้างชำระ' ? 'selected' : '' }}
                    >
                        ค้างชำระ
                    </option>

                    <option
                        value="ชำระแล้ว"
                        {{ old('status') == 'ชำระแล้ว' ? 'selected' : '' }}
                    >
                        ชำระแล้ว
                    </option>

                    <option
                        value="เกินกำหนด"
                        {{ old('status') == 'เกินกำหนด' ? 'selected' : '' }}
                    >
                        เกินกำหนด
                    </option>

                </select>

            </div>


            {{-- ==========================================
                 รายละเอียด
            =========================================== --}}
            <div class="form-group">

                <label for="description">
                    📝 รายละเอียดเพิ่มเติม
                </label>

                <textarea
                    name="description"
                    id="description"
                    placeholder="รายละเอียดเพิ่มเติม (ถ้ามี)"
                >{{ old('description') }}</textarea>

            </div>


            {{-- ==========================================
                 ปุ่ม
            =========================================== --}}
            <div class="button-group">

                <button
                    type="submit"
                    class="button save"
                >
                    💾 บันทึกใบแจ้งค่าใช้จ่าย
                </button>

                <a
                    href="{{ route('bills.index') }}"
                    class="button back"
                >
                    ← ยกเลิก
                </a>

            </div>

        </form>

    </div>

</div>


<script>

    /*
    |--------------------------------------------------------------------------
    | ข้อมูลมิเตอร์จาก Laravel
    |--------------------------------------------------------------------------
    */

    const meterReadings = @json($meterReadings);


    /*
    |--------------------------------------------------------------------------
    | Element
    |--------------------------------------------------------------------------
    */

    const tenantSelect =
        document.getElementById('tenant_id');

    const roomSelect =
        document.getElementById('room_id');

    const billingMonthSelect =
        document.getElementById('billing_month');

    const rentInput =
        document.getElementById('rent');

    const waterInput =
        document.getElementById('water');

    const electricityInput =
        document.getElementById('electricity');

    const otherInput =
        document.getElementById('other_charge');

    const totalElement =
        document.getElementById('total');

    const roomInfo =
        document.getElementById('roomInfo');

    const meterInfo =
        document.getElementById('meterInfo');

    const meterMessage =
        document.getElementById('meterMessage');

    const waterUnitElement =
        document.getElementById('waterUnit');

    const waterChargeElement =
        document.getElementById('waterCharge');

    const electricityUnitElement =
        document.getElementById('electricityUnit');

    const electricityChargeElement =
        document.getElementById('electricityCharge');


    /*
    |--------------------------------------------------------------------------
    | แปลงตัวเลข
    |--------------------------------------------------------------------------
    */

    function number(value) {

        return parseFloat(value) || 0;

    }


    /*
    |--------------------------------------------------------------------------
    | เงิน
    |--------------------------------------------------------------------------
    */

    function money(value) {

        return number(value).toLocaleString(
            'th-TH',
            {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | ล้างข้อมูลมิเตอร์
    |--------------------------------------------------------------------------
    */

    function clearMeter() {

        waterInput.value = '0.00';

        electricityInput.value = '0.00';

        waterUnitElement.textContent = '0';

        waterChargeElement.textContent = '0.00 บาท';

        electricityUnitElement.textContent = '0';

        electricityChargeElement.textContent = '0.00 บาท';

        meterInfo.style.display = 'none';

        meterMessage.innerHTML = '';

    }


    /*
    |--------------------------------------------------------------------------
    | คำนวณยอดรวม
    |--------------------------------------------------------------------------
    */

    function calculateTotal() {

        const rent =
            number(rentInput.value);

        const water =
            number(waterInput.value);

        const electricity =
            number(electricityInput.value);

        const other =
            number(otherInput.value);

        const total =
            rent +
            water +
            electricity +
            other;

        totalElement.textContent =
            money(total);

    }


    /*
    |--------------------------------------------------------------------------
    | แสดงห้องและค่าเช่าของผู้เช่า
    |--------------------------------------------------------------------------
    */

    function updateTenantInformation() {

        const selectedOption =
            tenantSelect.options[
                tenantSelect.selectedIndex
            ];


        /*
        | ถ้ายังไม่ได้เลือกผู้เช่า
        */

        if (
            !selectedOption ||
            !selectedOption.value
        ) {

            roomSelect.innerHTML = `
                <option value="">
                    -- เลือกผู้เช่าก่อน --
                </option>
            `;

            billingMonthSelect.innerHTML = `
                <option value="">
                    -- เลือกผู้เช่าก่อน --
                </option>
            `;

            rentInput.value = '0';

            roomInfo.style.display = 'none';

            clearMeter();

            calculateTotal();

            return;
        }


        /*
        | ข้อมูลห้อง
        */

        const roomId =
            selectedOption.dataset.roomId;

        const roomNumber =
            selectedOption.dataset.roomNumber;

        const floor =
            selectedOption.dataset.floor;

        const roomType =
            selectedOption.dataset.roomType;

        const rent =
            selectedOption.dataset.rent;


        /*
        | แสดงห้อง
        */

        roomSelect.innerHTML = '';

        if (roomId) {

            const option =
                document.createElement('option');

            option.value = roomId;

            option.textContent =
                'ห้อง ' + roomNumber;

            option.selected = true;

            roomSelect.appendChild(option);

        }


        /*
        | ค่าเช่า
        */

        rentInput.value =
            rent || 0;


        /*
        | รายละเอียดห้อง
        */

        let info =
            '🏠 ห้อง ' + roomNumber;

        if (floor) {

            info +=
                ' | ชั้น ' + floor;

        }

        if (roomType) {

            info +=
                ' | ' + roomType;

        }

        roomInfo.textContent = info;

        roomInfo.style.display = 'block';


        /*
        | สร้างรายการเดือน
        */

        updateBillingMonths();

    }


    /*
    |--------------------------------------------------------------------------
    | สร้างรายการเดือนจากข้อมูลมิเตอร์ของผู้เช่า
    |--------------------------------------------------------------------------
    */

    function updateBillingMonths() {

        const tenantId =
            tenantSelect.value;

        const roomId =
            roomSelect.value;


        billingMonthSelect.innerHTML = `
            <option value="">
                -- เลือกเดือนที่มีข้อมูลมิเตอร์ --
            </option>
        `;

        clearMeter();


        if (!tenantId || !roomId) {

            calculateTotal();

            return;

        }


        /*
        | กรองข้อมูลมิเตอร์
        */

        const tenantMeters =
            meterReadings.filter(function (item) {

                return (
                    String(item.tenant_id) === String(tenantId) &&
                    String(item.room_id) === String(roomId)
                );

            });


        /*
        | ป้องกันเดือนซ้ำ
        */

        const uniqueMonths = [];

        tenantMeters.forEach(function (item) {

            const month =
                String(item.billing_month || '').trim();

            if (
                month &&
                !uniqueMonths.includes(month)
            ) {

                uniqueMonths.push(month);

            }

        });


        /*
        | เรียงรายการเดือนล่าสุดก่อน
        */

        uniqueMonths.sort(function(a, b) {

            return b.localeCompare(
                a,
                'th',
                {
                    numeric: true
                }
            );

        });


        /*
        | ไม่มีข้อมูลมิเตอร์
        */

        if (uniqueMonths.length === 0) {

            billingMonthSelect.innerHTML = `
                <option value="">
                    -- ไม่พบข้อมูลมิเตอร์ --
                </option>
            `;

            meterMessage.innerHTML = `
                <div class="warning-info">
                    ⚠️ ผู้เช่ารายนี้ยังไม่มีข้อมูลมิเตอร์
                </div>
            `;

            calculateTotal();

            return;

        }


        /*
        | เพิ่มเดือนลง Select
        */

        uniqueMonths.forEach(function(month) {

            const option =
                document.createElement('option');

            option.value = month;

            option.textContent = month;

            billingMonthSelect.appendChild(option);

        });


        /*
        | ถ้ามีค่าเดิมจาก validation
        */

        const oldMonth =
            @json(old('billing_month'));

        if (
            oldMonth &&
            uniqueMonths.includes(oldMonth)
        ) {

            billingMonthSelect.value =
                oldMonth;

            findMeterReading();

        }

    }


    /*
    |--------------------------------------------------------------------------
    | ค้นหาข้อมูลมิเตอร์
    |--------------------------------------------------------------------------
    */

    function findMeterReading() {

        const tenantId =
            tenantSelect.value;

        const roomId =
            roomSelect.value;

        const billingMonth =
            billingMonthSelect.value.trim();


        clearMeter();


        if (
            !tenantId ||
            !roomId ||
            !billingMonth
        ) {

            calculateTotal();

            return;

        }


        /*
        | ค้นหามิเตอร์
        */

        const meter =
            meterReadings.find(function(item) {

                return (
                    String(item.tenant_id) === String(tenantId) &&
                    String(item.room_id) === String(roomId) &&
                    String(item.billing_month).trim() === billingMonth
                );

            });


        /*
        | พบมิเตอร์
        */

        if (meter) {

            const waterCharge =
                number(meter.water_charge);

            const electricityCharge =
                number(meter.electricity_charge);


            /*
            | ค่าน้ำ
            */

            waterInput.value =
                waterCharge.toFixed(2);


            /*
            | ค่าไฟ
            */

            electricityInput.value =
                electricityCharge.toFixed(2);


            /*
            | หน่วยน้ำ
            */

            waterUnitElement.textContent =
                number(meter.water_unit).toFixed(2);


            waterChargeElement.textContent =
                money(waterCharge) +
                ' บาท';


            /*
            | หน่วยไฟ
            */

            electricityUnitElement.textContent =
                number(meter.electricity_unit).toFixed(2);


            electricityChargeElement.textContent =
                money(electricityCharge) +
                ' บาท';


            /*
            | แสดงข้อมูล
            */

            meterInfo.style.display =
                'block';


            meterMessage.innerHTML = `
                <div class="success-info">
                    ✓ พบข้อมูลมิเตอร์ของเดือน ${billingMonth}
                    ระบบนำค่าน้ำและค่าไฟมาใช้ในใบแจ้งค่าใช้จ่ายแล้ว
                </div>
            `;

        } else {

            waterInput.value =
                '0.00';

            electricityInput.value =
                '0.00';


            meterMessage.innerHTML = `
                <div class="warning-info">
                    ⚠️ ไม่พบข้อมูลมิเตอร์ของเดือน ${billingMonth}
                </div>
            `;

        }


        calculateTotal();

    }


    /*
    |--------------------------------------------------------------------------
    | Event ผู้เช่า
    |--------------------------------------------------------------------------
    */

    tenantSelect.addEventListener(
        'change',
        function() {

            updateTenantInformation();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Event เดือน
    |--------------------------------------------------------------------------
    */

    billingMonthSelect.addEventListener(
        'change',
        function() {

            findMeterReading();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Event ค่าเช่า
    |--------------------------------------------------------------------------
    */

    rentInput.addEventListener(
        'input',
        calculateTotal
    );


    /*
    |--------------------------------------------------------------------------
    | Event ค่าใช้จ่ายอื่น
    |--------------------------------------------------------------------------
    */

    otherInput.addEventListener(
        'input',
        calculateTotal
    );


    /*
    |--------------------------------------------------------------------------
    | โหลดหน้า
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function() {

            if (tenantSelect.value) {

                updateTenantInformation();

            }

            calculateTotal();

        }
    );

</script>

</body>
</html>