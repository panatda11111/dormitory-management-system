<!DOCTYPE html>
<html lang="th">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

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
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
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

            background: white;
        }

        input:focus,
        select:focus,
        textarea:focus {

            outline: none;

            border-color: #198754;

            box-shadow: 0 0 0 2px rgba(25,135,84,0.1);
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

        .room-info {

            background: #e9f7ef;

            color: #198754;

            padding: 12px;

            margin-top: 8px;

            border-radius: 6px;

            font-size: 14px;

            font-weight: bold;
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

        .disabled-message {

            color: #dc3545;

            font-size: 14px;

            margin-top: 6px;
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

        <h1>
            🧾 เพิ่มใบแจ้งค่าใช้จ่าย
        </h1>


        {{-- =====================================================
             แสดงข้อผิดพลาด
        ====================================================== --}}

        @if ($errors->any())

            <div class="error">

                <strong>
                    ⚠️ กรุณาตรวจสอบข้อมูล
                </strong>

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =====================================================
             ตรวจสอบผู้เช่า
        ====================================================== --}}

        @if ($tenants->count() === 0)

            <div class="info">

                ⚠️ ขณะนี้ยังไม่มีผู้เช่าที่สามารถสร้าง
                ใบแจ้งค่าใช้จ่ายได้

            </div>

        @endif


        {{-- =====================================================
             FORM
        ====================================================== --}}

        <form
            action="{{ route('bills.store') }}"
            method="POST"
        >

            @csrf


            {{-- =================================================
                 ผู้เช่า
            ================================================== --}}

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

                                -
                                ห้อง {{ $tenant->room->room_number }}

                            </option>

                        @endif

                    @endforeach

                </select>


                <span class="hint">

                    👤 เลือกผู้เช่าที่ต้องการออกใบแจ้งค่าใช้จ่าย

                </span>

            </div>


            {{-- =================================================
                 ห้องพัก
            ================================================== --}}

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


            {{-- =================================================
                 เดือนที่เรียกเก็บ
            ================================================== --}}

            <div class="form-group">

                <label for="billing_month">

                    📅 เดือนที่เรียกเก็บ

                    <span class="required">*</span>

                </label>


                <input

                    type="text"

                    name="billing_month"

                    id="billing_month"

                    value="{{ old('billing_month') }}"

                    placeholder="เช่น พฤศจิกายน 2569"

                    autocomplete="off"

                    required

                >


                <span class="hint">

                    📅 ตัวอย่าง: พฤศจิกายน 2569

                </span>

            </div>


            {{-- =================================================
                 ค่าเช่า + ค่าน้ำ
            ================================================== --}}

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

                        required

                    >

                </div>

            </div>


            {{-- =================================================
                 ค่าไฟ + ค่าใช้จ่ายอื่น
            ================================================== --}}

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

                        required

                    >

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


            {{-- =================================================
                 ยอดรวม
            ================================================== --}}

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


            {{-- =================================================
                 วันครบกำหนด
            ================================================== --}}

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


            {{-- =================================================
                 สถานะ
            ================================================== --}}

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


            {{-- =================================================
                 รายละเอียด
            ================================================== --}}

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


            {{-- =================================================
                 ปุ่ม
            ================================================== --}}

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

    // =========================================================
    // รับ Element
    // =========================================================

    const tenantSelect =
        document.getElementById('tenant_id');

    const roomSelect =
        document.getElementById('room_id');

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


    // =========================================================
    // เมื่อเลือกผู้เช่า
    // =========================================================

    function updateTenantInformation() {

        const selectedOption =
            tenantSelect.options[
                tenantSelect.selectedIndex
            ];


        // ยังไม่ได้เลือกผู้เช่า

        if (
            !selectedOption ||
            !selectedOption.value
        ) {

            roomSelect.innerHTML = `
                <option value="">
                    -- เลือกผู้เช่าก่อน --
                </option>
            `;

            rentInput.value = 0;

            roomInfo.style.display = 'none';

            calculateTotal();

            return;
        }


        // =====================================================
        // ข้อมูลห้อง
        // =====================================================

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


        // =====================================================
        // เปลี่ยนห้องพักอัตโนมัติ
        // =====================================================

        roomSelect.innerHTML = '';


        if (roomId) {

            const roomOption =
                document.createElement('option');

            roomOption.value =
                roomId;

            roomOption.textContent =
                'ห้อง ' + roomNumber;

            roomOption.selected =
                true;

            roomSelect.appendChild(
                roomOption
            );

        }


        // =====================================================
        // ใส่ค่าเช่าอัตโนมัติ
        // =====================================================

        rentInput.value =
            rent || 0;


        // =====================================================
        // แสดงข้อมูลห้อง
        // =====================================================

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


        roomInfo.textContent =
            info;

        roomInfo.style.display =
            'block';


        // =====================================================
        // คำนวณยอดรวม
        // =====================================================

        calculateTotal();

    }


    // =========================================================
    // คำนวณยอดรวม
    // =========================================================

    function calculateTotal() {

        const rent =
            parseFloat(
                rentInput.value
            ) || 0;


        const water =
            parseFloat(
                waterInput.value
            ) || 0;


        const electricity =
            parseFloat(
                electricityInput.value
            ) || 0;


        const other =
            parseFloat(
                otherInput.value
            ) || 0;


        const total =
            rent +
            water +
            electricity +
            other;


        totalElement.textContent =
            total.toLocaleString(
                'th-TH',
                {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }
            );

    }


    // =========================================================
    // Event เลือกผู้เช่า
    // =========================================================

    tenantSelect.addEventListener(
        'change',
        updateTenantInformation
    );


    // =========================================================
    // Event คำนวณเงิน
    // =========================================================

    rentInput.addEventListener(
        'input',
        calculateTotal
    );


    waterInput.addEventListener(
        'input',
        calculateTotal
    );


    electricityInput.addEventListener(
        'input',
        calculateTotal
    );


    otherInput.addEventListener(
        'input',
        calculateTotal
    );


    // =========================================================
    // โหลดหน้าเว็บ
    // =========================================================

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            if (tenantSelect.value) {

                updateTenantInformation();

            }

            calculateTotal();

        }
    );

</script>


</body>

</html>