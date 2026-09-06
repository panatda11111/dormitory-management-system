<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="dorm-title">
                    มิเตอร์น้ำ / ไฟ
                </h2>

                <p class="dorm-subtitle">
                    บันทึกและตรวจสอบการใช้น้ำและไฟของผู้เช่า
                </p>

            </div>

            <div class="text-sm text-gray-500">
                ข้อมูลมิเตอร์ทั้งหมด {{ $meterReadings->count() }} รายการ
            </div>

        </div>

    </x-slot>


    <div class="py-6 sm:py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


            {{-- =====================================================
                 แจ้งเตือน
            ====================================================== --}}

            @if (session('success'))

                <div class="dorm-alert-success mb-6">

                    <div class="flex items-center gap-2">

                        <span class="font-bold">✓</span>

                        <span>
                            {{ session('success') }}
                        </span>

                    </div>

                </div>

            @endif


            @if (session('error'))

                <div class="dorm-alert-danger mb-6">

                    <div class="flex items-center gap-2">

                        <span class="font-bold">⚠</span>

                        <span>
                            {{ session('error') }}
                        </span>

                    </div>

                </div>

            @endif


            {{-- =====================================================
                 Summary
            ====================================================== --}}

            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">


                {{-- รายการมิเตอร์ --}}

                <div class="dorm-card p-5">

                    <div class="flex items-center gap-4">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700">

                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2M9 7a3 3 0 100-6 3 3 0 000 6z"
                                />

                            </svg>

                        </div>


                        <div>

                            <p class="text-sm text-gray-500">
                                รายการมิเตอร์
                            </p>

                            <p class="mt-1 text-2xl font-bold text-gray-900">

                                {{ $meterReadings->count() }}

                                <span class="text-sm font-medium text-gray-500">
                                    รายการ
                                </span>

                            </p>

                        </div>

                    </div>

                </div>


                {{-- ค่าน้ำรวม --}}

                <div class="dorm-card p-5">

                    <div class="flex items-center gap-4">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-700">

                            <span class="text-xl">
                                💧
                            </span>

                        </div>


                        <div>

                            <p class="text-sm text-gray-500">
                                ค่าน้ำรวม
                            </p>

                            <p class="mt-1 text-2xl font-bold text-blue-700">

                                {{ number_format($meterReadings->sum('water_charge'), 2) }}

                                <span class="text-sm font-medium text-gray-500">
                                    บาท
                                </span>

                            </p>

                        </div>

                    </div>

                </div>


                {{-- ค่าไฟรวม --}}

                <div class="dorm-card p-5">

                    <div class="flex items-center gap-4">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-yellow-50 text-yellow-700">

                            <span class="text-xl">
                                ⚡
                            </span>

                        </div>


                        <div>

                            <p class="text-sm text-gray-500">
                                ค่าไฟรวม
                            </p>

                            <p class="mt-1 text-2xl font-bold text-yellow-700">

                                {{ number_format($meterReadings->sum('electricity_charge'), 2) }}

                                <span class="text-sm font-medium text-gray-500">
                                    บาท
                                </span>

                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 Main Card
            ====================================================== --}}

            <div class="dorm-card overflow-hidden">


                {{-- Card Header --}}

                <div class="border-b border-gray-200 p-5 sm:p-6">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">


                        <div class="flex items-center gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-700">

                                <span class="text-xl">
                                    📊
                                </span>

                            </div>


                            <div>

                                <h3 class="text-lg font-bold text-gray-900">
                                    รายการมิเตอร์น้ำและไฟ
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    ตรวจสอบปริมาณการใช้และค่าใช้จ่ายของแต่ละห้อง
                                </p>

                            </div>

                        </div>


                        <a
                            href="{{ route('meter-readings.create') }}"
                            class="btn-primary w-full sm:w-auto"
                        >

                            <span class="text-lg leading-none">
                                +
                            </span>

                            เพิ่มข้อมูลมิเตอร์

                        </a>

                    </div>

                </div>


                {{-- =================================================
                     Table
                ================================================== --}}

                @if ($meterReadings->count() > 0)

                    <div class="overflow-x-auto">

                        <table class="dorm-table min-w-[1200px]">

                            <thead>

                                <tr>

                                    <th class="text-center">
                                        เดือน
                                    </th>

                                    <th>
                                        ผู้เช่า
                                    </th>

                                    <th class="text-center">
                                        ห้อง
                                    </th>

                                    <th class="text-right">
                                        น้ำก่อน
                                    </th>

                                    <th class="text-right">
                                        น้ำปัจจุบัน
                                    </th>

                                    <th class="text-right">
                                        ใช้น้ำ
                                    </th>

                                    <th class="text-right">
                                        ค่าน้ำ
                                    </th>

                                    <th class="text-right">
                                        ไฟก่อน
                                    </th>

                                    <th class="text-right">
                                        ไฟปัจจุบัน
                                    </th>

                                    <th class="text-right">
                                        ใช้ไฟ
                                    </th>

                                    <th class="text-right">
                                        ค่าไฟ
                                    </th>

                                    <th class="text-right">
                                        รวม
                                    </th>

                                    <th class="text-center">
                                        จัดการ
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach ($meterReadings as $meter)

                                    <tr>


                                        {{-- เดือน --}}

                                        <td class="text-center">

                                            <span class="font-semibold text-gray-900 whitespace-nowrap">

                                                {{ $meter->billing_month }}

                                            </span>

                                        </td>


                                        {{-- ผู้เช่า --}}

                                        <td>

                                            <div class="font-semibold text-gray-900">

                                                {{ $meter->tenant->name ?? '-' }}

                                            </div>

                                        </td>


                                        {{-- ห้อง --}}

                                        <td class="text-center">

                                            @if ($meter->room)

                                                <span class="inline-flex items-center rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-semibold text-gray-800">

                                                    ห้อง {{ $meter->room->room_number }}

                                                </span>

                                            @else

                                                <span class="text-gray-400">
                                                    -
                                                </span>

                                            @endif

                                        </td>


                                        {{-- น้ำก่อน --}}

                                        <td class="text-right">

                                            {{ number_format($meter->water_previous, 2) }}

                                        </td>


                                        {{-- น้ำปัจจุบัน --}}

                                        <td class="text-right">

                                            {{ number_format($meter->water_current, 2) }}

                                        </td>


                                        {{-- ใช้น้ำ --}}

                                        <td class="text-right">

                                            <span class="font-semibold text-blue-700">

                                                {{ number_format($meter->water_unit, 2) }}

                                            </span>

                                            <span class="text-xs text-gray-500">
                                                หน่วย
                                            </span>

                                        </td>


                                        {{-- ค่าน้ำ --}}

                                        <td class="text-right">

                                            <span class="font-semibold text-blue-700">

                                                {{ number_format($meter->water_charge, 2) }}

                                            </span>

                                            <span class="text-xs text-gray-500">
                                                บาท
                                            </span>

                                        </td>


                                        {{-- ไฟก่อน --}}

                                        <td class="text-right">

                                            {{ number_format($meter->electricity_previous, 2) }}

                                        </td>


                                        {{-- ไฟปัจจุบัน --}}

                                        <td class="text-right">

                                            {{ number_format($meter->electricity_current, 2) }}

                                        </td>


                                        {{-- ใช้ไฟ --}}

                                        <td class="text-right">

                                            <span class="font-semibold text-yellow-700">

                                                {{ number_format($meter->electricity_unit, 2) }}

                                            </span>

                                            <span class="text-xs text-gray-500">
                                                หน่วย
                                            </span>

                                        </td>


                                        {{-- ค่าไฟ --}}

                                        <td class="text-right">

                                            <span class="font-semibold text-yellow-700">

                                                {{ number_format($meter->electricity_charge, 2) }}

                                            </span>

                                            <span class="text-xs text-gray-500">
                                                บาท
                                            </span>

                                        </td>


                                        {{-- รวม --}}

                                        <td class="text-right">

                                            <span class="font-bold text-green-700">

                                                {{ number_format($meter->total_charge, 2) }}

                                            </span>

                                            <span class="text-xs text-gray-500">
                                                บาท
                                            </span>

                                        </td>


                                        {{-- จัดการ --}}

                                        <td>

                                            <div class="flex flex-wrap items-center justify-center gap-2">


                                                {{-- ดู --}}

                                                <a
                                                    href="{{ route('meter-readings.show', $meter->id) }}"
                                                    class="table-action-view"
                                                >
                                                    ดู
                                                </a>


                                                {{-- แก้ไข --}}

                                                <a
                                                    href="{{ route('meter-readings.edit', $meter->id) }}"
                                                    class="table-action-edit"
                                                >
                                                    แก้ไข
                                                </a>


                                                {{-- ลบ --}}

                                                <form
                                                    action="{{ route('meter-readings.destroy', $meter->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('ต้องการลบข้อมูลมิเตอร์นี้หรือไม่?');"
                                                >

                                                    @csrf

                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="table-action-delete"
                                                    >
                                                        ลบ
                                                    </button>

                                                </form>


                                            </div>

                                        </td>


                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                @else


                    {{-- =================================================
                         Empty State
                    ================================================== --}}

                    <div class="dorm-empty">

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-green-50 text-3xl">

                            📊

                        </div>


                        <h3 class="mt-4 text-lg font-bold text-gray-900">

                            ยังไม่มีข้อมูลมิเตอร์

                        </h3>


                        <p class="mt-1 text-sm text-gray-500">

                            เริ่มต้นด้วยการเพิ่มข้อมูลมิเตอร์ของผู้เช่า

                        </p>


                        <a
                            href="{{ route('meter-readings.create') }}"
                            class="btn-primary mt-5"
                        >

                            <span class="text-lg leading-none">
                                +
                            </span>

                            เพิ่มข้อมูลมิเตอร์รายการแรก

                        </a>

                    </div>


                @endif


            </div>

        </div>

    </div>

</x-app-layout>