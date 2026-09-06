<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                🧾 ใบแจ้งค่าใช้จ่ายของฉัน
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                ตรวจสอบรายการค่าใช้จ่ายและยอดค้างชำระของคุณ
            </p>
        </div>
    </x-slot>


    {{-- Content --}}
    <div class="py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ไม่พบข้อมูลผู้เช่า --}}
            @if (!$tenant)

                <div class="bg-white rounded-xl shadow-sm border border-yellow-200 p-6">

                    <div class="flex items-center gap-4">

                        <div class="text-4xl">
                            ⚠️
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-800">
                                ยังไม่มีข้อมูลผู้เช่า
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                บัญชีของคุณยังไม่ได้เชื่อมกับข้อมูลผู้เช่า
                                กรุณาติดต่อผู้ดูแลหอพัก
                            </p>
                        </div>

                    </div>

                </div>

            @else

                {{-- ข้อมูลผู้เช่า --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                        <div>

                            <p class="text-sm text-gray-500">
                                👤 ผู้เช่า
                            </p>

                            <h3 class="mt-1 text-2xl font-bold text-gray-800">
                                {{ $tenant->name }}
                            </h3>

                            <p class="mt-2 text-sm text-gray-500">
                                ห้องพัก

                                <span class="font-semibold text-gray-800">
                                    {{ $tenant->room->room_number ?? '-' }}
                                </span>
                            </p>

                        </div>

                        <div class="text-5xl">
                            🏠
                        </div>

                    </div>

                </div>


                {{-- ตารางใบแจ้งค่าใช้จ่าย --}}
                <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6">

                    <div class="mb-5">

                        <h3 class="text-lg font-bold text-gray-800">
                            🧾 รายการใบแจ้งค่าใช้จ่าย
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            แสดงเฉพาะใบแจ้งค่าใช้จ่ายที่เป็นของคุณ
                        </p>

                    </div>


                    @if ($bills->count() > 0)

                        <div class="overflow-x-auto">

                            <table class="min-w-full divide-y divide-gray-200">

                                <thead>

                                    <tr class="text-left text-sm text-gray-500">

                                        <th class="px-4 py-3">
                                            เลขที่
                                        </th>

                                        <th class="px-4 py-3">
                                            เดือน
                                        </th>

                                        <th class="px-4 py-3">
                                            ค่าเช่า
                                        </th>

                                        <th class="px-4 py-3">
                                            ค่าน้ำ
                                        </th>

                                        <th class="px-4 py-3">
                                            ค่าไฟ
                                        </th>

                                        <th class="px-4 py-3">
                                            รวม
                                        </th>

                                        <th class="px-4 py-3">
                                            ยอดคงเหลือ
                                        </th>

                                        <th class="px-4 py-3">
                                            สถานะ
                                        </th>

                                        <th class="px-4 py-3">
                                            จัดการ
                                        </th>

                                    </tr>

                                </thead>


                                <tbody class="divide-y divide-gray-100">

                                    @foreach ($bills as $bill)

                                        @php

                                            $paidAmount = $bill->payments->sum('amount');

                                            $remainingAmount = max(
                                                0,
                                                (float) $bill->total - (float) $paidAmount
                                            );

                                        @endphp


                                        <tr class="text-sm hover:bg-gray-50">

                                            {{-- เลขที่ --}}
                                            <td class="px-4 py-4 font-semibold text-gray-800">
                                                #{{ $bill->id }}
                                            </td>


                                            {{-- เดือน --}}
                                            <td class="px-4 py-4 text-gray-600">
                                                {{ $bill->billing_month }}
                                            </td>


                                            {{-- ค่าเช่า --}}
                                            <td class="px-4 py-4 text-gray-600">
                                                {{ number_format($bill->rent, 2) }}
                                                บาท
                                            </td>


                                            {{-- ค่าน้ำ --}}
                                            <td class="px-4 py-4 text-gray-600">
                                                {{ number_format($bill->water, 2) }}
                                                บาท
                                            </td>


                                            {{-- ค่าไฟ --}}
                                            <td class="px-4 py-4 text-gray-600">
                                                {{ number_format($bill->electricity, 2) }}
                                                บาท
                                            </td>


                                            {{-- รวม --}}
                                            <td class="px-4 py-4 font-semibold text-gray-800">
                                                {{ number_format($bill->total, 2) }}
                                                บาท
                                            </td>


                                            {{-- ยอดคงเหลือ --}}
                                            <td class="px-4 py-4 font-semibold">

                                                @if ($remainingAmount <= 0)

                                                    <span class="text-green-600">
                                                        0.00 บาท
                                                    </span>

                                                @else

                                                    <span class="text-red-600">
                                                        {{ number_format($remainingAmount, 2) }}
                                                        บาท
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- สถานะ --}}
                                            <td class="px-4 py-4">

                                                @if ($remainingAmount <= 0)

                                                    <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                                        ✓ ชำระแล้ว
                                                    </span>

                                                @elseif (
                                                    $bill->due_date &&
                                                    now()->startOfDay()->gt($bill->due_date)
                                                )

                                                    <span class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                                        ⚠ เกินกำหนด
                                                    </span>

                                                @else

                                                    <span class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                                        ⚠ ค้างชำระ
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- จัดการ --}}
                                            <td class="px-4 py-4">

                                                {{-- สำคัญ:
                                                     ผู้เช่าต้องใช้ Route ของผู้เช่า --}}
                                                <a
                                                    href="{{ route('tenant.bills.show', $bill->id) }}"
                                                    class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-50 text-blue-700 text-sm font-semibold hover:bg-blue-100 transition"
                                                >
                                                    👁️ ดูรายละเอียด
                                                </a>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        {{-- ไม่มีใบแจ้งค่าใช้จ่าย --}}
                        <div class="py-12 text-center">

                            <div class="text-5xl">
                                🧾
                            </div>

                            <h3 class="mt-4 text-lg font-semibold text-gray-700">
                                ยังไม่มีใบแจ้งค่าใช้จ่าย
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                ขณะนี้ยังไม่มีรายการค่าใช้จ่ายสำหรับบัญชีของคุณ
                            </p>

                        </div>

                    @endif

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


            @endif

        </div>

    </div>

</x-app-layout>