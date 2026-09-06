<x-app-layout>

{{-- Header --}}
<x-slot name="header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                📊 แดชบอร์ดผู้เช่า
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                ระบบบริหารจัดการหอพักออนไลน์
            </p>
        </div>

        @if ($tenant)
            <div class="inline-flex items-center gap-2 text-sm text-gray-600 bg-gray-50 px-4 py-2 rounded-lg border border-gray-200">
                <span>👤</span>
                <span class="font-semibold">{{ $tenant->name }}</span>
            </div>
        @endif
    </div>
</x-slot>


{{-- Content --}}
<div class="py-8 bg-gray-50 min-h-screen">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ไม่พบข้อมูลผู้เช่า --}}
        @if (!$tenant)

            <div class="bg-white rounded-2xl shadow-sm border border-yellow-200 p-8">

                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">

                    <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center text-3xl shrink-0">
                        ⚠️
                    </div>

                    <div class="text-center sm:text-left">
                        <h3 class="text-xl font-bold text-gray-800">
                            ยังไม่มีข้อมูลผู้เช่า
                        </h3>

                        <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                            บัญชีของคุณยังไม่ได้เชื่อมกับข้อมูลผู้เช่า
                            กรุณาติดต่อผู้ดูแลหอพัก
                        </p>
                    </div>

                </div>

            </div>

        @else

            {{-- ========================================================= --}}
            {{-- ข้อมูลผู้เช่า --}}
            {{-- ========================================================= --}}

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="p-6 sm:p-8">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                        <div class="flex items-center gap-4">

                            <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-3xl">
                                👤
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">
                                    ผู้เช่า
                                </p>

                                <h3 class="mt-1 text-2xl font-bold text-gray-800">
                                    {{ $tenant->name }}
                                </h3>

                                <p class="mt-2 text-sm text-gray-500">
                                    ห้องพัก
                                    <span class="font-bold text-gray-800">
                                        {{ $tenant->room->room_number ?? '-' }}
                                    </span>
                                </p>
                            </div>

                        </div>


                        <div class="flex items-center gap-3 bg-blue-50 border border-blue-100 rounded-xl px-5 py-4">

                            <div class="text-3xl">
                                🏠
                            </div>

                            <div>
                                <p class="text-xs text-gray-500">
                                    ห้องพักของฉัน
                                </p>

                                <p class="text-xl font-bold text-blue-700">
                                    {{ $tenant->room->room_number ?? '-' }}
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- สรุปข้อมูล --}}
            {{-- ========================================================= --}}

            <div class="mt-8">

                <div class="mb-5">
                    <h3 class="text-lg font-bold text-gray-800">
                        📊 สรุปข้อมูล
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        ภาพรวมค่าใช้จ่ายและการชำระเงินของคุณ
                    </p>
                </div>


                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">


                    {{-- ใบแจ้งค่าใช้จ่าย --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-sm font-medium text-gray-500">
                                    ใบแจ้งค่าใช้จ่าย
                                </p>

                                <p class="mt-3 text-3xl font-bold text-gray-800">
                                    {{ $totalBills }}
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    รายการทั้งหมด
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-2xl">
                                🧾
                            </div>

                        </div>

                    </div>


                    {{-- ค้างชำระ --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6 hover:shadow-md transition">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-sm font-medium text-red-600">
                                    ค้างชำระ
                                </p>

                                <p class="mt-3 text-3xl font-bold text-red-600">
                                    {{ $unpaidBills }}
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    รายการ
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center text-2xl">
                                ⚠️
                            </div>

                        </div>

                    </div>


                    {{-- ยอดค้างชำระ --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-yellow-100 p-6 hover:shadow-md transition">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-sm font-medium text-yellow-600">
                                    ยอดค้างชำระ
                                </p>

                                <p class="mt-3 text-3xl font-bold text-yellow-600">
                                    {{ number_format($pendingAmount, 2) }}
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    บาท
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center text-2xl">
                                💰
                            </div>

                        </div>

                    </div>


                    {{-- ชำระแล้ว --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-green-100 p-6 hover:shadow-md transition">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-sm font-medium text-green-600">
                                    ชำระเงินแล้ว
                                </p>

                                <p class="mt-3 text-3xl font-bold text-green-600">
                                    {{ number_format($totalPaid, 2) }}
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    บาท
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-2xl">
                                💳
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- ใบแจ้งค่าใช้จ่ายล่าสุด --}}
            {{-- ========================================================= --}}

            <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="p-6 border-b border-gray-100">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                        <div>
                            <h3 class="text-lg font-bold text-gray-800">
                                🧾 ใบแจ้งค่าใช้จ่ายของฉัน
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                รายการค่าใช้จ่ายล่าสุดของคุณ
                            </p>
                        </div>

                        <a
                            href="{{ route('tenant.bills') }}"
                            class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-blue-50 text-blue-700 text-sm font-semibold hover:bg-blue-100 transition"
                        >
                            ดูทั้งหมด →
                        </a>

                    </div>

                </div>


                @if ($bills->count() > 0)

                    <div class="overflow-x-auto">

                        <table class="min-w-full">

                            <thead class="bg-gray-50">

                                <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">

                                    <th class="px-6 py-4 whitespace-nowrap">
                                        เลขที่
                                    </th>

                                    <th class="px-6 py-4 whitespace-nowrap">
                                        เดือน
                                    </th>

                                    <th class="px-6 py-4 whitespace-nowrap">
                                        ยอดรวม
                                    </th>

                                    <th class="px-6 py-4 whitespace-nowrap">
                                        สถานะ
                                    </th>

                                    <th class="px-6 py-4 text-center whitespace-nowrap">
                                        รายละเอียด
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-100">

                                @foreach ($bills->take(5) as $bill)

                                    @php

                                        $paidAmount = $bill->payments->sum('amount');

                                        $remainingAmount = max(
                                            0,
                                            (float) $bill->total - (float) $paidAmount
                                        );

                                    @endphp


                                    <tr class="text-sm hover:bg-gray-50 transition">

                                        {{-- เลขที่ --}}
                                        <td class="px-6 py-4 font-bold text-gray-800 whitespace-nowrap">
                                            #{{ $bill->id }}
                                        </td>


                                        {{-- เดือน --}}
                                        <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                            {{ $bill->billing_month }}
                                        </td>


                                        {{-- ยอดรวม --}}
                                        <td class="px-6 py-4 font-bold text-gray-800 whitespace-nowrap">
                                            {{ number_format($bill->total, 2) }}
                                            บาท
                                        </td>


                                        {{-- สถานะ --}}
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            @if ($remainingAmount <= 0)

                                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                                    ✓ ชำระแล้ว
                                                </span>

                                            @elseif (
                                                $bill->due_date &&
                                                now()->startOfDay()->gt($bill->due_date)
                                            )

                                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                                                    ⚠ เกินกำหนด
                                                </span>

                                            @else

                                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                                    ⚠ ค้างชำระ
                                                </span>

                                            @endif

                                        </td>


                                        {{-- รายละเอียด --}}
                                        <td class="px-6 py-4 text-center whitespace-nowrap">

                                            <a
                                                href="{{ route('tenant.bills.show', $bill->id) }}"
                                                class="inline-flex items-center justify-center px-3 py-2 rounded-lg bg-blue-50 text-blue-700 text-sm font-semibold hover:bg-blue-100 transition"
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

                    <div class="py-14 text-center">

                        <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 flex items-center justify-center text-3xl">
                            🧾
                        </div>

                        <p class="mt-4 text-lg font-semibold text-gray-700">
                            ยังไม่มีใบแจ้งค่าใช้จ่าย
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            ขณะนี้ยังไม่มีรายการค่าใช้จ่ายสำหรับบัญชีของคุณ
                        </p>

                    </div>

                @endif

            </div>


            {{-- ========================================================= --}}
            {{-- เมนูผู้เช่า --}}
            {{-- ========================================================= --}}

            <div class="mt-8">

                <div class="mb-5">

                    <h3 class="text-lg font-bold text-gray-800">
                        📋 เมนูของฉัน
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        เข้าถึงเมนูหลักสำหรับการจัดการข้อมูลของคุณ
                    </p>

                </div>


                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">


                    {{-- ใบแจ้งค่าใช้จ่าย --}}
                    <a
                        href="{{ route('tenant.bills') }}"
                        class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-blue-200 transition"
                    >

                        <div class="flex items-center justify-between">

                            <div>
                                <h4 class="font-bold text-gray-800 group-hover:text-blue-700 transition">
                                    ใบแจ้งค่าใช้จ่าย
                                </h4>

                                <p class="mt-1 text-sm text-gray-500">
                                    ตรวจสอบรายการค่าใช้จ่าย
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-2xl">
                                🧾
                            </div>

                        </div>

                        <div class="mt-5 text-sm font-semibold text-blue-600">
                            ดูรายการ →
                        </div>

                    </a>


                    {{-- ประวัติการชำระเงิน --}}
                    <a
                        href="{{ route('tenant.payments') }}"
                        class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-green-200 transition"
                    >

                        <div class="flex items-center justify-between">

                            <div>
                                <h4 class="font-bold text-gray-800 group-hover:text-green-700 transition">
                                    ประวัติการชำระเงิน
                                </h4>

                                <p class="mt-1 text-sm text-gray-500">
                                    ตรวจสอบรายการชำระเงิน
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-2xl">
                                💳
                            </div>

                        </div>

                        <div class="mt-5 text-sm font-semibold text-green-600">
                            ดูประวัติ →
                        </div>

                    </a>


                    {{-- โปรไฟล์ --}}
                    <a
                        href="{{ route('profile.edit') }}"
                        class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-gray-300 transition"
                    >

                        <div class="flex items-center justify-between">

                            <div>
                                <h4 class="font-bold text-gray-800 group-hover:text-gray-900 transition">
                                    ตั้งค่าบัญชี
                                </h4>

                                <p class="mt-1 text-sm text-gray-500">
                                    แก้ไขข้อมูลบัญชีของคุณ
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-2xl">
                                ⚙️
                            </div>

                        </div>

                        <div class="mt-5 text-sm font-semibold text-gray-600">
                            จัดการบัญชี →
                        </div>

                    </a>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- Footer information --}}
            {{-- ========================================================= --}}

            <div class="mt-8 mb-4 text-center">

                <p class="text-xs text-gray-400">
                    ระบบบริหารจัดการหอพักออนไลน์
                </p>

                <p class="mt-1 text-xs text-gray-400">
                    Dormitory Management System
                </p>

            </div>

        @endif

    </div>

</div>

</x-app-layout>
