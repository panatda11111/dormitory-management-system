<x-app-layout>

{{-- Header --}}
<x-slot name="header">
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💳 ประวัติการชำระเงิน
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            ประวัติการชำระเงินของฉัน
        </p>
    </div>
</x-slot>


{{-- Content --}}
<div class="py-8">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- แจ้งเตือน --}}
        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif


        @if ($tenant)

            {{-- ข้อมูลผู้เช่า --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 mb-6">
                <div class="p-6">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                        <div>
                            <p class="text-sm text-gray-500">
                                👤 ผู้เช่า
                            </p>

                            <h3 class="mt-1 text-2xl font-bold text-gray-800">
                                {{ $tenant->name }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-2">
                                ห้องพัก
                                <span class="font-semibold text-gray-700">
                                    {{ $tenant->room?->room_number ?? '-' }}
                                </span>
                            </p>
                        </div>

                        <a
                            href="{{ route('tenant.bills') }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition"
                        >
                            🧾 ใบแจ้งค่าใช้จ่ายของฉัน
                        </a>

                    </div>

                </div>
            </div>


            {{-- ตารางประวัติการชำระเงิน --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">

                <div class="p-6">

                    <div class="mb-6">

                        <h3 class="text-lg font-bold text-gray-800">
                            💳 รายการชำระเงิน
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            มีประวัติการชำระเงินทั้งหมด
                            <span class="font-semibold text-gray-700">
                                {{ $payments->count() }}
                            </span>
                            รายการ
                        </p>

                    </div>


                    @if ($payments->count() > 0)

                        <div class="overflow-x-auto">

                            <table class="min-w-full divide-y divide-gray-200">

                                <thead>

                                    <tr class="bg-gray-50 text-gray-600">

                                        <th class="px-4 py-3 text-center text-sm font-semibold whitespace-nowrap">
                                            วันที่ชำระ
                                        </th>

                                        <th class="px-4 py-3 text-center text-sm font-semibold whitespace-nowrap">
                                            ห้อง
                                        </th>

                                        <th class="px-4 py-3 text-center text-sm font-semibold whitespace-nowrap">
                                            เดือน
                                        </th>

                                        <th class="px-4 py-3 text-right text-sm font-semibold whitespace-nowrap">
                                            จำนวนเงิน
                                        </th>

                                        <th class="px-4 py-3 text-center text-sm font-semibold whitespace-nowrap">
                                            วิธีการชำระเงิน
                                        </th>

                                        <th class="px-4 py-3 text-left text-sm font-semibold whitespace-nowrap">
                                            หมายเหตุ
                                        </th>

                                        <th class="px-4 py-3 text-center text-sm font-semibold whitespace-nowrap">
                                            จัดการ
                                        </th>

                                    </tr>

                                </thead>


                                <tbody class="divide-y divide-gray-100">

                                    @foreach ($payments as $payment)

                                        <tr class="text-sm hover:bg-gray-50 transition">

                                            {{-- วันที่ชำระ --}}
                                            <td class="px-4 py-4 text-center whitespace-nowrap text-gray-600">
                                                {{ $payment->payment_date?->format('d/m/Y') ?? '-' }}
                                            </td>


                                            {{-- ห้อง --}}
                                            <td class="px-4 py-4 text-center font-semibold text-gray-800">
                                                {{ $payment->bill?->room?->room_number ?? '-' }}
                                            </td>


                                            {{-- เดือน --}}
                                            <td class="px-4 py-4 text-center whitespace-nowrap text-gray-600">
                                                {{ $payment->bill?->billing_month ?? '-' }}
                                            </td>


                                            {{-- จำนวนเงิน --}}
                                            <td class="px-4 py-4 text-right font-bold text-green-600 whitespace-nowrap">
                                                {{ number_format((float) ($payment->amount ?? 0), 2) }}
                                                บาท
                                            </td>


                                            {{-- วิธีการชำระเงิน --}}
                                            <td class="px-4 py-4 text-center whitespace-nowrap">

                                                @if ($payment->payment_method === 'เงินสด')

                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                        💵 เงินสด
                                                    </span>

                                                @elseif ($payment->payment_method === 'โอนเงิน')

                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                                        🏦 โอนเงิน
                                                    </span>

                                                @elseif ($payment->payment_method === 'อื่นๆ')

                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                                        💳 อื่นๆ
                                                    </span>

                                                @else

                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                        {{ $payment->payment_method ?? '-' }}
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- หมายเหตุ --}}
                                            <td class="px-4 py-4 text-gray-600">
                                                {{ $payment->description ?? '-' }}
                                            </td>


                                            {{-- จัดการ --}}
                                            <td class="px-4 py-4 text-center">

                                                @if ($payment->bill)

                                                    <a
                                                        href="{{ route('tenant.bills.show', $payment->bill->id) }}"
                                                        class="inline-flex items-center justify-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg text-sm font-semibold hover:bg-blue-100 transition whitespace-nowrap"
                                                    >
                                                        🧾 ดูใบแจ้ง
                                                    </a>

                                                @else

                                                    <span class="text-gray-400">
                                                        -
                                                    </span>

                                                @endif

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        {{-- ยังไม่มีประวัติ --}}
                        <div class="text-center py-12 text-gray-500">

                            <div class="text-5xl mb-4">
                                💳
                            </div>

                            <p class="text-lg font-semibold text-gray-700">
                                ยังไม่มีประวัติการชำระเงิน
                            </p>

                            <p class="text-sm mt-2">
                                เมื่อมีการชำระเงิน รายการจะแสดงที่หน้านี้
                            </p>

                            <a
                                href="{{ route('tenant.bills') }}"
                                class="inline-flex items-center mt-5 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                            >
                                🧾 ดูใบแจ้งค่าใช้จ่าย
                            </a>

                        </div>

                    @endif

                </div>

            </div>


            {{-- ปุ่มกลับ Dashboard --}}
            <div class="mt-6">

                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition"
                >
                    ← กลับ Dashboard
                </a>

            </div>


        @else

            {{-- ไม่พบข้อมูลผู้เช่า --}}
            <div class="bg-white shadow-sm rounded-xl border border-yellow-200">

                <div class="p-8 text-center">

                    <div class="text-5xl mb-4">
                        ⚠️
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800">
                        ไม่พบข้อมูลผู้เช่า
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        บัญชีผู้ใช้นี้ยังไม่ได้เชื่อมกับข้อมูลผู้เช่า
                    </p>

                </div>

            </div>

        @endif

    </div>

</div>

</x-app-layout>
