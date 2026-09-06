<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>แก้ไขข้อมูลผู้เช่า - ระบบบริหารจัดการหอพัก</title>

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
            background: white;
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

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            font-size: 16px;
            display: inline-block;
        }

        .btn-success {
            background: #198754;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .error ul {
            margin: 8px 0 0 20px;
            padding: 0;
        }

        .required {
            color: red;
        }

        .input-info {
            margin-top: 6px;
            color: #6c757d;
            font-size: 13px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 15px;
            color: #198754;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .row {
                grid-template-columns: 1fr;
            }

            body {
                padding: 20px 10px;
            }

            .card {
                padding: 20px;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>

</head>

<body>

<div class="container">

    <a href="{{ route('tenants.index') }}" class="back-link">
        ← กลับหน้ารายการผู้เช่า
    </a>

    <div class="card">

        <h1>👤 แก้ไขข้อมูลผู้เช่า</h1>

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
            action="{{ route('tenants.update', $tenant->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            {{-- ชื่อผู้เช่า --}}

            <div class="form-group">

                <label for="name">
                    ชื่อ-นามสกุล
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $tenant->name) }}"
                    placeholder="กรอกชื่อ-นามสกุล"
                    maxlength="255"
                    required
                >

            </div>


            {{-- เลขบัตรประชาชน + เบอร์โทรศัพท์ --}}

            <div class="row">

                <div class="form-group">

                    <label for="id_card">
                        เลขบัตรประชาชน
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="id_card"
                        id="id_card"
                        value="{{ old('id_card', $tenant->id_card) }}"
                        maxlength="13"
                        minlength="13"
                        pattern="[0-9]{13}"
                        inputmode="numeric"
                        placeholder="กรอกเลขบัตรประชาชน 13 หลัก"
                        required
                    >

                    <div class="input-info">
                        🔢 กรุณากรอกตัวเลข 13 หลัก
                    </div>

                </div>


                <div class="form-group">

                    <label for="phone">
                        เบอร์โทรศัพท์
                        <span class="required">*</span>
                    </label>

                    <input
                        type="tel"
                        name="phone"
                        id="phone"
                        value="{{ old('phone', $tenant->phone) }}"
                        maxlength="20"
                        pattern="[0-9]+"
                        inputmode="numeric"
                        placeholder="เช่น 0812345678"
                        required
                    >

                    <div class="input-info">
                        📱 กรอกเฉพาะตัวเลข
                    </div>

                </div>

            </div>


            {{-- อีเมล --}}

            <div class="form-group">

                <label for="email">
                    อีเมล
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', $tenant->email) }}"
                    maxlength="255"
                    placeholder="example@email.com"
                >

            </div>


            {{-- ห้องพัก --}}

            <div class="form-group">

                <label for="room_id">
                    ห้องพัก
                    <span class="required">*</span>
                </label>

                <select
                    name="room_id"
                    id="room_id"
                    required
                >

                    @foreach($rooms as $room)

                        <option
                            value="{{ $room->id }}"
                            {{ old('room_id', $tenant->room_id) == $room->id ? 'selected' : '' }}
                        >

                            ห้อง {{ $room->room_number }}

                            @if($room->floor)
                                - ชั้น {{ $room->floor }}
                            @endif

                            @if($room->room_type)
                                - {{ $room->room_type }}
                            @endif

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- วันที่เข้าพัก + เงินประกัน --}}

            <div class="row">

                <div class="form-group">

                    <label for="move_in_date">
                        วันที่เข้าพัก
                        <span class="required">*</span>
                    </label>

                    <input
                        type="date"
                        name="move_in_date"
                        id="move_in_date"
                        value="{{ old('move_in_date', $tenant->move_in_date) }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="deposit">
                        เงินประกัน
                        <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        name="deposit"
                        id="deposit"
                        value="{{ old('deposit', $tenant->deposit) }}"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                        required
                    >

                    <div class="input-info">
                        💰 จำนวนเงินประกันเป็นบาท
                    </div>

                </div>

            </div>


            {{-- สถานะผู้เช่า --}}

            <div class="form-group">

                <label for="status">
                    สถานะผู้เช่า
                    <span class="required">*</span>
                </label>

                <select
                    name="status"
                    id="status"
                    required
                >

                    <option
                        value="พักอาศัย"
                        {{ old('status', $tenant->status) == 'พักอาศัย' ? 'selected' : '' }}
                    >
                        พักอาศัย
                    </option>

                    <option
                        value="ย้ายออก"
                        {{ old('status', $tenant->status) == 'ย้ายออก' ? 'selected' : '' }}
                    >
                        ย้ายออก
                    </option>

                </select>

            </div>


            {{-- รายละเอียด --}}

            <div class="form-group">

                <label for="description">
                    รายละเอียด
                </label>

                <textarea
                    name="description"
                    id="description"
                    placeholder="รายละเอียดเพิ่มเติม..."
                >{{ old('description', $tenant->description) }}</textarea>

            </div>


            {{-- ปุ่ม --}}

            <div class="button-group">

                <button
                    type="submit"
                    class="btn btn-success"
                >
                    💾 บันทึกการแก้ไข
                </button>

                <a
                    href="{{ route('tenants.index') }}"
                    class="btn btn-secondary"
                >
                    ← ยกเลิก
                </a>

            </div>

        </form>

    </div>

</div>


<script>

    const idCard = document.getElementById('id_card');

    idCard.addEventListener('input', function () {

        this.value = this.value.replace(/[^0-9]/g, '');

        if (this.value.length > 13) {
            this.value = this.value.substring(0, 13);
        }

    });


    const phone = document.getElementById('phone');

    phone.addEventListener('input', function () {

        this.value = this.value.replace(/[^0-9]/g, '');

    });


    const form = document.querySelector('form');

    form.addEventListener('submit', function (event) {

        if (idCard.value.length !== 13) {

            alert('กรุณากรอกเลขบัตรประชาชนให้ครบ 13 หลัก');

            idCard.focus();

            event.preventDefault();

            return;

        }

        if (phone.value.length < 9) {

            alert('กรุณาตรวจสอบเบอร์โทรศัพท์');

            phone.focus();

            event.preventDefault();

            return;

        }

    });

</script>

</body>

</html>