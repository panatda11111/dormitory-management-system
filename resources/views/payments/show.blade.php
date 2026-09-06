<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                💳 รายละเอียดการชำระเงิน
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                รายละเอียดรายการชำระเงิน
            </p>
        </div>

    </x-slot>


    <div class="py-8">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- แจ้งเตือน --}}

            @if (session('success'))

                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">

                    {{ session('success') }}

                </div>

            @endif


            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                <div class="p-6">


                    {{-- หัวข้อ --}}

                    <div class="flex items-center justify-between mb-6">

                        <div>

                            <h3 class="text-lg font-semibold text-gray-800">
                                💳 ข้อมูลการชำระเงิน
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                รายการชำระเงิน #{{ $payment->id }}
                            </p>

                        </div>


                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                            ✓ ชำระเงินแล้ว
                        </span>

                    </div>


                    {{-- ข้อมูลผู้เช่า --}}

                    <div class="mb-6">

                        <h4 class="text-md font-semibold text-gray-700 mb-3">
                            👤 ข้อมูลผู้เช่า
                        </h4>

                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">

                            <div class="flex justify-between border-b pb-2">

                                <span class="text-gray-600">
                                    ผู้เช่า
                                </span>

                                <strong>
                                    {{ $payment->bill?->tenant?->name ?? '-' }}
                                </strong>

                            </div>


                            <div class="flex justify-between">

                                <span class="text-gray-600">
                                    ห้องพัก
                                </span>

                                <strong>
                                    {{ $payment->bill?->room?->room_number ?? '-' }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- ข้อมูลใบแจ้งค่าใช้จ่าย --}}

                    <div class="mb-6">

                        <h4 class="text-md font-semibold text-gray-700 mb-3">
                            🧾 ข้อมูลใบแจ้งค่าใช้จ่าย
                        </h4>

                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">

                            <div class="flex justify-between border-b pb-2">

                                <span class="text-gray-600">
                                    เลขที่ใบแจ้งค่าใช้จ่าย
                                </span>

                                <strong>
                                    #{{ $payment->bill?->id ?? '-' }}
                                </strong>

                            </div>


                            <div class="flex justify-between border-b pb-2">

                                <span class="text-gray-600">
                                    เดือนที่เรียกเก็บ
                                </span>

                                <strong>
                                    {{ $payment->bill?->billing_month ?? '-' }}
                                </strong>

                            </div>


                            <div class="flex justify-between">

                                <span class="text-gray-600">
                                    ยอดใบแจ้งค่าใช้จ่าย
                                </span>

                                <strong>
                                    {{ number_format($payment->bill?->total ?? 0, 2) }}
                                    บาท
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- ข้อมูลการชำระเงิน --}}

                    <div class="mb-6">

                        <h4 class="text-md font-semibold text-gray-700 mb-3">
                            💰 ข้อมูลการชำระเงิน
                        </h4>

                        <div class="bg-green-50 rounded-lg p-4 space-y-3">

                            <div class="flex justify-between border-b pb-2">

                                <span class="text-gray-600">
                                    วันที่ชำระ
                                </span>

                                <strong>
                                    {{ $payment->payment_date?->format('d/m/Y') ?? '-' }}
                                </strong>

                            </div>


                            <div class="flex justify-between border-b pb-2">

                                <span class="text-gray-600">
                                    จำนวนเงิน
                                </span>

                                <strong class="text-green-600 text-xl">
                                    {{ number_format($payment->amount ?? 0, 2) }}
                                    บาท
                                </strong>

                            </div>


                            <div class="flex justify-between border-b pb-2">

                                <span class="text-gray-600">
                                    วิธีการชำระเงิน
                                </span>


                                @if ($payment->payment_method === 'เงินสด')

                                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                                        💵 เงินสด
                                    </span>

                                @elseif ($payment->payment_method === 'โอนเงิน')

                                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-700">
                                        🏦 โอนเงิน
                                    </span>

                                @elseif ($payment->payment_method === 'อื่นๆ')

                                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-700">
                                        💳 อื่นๆ
                                    </span>

                                @else

                                    <span class="text-gray-700">
                                        {{ $payment->payment_method ?? '-' }}
                                    </span>

                                @endif

                            </div>


                            <div class="flex justify-between">

                                <span class="text-gray-600">
                                    หมายเหตุ
                                </span>

                                <span class="text-gray-800">
                                    {{ $payment->description ?? '-' }}
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- ปุ่มจัดการ --}}

                    <div class="flex flex-wrap items-center justify-between gap-3 pt-4 border-t">


                        {{-- กลับหน้าประวัติ --}}

                        <a
                            href="{{ route('payments.index') }}"
                            class="px-5 py-2.5 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition"
                        >
                            ← ประวัติการชำระเงิน
                        </a>


                        {{-- ดูใบแจ้งค่าใช้จ่าย --}}

                        @if ($payment->bill)

                            <a
                                href="{{ route('bills.show', $payment->bill->id) }}"
                                class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                            >
                                🧾 ดูใบแจ้งค่าใช้จ่าย
                            </a>

                        @endif


                        {{-- ลบรายการ --}}

                        <form
                            action="{{ route('payments.destroy', $payment->id) }}"
                            method="POST"
                            onsubmit="return confirm('คุณต้องการลบรายการชำระเงินนี้ใช่หรือไม่?');"
                        >

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                            >
                                🗑️ ลบรายการ
                            </button>

                        </form>


                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>