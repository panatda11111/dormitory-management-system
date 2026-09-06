<x-app-layout>

<x-slot name="header">

    <div class="flex flex-col gap-1">

        <div class="flex items-center gap-3">

            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 text-xl">
                💳
            </div>

            <div>
                <h2 class="text-xl font-bold leading-tight text-gray-800">
                    ประวัติการชำระเงิน
                </h2>

                <p class="mt-0.5 text-sm text-gray-500">
                    รายการประวัติการชำระเงินทั้งหมดของระบบ
                </p>
            </div>

        </div>

    </div>

</x-slot>


<div class="py-6 sm:py-8">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


        {{-- แจ้งเตือนสำเร็จ --}}
        @if (session('success'))

            <div class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-4 text-green-700 shadow-sm">

                <div class="text-xl">
                    ✅
                </div>

                <div>
                    <p class="font-semibold">
                        ดำเนินการสำเร็จ
                    </p>

                    <p class="mt-0.5 text-sm">
                        {{ session('success') }}
                    </p>
                </div>

            </div>

        @endif


        {{-- แจ้งเตือนข้อผิดพลาด --}}
        @if ($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-4 text-red-700 shadow-sm">

                <div class="flex items-start gap-3">

                    <div class="text-xl">
                        ⚠️
                    </div>

                    <div class="flex-1">

                        <strong class="font-semibold">
                            กรุณาตรวจสอบข้อมูล
                        </strong>

                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- Summary --}}
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-gray-500">
                            รายการชำระเงินทั้งหมด
                        </p>

                        <p class="mt-1 text-2xl font-bold text-gray-800">
                            {{ $payments->count() }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            รายการ
                        </p>

                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-2xl">
                        💳
                    </div>

                </div>

            </div>


            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-gray-500">
                            สถานะข้อมูล
                        </p>

                        <p class="mt-1 text-lg font-bold text-green-600">
                            {{ $payments->count() > 0 ? 'มีรายการชำระเงิน' : 'ยังไม่มีรายการ' }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            ประวัติการชำระเงินในระบบ
                        </p>

                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl">
                        📋
                    </div>

                </div>

            </div>

        </div>


        {{-- Main Card --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="p-5 sm:p-6">


                {{-- หัวข้อ --}}
                <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    <div>

                        <div class="flex items-center gap-2">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-green-100">
                                💳
                            </div>

                            <h3 class="text-lg font-bold text-gray-800">
                                รายการประวัติการชำระเงิน
                            </h3>

                        </div>

                        <p class="mt-2 text-sm text-gray-500">

                            แสดงประวัติการชำระเงินทั้งหมด
                            <span class="font-semibold text-gray-700">
                                {{ $payments->count() }}
                            </span>
                            รายการ

                        </p>

                    </div>


                    <a
                        href="{{ route('bills.index') }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-gray-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 sm:w-auto"
                    >
                        🧾
                        <span>ไปที่ใบแจ้งค่าใช้จ่าย</span>
                    </a>

                </div>


                @if ($payments->count() > 0)

                    {{-- Table --}}
                    <div class="overflow-hidden rounded-xl border border-gray-200">

                        <div class="overflow-x-auto">

                            <table class="w-full min-w-[1100px] border-collapse">

                                <thead>

                                    <tr class="bg-gray-800 text-white">

                                        <th class="px-4 py-3.5 text-center text-xs font-semibold uppercase tracking-wide">
                                            วันที่ชำระ
                                        </th>

                                        <th class="px-4 py-3.5 text-left text-xs font-semibold uppercase tracking-wide">
                                            ผู้เช่า
                                        </th>

                                        <th class="px-4 py-3.5 text-center text-xs font-semibold uppercase tracking-wide">
                                            ห้อง
                                        </th>

                                        <th class="px-4 py-3.5 text-center text-xs font-semibold uppercase tracking-wide">
                                            เดือน
                                        </th>

                                        <th class="px-4 py-3.5 text-right text-xs font-semibold uppercase tracking-wide">
                                            จำนวนเงิน
                                        </th>

                                        <th class="px-4 py-3.5 text-center text-xs font-semibold uppercase tracking-wide">
                                            วิธีการชำระเงิน
                                        </th>

                                        <th class="px-4 py-3.5 text-left text-xs font-semibold uppercase tracking-wide">
                                            หมายเหตุ
                                        </th>

                                        <th class="px-4 py-3.5 text-center text-xs font-semibold uppercase tracking-wide">
                                            จัดการ
                                        </th>

                                    </tr>

                                </thead>


                                <tbody class="divide-y divide-gray-200 bg-white">

                                    @foreach ($payments as $payment)

                                        <tr class="transition hover:bg-gray-50">


                                            {{-- วันที่ชำระ --}}
                                            <td class="whitespace-nowrap px-4 py-4 text-center text-sm text-gray-700">

                                                {{ $payment->payment_date?->format('d/m/Y') ?? '-' }}

                                            </td>


                                            {{-- ผู้เช่า --}}
                                            <td class="px-4 py-4">

                                                <div class="flex items-center gap-3">

                                                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">
                                                        👤
                                                    </div>

                                                    <div class="min-w-0">

                                                        <p class="truncate font-semibold text-gray-800">
                                                            {{ $payment->bill?->tenant?->name ?? '-' }}
                                                        </p>

                                                        <p class="mt-0.5 text-xs text-gray-500">
                                                            ผู้เช่า
                                                        </p>

                                                    </div>

                                                </div>

                                            </td>


                                            {{-- ห้อง --}}
                                            <td class="whitespace-nowrap px-4 py-4 text-center">

                                                <span class="inline-flex items-center rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-bold text-gray-700">
                                                    ห้อง {{ $payment->bill?->room?->room_number ?? '-' }}
                                                </span>

                                            </td>


                                            {{-- เดือน --}}
                                            <td class="whitespace-nowrap px-4 py-4 text-center text-sm text-gray-700">

                                                {{ $payment->bill?->billing_month ?? '-' }}

                                            </td>


                                            {{-- จำนวนเงิน --}}
                                            <td class="whitespace-nowrap px-4 py-4 text-right">

                                                <span class="text-base font-bold text-green-600">
                                                    {{ number_format((float) ($payment->amount ?? 0), 2) }}
                                                </span>

                                                <span class="ml-1 text-sm text-gray-500">
                                                    บาท
                                                </span>

                                            </td>


                                            {{-- วิธีการชำระเงิน --}}
                                            <td class="whitespace-nowrap px-4 py-4 text-center">

                                                @if ($payment->payment_method === 'เงินสด')

                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1.5 text-xs font-semibold text-green-700">
                                                        💵 เงินสด
                                                    </span>

                                                @elseif ($payment->payment_method === 'โอนเงิน')

                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1.5 text-xs font-semibold text-blue-700">
                                                        🏦 โอนเงิน
                                                    </span>

                                                @elseif ($payment->payment_method === 'อื่นๆ')

                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-purple-100 px-3 py-1.5 text-xs font-semibold text-purple-700">
                                                        💳 อื่นๆ
                                                    </span>

                                                @else

                                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-700">
                                                        {{ $payment->payment_method ?? '-' }}
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- หมายเหตุ --}}
                                            <td class="max-w-xs px-4 py-4 text-sm text-gray-600">

                                                <span class="block truncate" title="{{ $payment->description ?? '-' }}">
                                                    {{ $payment->description ?? '-' }}
                                                </span>

                                            </td>


                                            {{-- จัดการ --}}
                                            <td class="px-4 py-4">

                                                <div class="flex items-center justify-center gap-2">


                                                    {{-- ดูรายละเอียดการชำระเงิน --}}
                                                    <a
                                                        href="{{ route('payments.show', $payment->id) }}"
                                                        class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1"
                                                    >
                                                        👁️ ดู
                                                    </a>


                                                    {{-- ดูใบแจ้งค่าใช้จ่าย --}}
                                                    @if ($payment->bill)

                                                        <a
                                                            href="{{ route('bills.show', $payment->bill->id) }}"
                                                            class="inline-flex items-center justify-center rounded-lg bg-gray-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1"
                                                        >
                                                            🧾 ใบแจ้ง
                                                        </a>

                                                    @endif


                                                    {{-- ลบรายการชำระเงิน --}}
                                                    <form
                                                        action="{{ route('payments.destroy', $payment->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('คุณต้องการลบรายการชำระเงินนี้ใช่หรือไม่?');"
                                                    >

                                                        @csrf

                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="inline-flex items-center justify-center rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1"
                                                        >
                                                            🗑️ ลบ
                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>


                    {{-- Mobile hint --}}
                    <div class="mt-3 flex items-center justify-center gap-2 text-xs text-gray-400 sm:hidden">

                        <span>↔️</span>

                        <span>
                            เลื่อนตารางไปด้านข้างเพื่อดูข้อมูลเพิ่มเติม
                        </span>

                    </div>


                @else

                    {{-- Empty State --}}
                    <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-14 text-center">

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-3xl">
                            💳
                        </div>

                        <h4 class="mt-5 text-lg font-bold text-gray-800">
                            ยังไม่มีประวัติการชำระเงิน
                        </h4>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                            เมื่อมีการบันทึกการชำระเงิน รายการประวัติการชำระเงินจะแสดงที่หน้านี้
                        </p>

                        <a
                            href="{{ route('bills.index') }}"
                            class="mt-6 inline-flex items-center justify-center gap-2 rounded-lg bg-green-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                        >
                            🧾
                            <span>ไปที่ใบแจ้งค่าใช้จ่าย</span>
                        </a>

                    </div>

                @endif


            </div>

        </div>

    </div>

</div>

</x-app-layout>
