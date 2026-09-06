<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>เพิ่มผู้เช่า - หอพักธนัญญา</title>

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

        .required {
            color: red;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .hint {
            display: block;
            margin-top: 5px;
            color: #6c757d;
            font-size: 13px;
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

        .empty-room {
            color: #dc3545;
            margin-top: 5px;
            font-size: 14px;
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

        <h1>👤 เพิ่มข้อมูลผู้เช่า</h1>

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


        {{-- ฟอร์มเพิ่มผู้เช่า --}}
        <form
            action="{{ route('tenants.store') }}"
            method="POST"
        >

            @csrf


            {{-- ชื่อผู้เช่า --}}
            <div class="form-group">

                <label for="name">
                    👤 ชื่อ-นามสกุล
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    placeholder="กรอกชื่อ-นามสกุล"
                    maxlength="255"
                    required
                >

            </div>


            {{-- เลขบัตร + เบอร์โทร --}}
            <div class="row">

                <div class="form-group">

                    <label for="id_card">
                        🪪 เลขบัตรประชาชน
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="id_card"
                        id="id_card"
                        value="{{ old('id_card') }}"
                        maxlength="13"
                        minlength="13"
                        pattern="[0-9]{13}"
                        inputmode="numeric"
                        placeholder="เลขบัตรประชาชน 13 หลัก"
                        required
                    >

                    <span class="hint">
                        กรุณากรอกตัวเลข 13 หลัก
                    </span>

                </div>


                <div class="form-group">

                    <label for="phone">
                        📞 เบอร์โทรศัพท์
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="phone"
                        id="phone"
                        value="{{ old('phone') }}"
                        maxlength="20"
                        placeholder="เช่น 0812345678"
                        required
                    >

                </div>

            </div>


            {{-- อีเมล --}}
            <div class="form-group">

                <label for="email">
                    📧 อีเมล
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    placeholder="example@email.com"
                >

            </div>


            {{-- ห้องพัก --}}
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
                        -- เลือกห้องพัก --
                    </option>

                    @forelse ($rooms as $room)

                        <option
                            value="{{ $room->id }}"
                            {{ old('room_id') == $room->id ? 'selected' : '' }}
                        >
                            ห้อง {{ $room->room_number }}
                        </option>

                    @empty

                        <option value="" disabled>
                            ไม่มีห้องว่าง
                        </option>

                    @endforelse

                </select>

                @if ($rooms->count() > 0)

                    <span class="hint">
                        🟢 แสดงเฉพาะห้องที่มีสถานะว่าง
                    </span>

                @else

                    <span class="empty-room">
                        ⚠️ ขณะนี้ไม่มีห้องว่าง
                    </span>

                @endif

            </div>


            {{-- วันที่เข้าพัก + เงินประกัน --}}
            <div class="row">

                <div class="form-group">

                    <label for="move_in_date">
                        📅 วันที่เข้าพัก
                        <span class="required">*</span>
                    </label>

                    <input
                        type="date"
                        name="move_in_date"
                        id="move_in_date"
                        value="{{ old('move_in_date') }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="deposit">
                        💰 เงินประกัน (บาท)
                        <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        name="deposit"
                        id="deposit"
                        value="{{ old('deposit', 0) }}"
                        min="0"
                        step="0.01"
                        required
                    >

                </div>

            </div>


            {{-- สถานะผู้เช่า --}}
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
                        value="พักอาศัย"
                        {{ old('status', 'พักอาศัย') == 'พักอาศัย' ? 'selected' : '' }}
                    >
                        พักอาศัย
                    </option>

                    <option
                        value="ย้ายออก"
                        {{ old('status') == 'ย้ายออก' ? 'selected' : '' }}
                    >
                        ย้ายออก
                    </option>

                </select>

            </div>


            {{-- รายละเอียดเพิ่มเติม --}}
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


            {{-- ปุ่ม --}}
            <div class="button-group">

                <button
                    type="submit"
                    class="button save"
                >
                    💾 บันทึกข้อมูลผู้เช่า
                </button>

                <a
                    href="{{ route('tenants.index') }}"
                    class="button back"
                >
                    ← ยกเลิก
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>