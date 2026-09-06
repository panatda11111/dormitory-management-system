<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                🧾 รายละเอียดใบแจ้งค่าใช้จ่าย
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                ตรวจสอบรายละเอียดค่าใช้จ่ายและประวัติการชำระเงิน
            </p>
        </div>
    </x-slot>


    {{-- Content --}}
    <div class="py-8">

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">


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


            {{-- รายละเอียดใบแจ้งค่าใช้จ่าย --}}
            <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

                    <div>

                        <h3 class="text-lg font-bold text-gray-800">
                            🧾 ใบแจ้งค่าใช้จ่าย #{{ $bill->id }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            ประจำเดือน {{ $bill->billing_month }}
                        </p>

                    </div>

                    @php

                        $paidAmount = $bill->payments->sum('amount');

                        $remainingAmount = max(
                            0,
                            (float) $bill->total - (float) $paidAmount
                        );

                    @endphp


                    @if ($remainingAmount <= 0)

                        <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                            ✓ ชำระแล้ว
                        </span>

                    @elseif (
                        $bill->due_date &&
                        now()->startOfDay()->gt($bill->due_date)
                    )

                        <span class="inline-flex px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold">
                            ⚠ เกินกำหนด
                        </span>

                    @else

                        <span class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-700 text-sm font-semibold">
                            ⚠ ค้างชำระ
                        </span>

                    @endif

                </div>


                {{-- รายละเอียดค่าใช้จ่าย --}}
                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <tbody class="divide-y divide-gray-100">


                            {{-- เดือน --}}
                            <tr>

                                <td class="py-4 text-gray-600">
                                    เดือน
                                </td>

                                <td class="py-4 text-right font-semibold text-gray-800">
                                    {{ $bill->billing_month }}
                                </td>

                            </tr>


                            {{-- ค่าเช่า --}}
                            <tr>

                                <td class="py-4 text-gray-600">
                                    ค่าเช่า
                                </td>

                                <td class="py-4 text-right text-gray-800">
                                    {{ number_format($bill->rent, 2) }} บาท
                                </td>

                            </tr>


                            {{-- ค่าน้ำ --}}
                            <tr>

                                <td class="py-4 text-gray-600">
                                    ค่าน้ำ
                                </td>

                                <td class="py-4 text-right text-gray-800">
                                    {{ number_format($bill->water, 2) }} บาท
                                </td>

                            </tr>


                            {{-- ค่าไฟ --}}
                            <tr>

                                <td class="py-4 text-gray-600">
                                    ค่าไฟ
                                </td>

                                <td class="py-4 text-right text-gray-800">
                                    {{ number_format($bill->electricity, 2) }} บาท
                                </td>

                            </tr>


                            {{-- ค่าใช้จ่ายอื่น ๆ --}}
                            @if ((float) $bill->other > 0)

                                <tr>

                                    <td class="py-4 text-gray-600">
                                        ค่าใช้จ่ายอื่น ๆ
                                    </td>

                                    <td class="py-4 text-right text-gray-800">
                                        {{ number_format($bill->other, 2) }} บาท
                                    </td>

                                </tr>

                            @endif


                            {{-- รวม --}}
                            <tr>

                                <td class="py-5 text-lg font-bold text-gray-800">
                                    ยอดรวม
                                </td>

                                <td class="py-5 text-right text-lg font-bold text-gray-800">
                                    {{ number_format($bill->total, 2) }} บาท
                                </td>

                            </tr>


                            {{-- ชำระแล้ว --}}
                            <tr>

                                <td class="py-4 text-gray-600">
                                    ชำระแล้ว
                                </td>

                                <td class="py-4 text-right font-semibold text-green-600">
                                    {{ number_format($paidAmount, 2) }} บาท
                                </td>

                            </tr>


                            {{-- คงเหลือ --}}
                            <tr>

                                <td class="py-4 text-gray-600">
                                    ยอดคงเหลือ
                                </td>

                                <td class="py-4 text-right font-bold">

                                    @if ($remainingAmount <= 0)

                                        <span class="text-green-600">
                                            0.00 บาท
                                        </span>

                                    @else

                                        <span class="text-red-600">
                                            {{ number_format($remainingAmount, 2) }} บาท
                                        </span>

                                    @endif

                                </td>

                            </tr>


                            {{-- วันครบกำหนด --}}
                            @if ($bill->due_date)

                                <tr>

                                    <td class="py-4 text-gray-600">
                                        วันครบกำหนดชำระ
                                    </td>

                                    <td class="py-4 text-right text-gray-800">
                                        {{ $bill->due_date->format('d/m/Y') }}
                                    </td>

                                </tr>

                            @endif

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- ประวัติการชำระเงิน --}}
            <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">

                <h3 class="text-lg font-bold text-gray-800">
                    💳 ประวัติการชำระเงิน
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    รายการชำระเงินของใบแจ้งค่าใช้จ่ายนี้
                </p>


                @if ($bill->payments->count() > 0)

                    <div class="mt-5 overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead>

                                <tr class="text-left text-sm text-gray-500">

                                    <th class="px-4 py-3">
                                        วันที่
                                    </th>

                                    <th class="px-4 py-3">
                                        จำนวนเงิน
                                    </th>

                                    <th class="px-4 py-3">
                                        ช่องทาง
                                    </th>

                                    <th class="px-4 py-3">
                                        รายละเอียด
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-100">

                                @foreach ($bill->payments as $payment)

                                    <tr class="text-sm">

                                        <td class="px-4 py-4 text-gray-600">
                                            {{ $payment->payment_date
                                                ? $payment->payment_date->format('d/m/Y')
                                                : '-' }}
                                        </td>

                                        <td class="px-4 py-4 font-semibold text-green-600">
                                            {{ number_format($payment->amount, 2) }}
                                            บาท
                                        </td>

                                        <td class="px-4 py-4 text-gray-600">
                                            {{ $payment->payment_method ?? '-' }}
                                        </td>

                                        <td class="px-4 py-4 text-gray-600">
                                            {{ $payment->description ?? '-' }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="py-8 text-center">

                        <div class="text-4xl">
                            💳
                        </div>

                        <p class="mt-3 text-sm text-gray-500">
                            ยังไม่มีประวัติการชำระเงิน
                        </p>

                    </div>

                @endif

            </div>


            {{-- กลับหน้ารายการ --}}
            <div class="mt-6">

                <a
                    href="{{ route('tenant.bills') }}"
                    class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition"
                >
                    ← กลับใบแจ้งค่าใช้จ่าย
                </a>

            </div>


        </div>

    </div>

</x-app-layout>