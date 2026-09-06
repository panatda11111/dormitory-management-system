<x-app-layout>

<x-slot name="header">
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💳 บันทึกการชำระเงิน
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            บันทึกการชำระค่าใช้จ่ายของผู้เช่า
        </p>
    </div>
</x-slot>

<div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

        {{-- แจ้งเตือนข้อผิดพลาด --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-4 rounded-lg">
                <strong>⚠️ กรุณาตรวจสอบข้อมูล</strong>

                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ข้อมูลใบแจ้งค่าใช้จ่าย --}}
        <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">

            <div class="p-6">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    🧾 ข้อมูลใบแจ้งค่าใช้จ่าย
                </h3>

                <div class="space-y-3">

                    {{-- ผู้เช่า --}}
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">
                            ผู้เช่า
                        </span>

                        <strong>
                            {{ $bill->tenant?->name ?? '-' }}
                        </strong>
                    </div>

                    {{-- ห้อง --}}
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">
                            ห้อง
                        </span>

                        <strong>
                            {{ $bill->room?->room_number ?? $bill->tenant?->room?->room_number ?? '-' }}
                        </strong>
                    </div>

                    {{-- เดือน --}}
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">
                            เดือน
                        </span>

                        <strong>
                            {{ $bill->billing_month ?? '-' }}
                        </strong>
                    </div>

                    {{-- ค่าเช่า --}}
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">
                            ค่าเช่า
                        </span>

                        <span>
                            {{ number_format($bill->rent ?? 0, 2) }} บาท
                        </span>
                    </div>

                    {{-- ค่าน้ำ --}}
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">
                            ค่าน้ำ
                        </span>

                        <span>
                            {{ number_format($bill->water ?? 0, 2) }} บาท
                        </span>
                    </div>

                    {{-- ค่าไฟ --}}
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">
                            ค่าไฟ
                        </span>

                        <span>
                            {{ number_format($bill->electricity ?? 0, 2) }} บาท
                        </span>
                    </div>

                    {{-- ค่าใช้จ่ายอื่น --}}
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">
                            ค่าใช้จ่ายอื่น
                        </span>

                        <span>
                            {{ number_format($bill->other_charge ?? 0, 2) }} บาท
                        </span>
                    </div>

                    {{-- ยอดรวม --}}
                    <div class="flex justify-between pt-3 text-lg">
                        <span class="font-semibold text-gray-700">
                            ยอดรวม
                        </span>

                        <strong class="text-red-600">
                            {{ number_format($bill->total ?? 0, 2) }} บาท
                        </strong>
                    </div>

                </div>

            </div>
        </div>

        {{-- สรุปยอดชำระ --}}
        <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">

            <div class="p-6">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    💰 สรุปยอดชำระ
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- ยอดทั้งหมด --}}
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">
                            ยอดทั้งหมด
                        </p>

                        <p class="text-xl font-bold text-gray-800">
                            {{ number_format($bill->total ?? 0, 2) }} บาท
                        </p>
                    </div>

                    {{-- ชำระแล้ว --}}
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">
                            ชำระแล้ว
                        </p>

                        <p class="text-xl font-bold text-green-600">
                            {{ number_format($paidAmount ?? 0, 2) }} บาท
                        </p>
                    </div>

                    {{-- ยอดคงเหลือ --}}
                    <div class="bg-red-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">
                            ยอดคงเหลือ
                        </p>

                        <p class="text-xl font-bold text-red-600">
                            {{ number_format($remainingAmount ?? 0, 2) }} บาท
                        </p>
                    </div>

                </div>

            </div>
        </div>

        {{-- แบบฟอร์มชำระเงิน --}}
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">

            <div class="p-6">

                <h3 class="text-lg font-semibold text-gray-800 mb-6">
                    💳 ข้อมูลการชำระเงิน
                </h3>

                <form
                    action="{{ route('payments.store', $bill->id) }}"
                    method="POST"
                >
                    @csrf

                    {{-- จำนวนเงิน --}}
                    <div class="mb-5">

                        <label
                            for="amount"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            จำนวนเงินที่ชำระ
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="number"
                            name="amount"
                            id="amount"
                            value="{{ old('amount', number_format($remainingAmount ?? 0, 2, '.', '')) }}"
                            min="0.01"
                            max="{{ $remainingAmount ?? 0 }}"
                            step="0.01"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        >

                        <p class="text-sm text-gray-500 mt-1">
                            ยอดคงเหลือสูงสุด
                            {{ number_format($remainingAmount ?? 0, 2) }} บาท
                        </p>

                    </div>

                    {{-- วันที่ชำระ --}}
                    <div class="mb-5">

                        <label
                            for="payment_date"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            วันที่ชำระเงิน
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="date"
                            name="payment_date"
                            id="payment_date"
                            value="{{ old('payment_date', date('Y-m-d')) }}"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        >

                    </div>

                    {{-- วิธีการชำระเงิน --}}
                    <div class="mb-5">

                        <label
                            for="payment_method"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            วิธีการชำระเงิน
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            name="payment_method"
                            id="payment_method"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        >

                            <option value="">
                                -- เลือกวิธีการชำระเงิน --
                            </option>

                            <option
                                value="เงินสด"
                                {{ old('payment_method') === 'เงินสด' ? 'selected' : '' }}
                            >
                                💵 เงินสด
                            </option>

                            <option
                                value="โอนเงิน"
                                {{ old('payment_method') === 'โอนเงิน' ? 'selected' : '' }}
                            >
                                🏦 โอนเงิน
                            </option>

                            <option
                                value="อื่นๆ"
                                {{ old('payment_method') === 'อื่นๆ' ? 'selected' : '' }}
                            >
                                💳 อื่นๆ
                            </option>

                        </select>

                    </div>

                    {{-- หมายเหตุ --}}
                    <div class="mb-6">

                        <label
                            for="description"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            หมายเหตุ
                        </label>

                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                            placeholder="ระบุรายละเอียดเพิ่มเติม (ถ้ามี)"
                        >{{ old('description') }}</textarea>

                    </div>

                    {{-- ปุ่ม --}}
                    <div class="flex items-center justify-end gap-3">

                        <a
                            href="{{ route('bills.show', $bill->id) }}"
                            class="px-5 py-2.5 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition"
                        >
                            ← ยกเลิก
                        </a>

                        <button
                            type="submit"
                            class="px-5 py-2.5 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition"
                        >
                            💳 บันทึกการชำระเงิน
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

</x-app-layout>
