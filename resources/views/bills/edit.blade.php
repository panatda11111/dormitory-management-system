<x-app-layout>

<x-slot name="header">
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ แก้ไขใบแจ้งค่าใช้จ่าย
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            แก้ไขข้อมูลใบแจ้งค่าใช้จ่ายของผู้เช่า
        </p>
    </div>
</x-slot>

<div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        {{-- แจ้งเตือนข้อผิดพลาด --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <strong>⚠️ กรุณาตรวจสอบข้อมูล</strong>

                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">

            <div class="p-6">

                <form
                    action="{{ route('bills.update', $bill->id) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    {{-- ผู้เช่า --}}
                    <div class="mb-6">
                        <label
                            for="tenant_id"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            👤 ผู้เช่า
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            name="tenant_id"
                            id="tenant_id"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
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
                                        {{ (string) old('tenant_id', $bill->tenant_id) === (string) $tenant->id ? 'selected' : '' }}
                                    >
                                        {{ $tenant->name }}
                                        - ห้อง {{ $tenant->room->room_number }}
                                    </option>
                                @endif
                            @endforeach
                        </select>

                        <p class="text-sm text-gray-500 mt-1">
                            👤 เลือกผู้เช่าที่ต้องการแก้ไขใบแจ้งค่าใช้จ่าย
                        </p>
                    </div>

                    {{-- ห้องพัก --}}
                    <div class="mb-6">
                        <label
                            for="room_id"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            🏠 ห้องพัก
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            name="room_id"
                            id="room_id"
                            required
                            class="w-full rounded-lg border-gray-300 bg-gray-100"
                        >
                            <option value="">
                                -- เลือกผู้เช่าก่อน --
                            </option>
                        </select>

                        <p
                            id="roomInfo"
                            class="text-sm text-green-700 mt-2 font-semibold"
                        ></p>
                    </div>

                    {{-- เดือนที่เรียกเก็บ --}}
                    <div class="mb-6">
                        <label
                            for="billing_month"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            📅 เดือนที่เรียกเก็บ
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            name="billing_month"
                            id="billing_month"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        >
                            <option value="">
                                -- เลือกเดือนที่มีข้อมูลมิเตอร์ --
                            </option>
                        </select>

                        <p class="text-sm text-gray-500 mt-1">
                            📅 เลือกเฉพาะเดือนที่มีข้อมูลมิเตอร์ของผู้เช่าคนนั้น
                        </p>
                    </div>

                    {{-- ข้อมูลมิเตอร์ --}}
                    <div
                        id="meterInfo"
                        class="mb-6 p-5 bg-blue-50 border border-blue-200 rounded-lg"
                    >
                        <h3 class="font-semibold text-blue-800 mb-4">
                            📊 ข้อมูลมิเตอร์
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- หน่วยน้ำ --}}
                            <div>
                                <p class="text-sm text-gray-600">
                                    💧 หน่วยน้ำ
                                </p>

                                <p
                                    id="waterUnits"
                                    class="text-lg font-bold text-gray-800"
                                >
                                    -
                                </p>
                            </div>

                            {{-- ค่าน้ำ --}}
                            <div>
                                <p class="text-sm text-gray-600">
                                    💧 ค่าน้ำ
                                </p>

                                <p
                                    id="waterCharge"
                                    class="text-lg font-bold text-blue-700"
                                >
                                    -
                                </p>
                            </div>

                            {{-- หน่วยไฟ --}}
                            <div>
                                <p class="text-sm text-gray-600">
                                    ⚡ หน่วยไฟ
                                </p>

                                <p
                                    id="electricityUnits"
                                    class="text-lg font-bold text-gray-800"
                                >
                                    -
                                </p>
                            </div>

                            {{-- ค่าไฟ --}}
                            <div>
                                <p class="text-sm text-gray-600">
                                    ⚡ ค่าไฟ
                                </p>

                                <p
                                    id="electricityCharge"
                                    class="text-lg font-bold text-yellow-700"
                                >
                                    -
                                </p>
                            </div>

                        </div>

                        <div
                            id="meterMessage"
                            class="mt-4 text-sm font-medium"
                        ></div>
                    </div>

                    {{-- ค่าเช่า --}}
                    <div class="mb-6">
                        <label
                            for="rent"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            🏠 ค่าเช่า (บาท)
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="number"
                            name="rent"
                            id="rent"
                            step="0.01"
                            min="0"
                            value="{{ old('rent', $bill->rent) }}"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        >
                    </div>

                    {{-- ค่าน้ำ --}}
                    <div class="mb-6">
                        <label
                            for="water"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            💧 ค่าน้ำ (บาท)
                        </label>

                        <input
                            type="number"
                            name="water"
                            id="water"
                            step="0.01"
                            min="0"
                            value="{{ old('water', $bill->water ?? 0) }}"
                            readonly
                            class="w-full rounded-lg border-gray-300 bg-gray-100"
                        >

                        <p class="text-sm text-gray-500 mt-1">
                            ระบบจะดึงจากข้อมูลมิเตอร์อัตโนมัติ
                        </p>
                    </div>

                    {{-- ค่าไฟ --}}
                    <div class="mb-6">
                        <label
                            for="electricity"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            ⚡ ค่าไฟ (บาท)
                        </label>

                        <input
                            type="number"
                            name="electricity"
                            id="electricity"
                            step="0.01"
                            min="0"
                            value="{{ old('electricity', $bill->electricity ?? 0) }}"
                            readonly
                            class="w-full rounded-lg border-gray-300 bg-gray-100"
                        >

                        <p class="text-sm text-gray-500 mt-1">
                            ระบบจะดึงจากข้อมูลมิเตอร์อัตโนมัติ
                        </p>
                    </div>

                    {{-- ค่าใช้จ่ายอื่น --}}
                    <div class="mb-6">
                        <label
                            for="other_charge"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            💰 ค่าใช้จ่ายอื่น (บาท)
                        </label>

                        <input
                            type="number"
                            name="other_charge"
                            id="other_charge"
                            step="0.01"
                            min="0"
                            value="{{ old('other_charge', $bill->other_charge ?? 0) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        >
                    </div>

                    {{-- ยอดรวม --}}
                    <div class="mb-6 p-5 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center justify-between">

                            <span class="text-lg font-semibold text-gray-700">
                                💰 ยอดรวมทั้งหมด
                            </span>

                            <div>
                                <span
                                    id="total"
                                    class="text-2xl font-bold text-green-700"
                                >
                                    {{ number_format($bill->total ?? 0, 2) }}
                                </span>

                                <span class="text-lg font-semibold text-green-700">
                                    บาท
                                </span>
                            </div>

                        </div>
                    </div>

                    {{-- วันครบกำหนด --}}
                    <div class="mb-6">
                        <label
                            for="due_date"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            📅 วันครบกำหนดชำระ
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="date"
                            name="due_date"
                            id="due_date"
                            value="{{ old('due_date', $bill->due_date?->format('Y-m-d')) }}"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        >
                    </div>

                    {{-- สถานะ --}}
                    <div class="mb-6">
                        <label
                            for="status"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            📌 สถานะ
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            name="status"
                            id="status"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        >
                            <option
                                value="ค้างชำระ"
                                {{ old('status', $bill->status) === 'ค้างชำระ' ? 'selected' : '' }}
                            >
                                ค้างชำระ
                            </option>

                            <option
                                value="ชำระแล้ว"
                                {{ old('status', $bill->status) === 'ชำระแล้ว' ? 'selected' : '' }}
                            >
                                ชำระแล้ว
                            </option>

                            <option
                                value="เกินกำหนด"
                                {{ old('status', $bill->status) === 'เกินกำหนด' ? 'selected' : '' }}
                            >
                                เกินกำหนด
                            </option>
                        </select>
                    </div>

                    {{-- รายละเอียด --}}
                    <div class="mb-6">
                        <label
                            for="description"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            📝 รายละเอียดเพิ่มเติม
                        </label>

                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                            placeholder="รายละเอียดเพิ่มเติม"
                        >{{ old('description', $bill->description) }}</textarea>
                    </div>

                    {{-- ปุ่ม --}}
                    <div class="flex items-center justify-end gap-3">

                        <a
                            href="{{ route('bills.index') }}"
                            class="px-5 py-2.5 bg-gray-500 text-white rounded-lg font-semibold hover:bg-gray-600 transition"
                        >
                            ← ยกเลิก
                        </a>

                        <button
                            type="submit"
                            class="px-5 py-2.5 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition"
                        >
                            💾 บันทึกการแก้ไข
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const tenantSelect = document.getElementById('tenant_id');
        const roomSelect = document.getElementById('room_id');
        const billingMonthSelect = document.getElementById('billing_month');

        const rentInput = document.getElementById('rent');
        const waterInput = document.getElementById('water');
        const electricityInput = document.getElementById('electricity');
        const otherInput = document.getElementById('other_charge');

        const totalElement = document.getElementById('total');

        const roomInfo = document.getElementById('roomInfo');

        const waterUnits = document.getElementById('waterUnits');
        const waterCharge = document.getElementById('waterCharge');

        const electricityUnits = document.getElementById('electricityUnits');
        const electricityCharge = document.getElementById('electricityCharge');

        const meterMessage = document.getElementById('meterMessage');

        const meterData = @json($meterReadings);

        const originalRoomId = @json(old('room_id', $bill->room_id));

        const originalBillingMonth = @json(
            old('billing_month', $bill->billing_month)
        );

        function number(value) {
            const result = parseFloat(value);

            return Number.isFinite(result) ? result : 0;
        }

        function formatMoney(value) {
            return number(value).toLocaleString('th-TH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function calculateTotal() {

            const rent = number(rentInput.value);
            const water = number(waterInput.value);
            const electricity = number(electricityInput.value);
            const other = number(otherInput.value);

            const total =
                rent +
                water +
                electricity +
                other;

            totalElement.textContent = formatMoney(total);
        }

        function clearMeterData() {

            waterInput.value = '0.00';
            electricityInput.value = '0.00';

            waterUnits.textContent = '-';
            waterCharge.textContent = '-';

            electricityUnits.textContent = '-';
            electricityCharge.textContent = '-';

            meterMessage.textContent = '';

            meterMessage.className =
                'mt-4 text-sm font-medium';
        }

        function updateRoomInformation() {

            const option =
                tenantSelect.options[tenantSelect.selectedIndex];

            if (!option || !option.value) {

                roomSelect.innerHTML = `
                    <option value="">
                        -- เลือกผู้เช่าก่อน --
                    </option>
                `;

                roomInfo.textContent = '';

                rentInput.value = '0';

                billingMonthSelect.innerHTML = `
                    <option value="">
                        -- เลือกผู้เช่าก่อน --
                    </option>
                `;

                clearMeterData();
                calculateTotal();

                return;
            }

            const roomId = option.dataset.roomId;
            const roomNumber = option.dataset.roomNumber;
            const floor = option.dataset.floor;
            const roomType = option.dataset.roomType;
            const rent = option.dataset.rent;

            roomSelect.innerHTML = '';

            const roomOption =
                document.createElement('option');

            roomOption.value = roomId;
            roomOption.textContent =
                'ห้อง ' + roomNumber;

            roomOption.selected = true;

            roomSelect.appendChild(roomOption);

            if (
                String(roomId) ===
                String(originalRoomId)
            ) {
                roomSelect.value = originalRoomId;
            }

            rentInput.value = rent || 0;

            let information =
                '🏠 ห้อง ' + roomNumber;

            if (floor) {
                information += ' | ชั้น ' + floor;
            }

            if (roomType) {
                information += ' | ' + roomType;
            }

            roomInfo.textContent = information;

            updateBillingMonths();
        }

        function updateBillingMonths() {

            const tenantId = tenantSelect.value;
            const roomId = roomSelect.value;

            billingMonthSelect.innerHTML = `
                <option value="">
                    -- เลือกเดือนที่มีข้อมูลมิเตอร์ --
                </option>
            `;

            clearMeterData();

            if (!tenantId || !roomId) {
                calculateTotal();
                return;
            }

            const readings =
                meterData.filter(function (meter) {

                    return (
                        String(meter.tenant_id) === String(tenantId) &&
                        String(meter.room_id) === String(roomId)
                    );

                });

            const uniqueMonths = [];

            readings.forEach(function (meter) {

                const month =
                    String(
                        meter.billing_month || ''
                    ).trim();

                if (
                    month &&
                    !uniqueMonths.includes(month)
                ) {
                    uniqueMonths.push(month);
                }

            });

            uniqueMonths.sort(function (a, b) {

                return b.localeCompare(a, 'th', {
                    numeric: true
                });

            });

            if (uniqueMonths.length === 0) {

                billingMonthSelect.innerHTML = `
                    <option value="">
                        -- ไม่พบข้อมูลมิเตอร์ --
                    </option>
                `;

                meterMessage.textContent =
                    '⚠️ ผู้เช่ารายนี้ยังไม่มีข้อมูลมิเตอร์';

                meterMessage.className =
                    'mt-4 text-sm font-medium text-red-600';

                calculateTotal();

                return;
            }

            uniqueMonths.forEach(function (month) {

                const option =
                    document.createElement('option');

                option.value = month;
                option.textContent = month;

                billingMonthSelect.appendChild(option);

            });

            if (
                originalBillingMonth &&
                uniqueMonths.includes(
                    String(originalBillingMonth)
                )
            ) {

                billingMonthSelect.value =
                    String(originalBillingMonth);

            } else if (uniqueMonths.length === 1) {

                billingMonthSelect.value =
                    uniqueMonths[0];

            }

            loadMeterData();
        }

        function loadMeterData() {

            const tenantId =
                tenantSelect.value;

            const roomId =
                roomSelect.value;

            const billingMonth =
                billingMonthSelect.value.trim();

            clearMeterData();

            if (
                !tenantId ||
                !roomId ||
                !billingMonth
            ) {
                calculateTotal();
                return;
            }

            const meter =
                meterData
                    .filter(function (item) {

                        return (
                            String(item.tenant_id) === String(tenantId) &&
                            String(item.room_id) === String(roomId) &&
                            String(item.billing_month).trim() === billingMonth
                        );

                    })
                    .sort(function (a, b) {

                        return Number(b.id) - Number(a.id);

                    })[0];

            if (!meter) {

                meterMessage.textContent =
                    '⚠️ ไม่พบข้อมูลมิเตอร์ของผู้เช่า ห้องพัก และเดือนที่เลือก';

                meterMessage.className =
                    'mt-4 text-sm font-medium text-red-600';

                calculateTotal();

                return;
            }

            const water =
                number(meter.water_charge);

            const electricity =
                number(meter.electricity_charge);

            waterInput.value =
                water.toFixed(2);

            electricityInput.value =
                electricity.toFixed(2);

            waterUnits.textContent =
                number(meter.water_unit).toFixed(2) +
                ' หน่วย';

            waterCharge.textContent =
                formatMoney(water) +
                ' บาท';

            electricityUnits.textContent =
                number(meter.electricity_unit).toFixed(2) +
                ' หน่วย';

            electricityCharge.textContent =
                formatMoney(electricity) +
                ' บาท';

            meterMessage.textContent =
                '✓ พบข้อมูลมิเตอร์ของเดือน ' +
                billingMonth +
                ' ระบบนำค่าน้ำและค่าไฟมาใช้ในใบแจ้งค่าใช้จ่ายแล้ว';

            meterMessage.className =
                'mt-4 text-sm font-medium text-green-700';

            calculateTotal();
        }

        tenantSelect.addEventListener(
            'change',
            function () {
                updateRoomInformation();
            }
        );

        billingMonthSelect.addEventListener(
            'change',
            function () {
                loadMeterData();
            }
        );

        rentInput.addEventListener(
            'input',
            function () {
                calculateTotal();
            }
        );

        otherInput.addEventListener(
            'input',
            function () {
                calculateTotal();
            }
        );

        if (tenantSelect.value) {
            updateRoomInformation();
        } else {
            clearMeterData();
        }

        calculateTotal();

    });
</script>

</x-app-layout>
