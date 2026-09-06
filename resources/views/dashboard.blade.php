<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 text-green-700">
                        <svg class="h-5 w-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M3 10.5L12 3l9 7.5M5 9.5V21h14V9.5M9 21v-6h6v6"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                            แดชบอร์ด
                        </h2>

                        <p class="mt-0.5 text-sm text-gray-500">
                            ภาพรวมการบริหารจัดการหอพัก
                        </p>
                    </div>
                </div>
            </div>

            <div class="hidden rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm text-gray-500 shadow-sm sm:block">
                ระบบบริหารจัดการหอพักออนไลน์
            </div>
        </div>
    </x-slot>


    <div class="py-6 sm:py-8">

        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">


            {{-- =========================================================
                 WELCOME / OVERVIEW
            ========================================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="flex flex-col gap-4 p-5 sm:p-6 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <p class="text-sm font-medium text-green-700">
                            ภาพรวมระบบ
                        </p>

                        <h3 class="mt-1 text-xl font-bold text-gray-900">
                            ยินดีต้อนรับสู่ระบบบริหารจัดการหอพัก
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            ตรวจสอบข้อมูลห้องพัก ผู้เช่า ค่าใช้จ่าย และการชำระเงินได้จากหน้านี้
                        </p>
                    </div>

                    <a href="{{ route('bills.index') }}"
                       class="inline-flex w-full items-center justify-center rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:w-auto">
                        ดูใบแจ้งค่าใช้จ่าย
                        <span class="ml-2">→</span>
                    </a>

                </div>

            </div>


            {{-- =========================================================
                 SUMMARY CARDS
            ========================================================== --}}

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">


                {{-- ห้องพัก --}}
                <a href="{{ route('rooms.index') }}"
                   class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-green-200 hover:shadow-md">

                    <div class="flex items-start justify-between">

                        <div class="min-w-0">

                            <p class="text-sm font-medium text-gray-500">
                                ห้องพักทั้งหมด
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">
                                {{ $totalRooms }}
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                ห้อง
                            </p>

                        </div>

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-700">

                            <svg class="h-6 w-6"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M3 10.5L12 3l9 7.5M5 9.5V21h14V9.5M9 21v-6h6v6"/>
                            </svg>

                        </div>

                    </div>

                    <div class="mt-4 flex items-center text-sm font-semibold text-green-700">
                        จัดการห้องพัก
                        <span class="ml-1 transition-transform duration-200 group-hover:translate-x-1">
                            →
                        </span>
                    </div>

                </a>


                {{-- ผู้เช่า --}}
                <a href="{{ route('tenants.index') }}"
                   class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-md">

                    <div class="flex items-start justify-between">

                        <div class="min-w-0">

                            <p class="text-sm font-medium text-gray-500">
                                ผู้เช่าปัจจุบัน
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">
                                {{ $totalTenants }}
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                คน
                            </p>

                        </div>

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-700">

                            <svg class="h-6 w-6"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                            </svg>

                        </div>

                    </div>

                    <div class="mt-4 flex items-center text-sm font-semibold text-blue-700">
                        จัดการผู้เช่า
                        <span class="ml-1 transition-transform duration-200 group-hover:translate-x-1">
                            →
                        </span>
                    </div>

                </a>


                {{-- บิล --}}
                <a href="{{ route('bills.index') }}"
                   class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-indigo-200 hover:shadow-md">

                    <div class="flex items-start justify-between">

                        <div class="min-w-0">

                            <p class="text-sm font-medium text-gray-500">
                                ใบแจ้งค่าใช้จ่าย
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">
                                {{ $totalBills }}
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                รายการทั้งหมด
                            </p>

                        </div>

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700">

                            <svg class="h-6 w-6"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M9 14h6M9 18h6M9 6h6M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                            </svg>

                        </div>

                    </div>

                    <div class="mt-4 flex items-center text-sm font-semibold text-indigo-700">
                        ดูใบแจ้งค่าใช้จ่าย
                        <span class="ml-1 transition-transform duration-200 group-hover:translate-x-1">
                            →
                        </span>
                    </div>

                </a>


                {{-- ค้างชำระ --}}
                <a href="{{ route('bills.index') }}"
                   class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1
                   {{ ($unpaidBills + $overdueBills) > 0 ? 'hover:border-red-200' : 'hover:border-green-200' }}">

                    <div class="flex items-start justify-between">

                        <div class="min-w-0">

                            <p class="text-sm font-medium text-gray-500">
                                รายการค้างชำระ
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight
                                {{ ($unpaidBills + $overdueBills) > 0 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $unpaidBills + $overdueBills }}
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                รายการ
                            </p>

                        </div>

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl
                            {{ ($unpaidBills + $overdueBills) > 0 ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }}">

                            <svg class="h-6 w-6"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M12 9v4m0 4h.01M10.29 3.86L2.82 17a2 2 0 001.74 3h14.88a2 2 0 001.74-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            </svg>

                        </div>

                    </div>

                    <div class="mt-4 flex items-center text-sm font-semibold
                        {{ ($unpaidBills + $overdueBills) > 0 ? 'text-red-600' : 'text-green-600' }}">

                        {{ ($unpaidBills + $overdueBills) > 0 ? 'ต้องติดตาม' : 'ไม่มีรายการค้างชำระ' }}

                    </div>

                </a>

            </div>


            {{-- =========================================================
                 ROOM STATUS
            ========================================================== --}}

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                    <div>
                        <h3 class="text-lg font-bold text-gray-900">
                            สถานะห้องพัก
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            สรุปสถานะห้องพักทั้งหมดในระบบ
                        </p>
                    </div>

                    <a href="{{ route('rooms.index') }}"
                       class="inline-flex items-center text-sm font-semibold text-green-700 hover:text-green-800">
                        ดูห้องพักทั้งหมด
                        <span class="ml-1">→</span>
                    </a>

                </div>


                <div class="mt-5 grid grid-cols-2 gap-3 lg:grid-cols-4">


                    {{-- มีผู้เช่า --}}
                    <div class="rounded-xl border border-green-100 bg-green-50 p-4">

                        <div class="flex items-center justify-between gap-2">

                            <span class="text-sm font-semibold text-green-700">
                                มีผู้เช่า
                            </span>

                            <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-green-500"></span>

                        </div>

                        <p class="mt-3 text-2xl font-bold text-green-700">
                            {{ $occupiedRooms }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            ห้อง
                        </p>

                    </div>


                    {{-- ห้องว่าง --}}
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                        <div class="flex items-center justify-between gap-2">

                            <span class="text-sm font-semibold text-gray-700">
                                ห้องว่าง
                            </span>

                            <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-gray-400"></span>

                        </div>

                        <p class="mt-3 text-2xl font-bold text-gray-700">
                            {{ $availableRooms }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            ห้อง
                        </p>

                    </div>


                    {{-- จอง --}}
                    <div class="rounded-xl border border-yellow-100 bg-yellow-50 p-4">

                        <div class="flex items-center justify-between gap-2">

                            <span class="text-sm font-semibold text-yellow-700">
                                จอง
                            </span>

                            <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-yellow-500"></span>

                        </div>

                        <p class="mt-3 text-2xl font-bold text-yellow-700">
                            {{ $reservedRooms }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            ห้อง
                        </p>

                    </div>


                    {{-- ซ่อมแซม --}}
                    <div class="rounded-xl border border-red-100 bg-red-50 p-4">

                        <div class="flex items-center justify-between gap-2">

                            <span class="text-sm font-semibold text-red-700">
                                ซ่อมแซม
                            </span>

                            <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-red-500"></span>

                        </div>

                        <p class="mt-3 text-2xl font-bold text-red-700">
                            {{ $maintenanceRooms }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            ห้อง
                        </p>

                    </div>

                </div>

            </div>


            {{-- =========================================================
                 FINANCIAL SUMMARY
            ========================================================== --}}

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">


                {{-- สรุปการชำระเงิน --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">

                    <div class="flex items-start justify-between gap-4">

                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                สรุปการชำระเงิน
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                สถานะใบแจ้งค่าใช้จ่าย
                            </p>
                        </div>

                        <a href="{{ route('payments.index') }}"
                           class="shrink-0 text-sm font-semibold text-green-700 hover:text-green-800">
                            ดูรายการ →
                        </a>

                    </div>


                    <div class="mt-5 space-y-3">

                        <div class="flex items-center justify-between gap-3 rounded-xl border border-green-100 bg-green-50 px-4 py-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-green-500"></span>

                                <span class="text-sm font-medium text-green-700">
                                    ชำระแล้ว
                                </span>

                            </div>

                            <span class="shrink-0 font-bold text-green-700">
                                {{ $paidBills }} รายการ
                            </span>

                        </div>


                        <div class="flex items-center justify-between gap-3 rounded-xl border border-red-100 bg-red-50 px-4 py-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-red-500"></span>

                                <span class="text-sm font-medium text-red-700">
                                    ค้างชำระ
                                </span>

                            </div>

                            <span class="shrink-0 font-bold text-red-700">
                                {{ $unpaidBills }} รายการ
                            </span>

                        </div>


                        <div class="flex items-center justify-between gap-3 rounded-xl border border-yellow-100 bg-yellow-50 px-4 py-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-yellow-500"></span>

                                <span class="text-sm font-medium text-yellow-700">
                                    เกินกำหนด
                                </span>

                            </div>

                            <span class="shrink-0 font-bold text-yellow-700">
                                {{ $overdueBills }} รายการ
                            </span>

                        </div>

                    </div>

                </div>


                {{-- รายรับ --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">

                    <div class="flex items-start justify-between gap-4">

                        <div class="min-w-0">

                            <p class="text-sm font-medium text-gray-500">
                                รายรับจากการชำระเงิน
                            </p>

                            <p class="mt-2 break-words text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                                {{ number_format($totalIncome, 2) }}
                                <span class="text-base font-medium text-gray-500">
                                    บาท
                                </span>
                            </p>

                            <p class="mt-2 text-sm text-gray-500">
                                จากรายการชำระเงินทั้งหมด
                                <span class="font-semibold text-gray-700">
                                    {{ $totalPayments }}
                                </span>
                                รายการ
                            </p>

                        </div>

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">

                            <svg class="h-6 w-6"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M12 8c-2.21 0-4 1.343-4 3s1.79 3 4 3 4 1.343 4 3-1.79 3-4 3m0-12V6m0 14v-2M5 12H3m18 0h-2"/>

                            </svg>

                        </div>

                    </div>


                    <div class="mt-5 rounded-xl border border-gray-200 bg-gray-50 p-4">

                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                            <span class="text-sm font-medium text-gray-500">
                                ยอดค้างชำระ
                            </span>

                            <span class="font-bold
                                {{ $pendingAmount > 0 ? 'text-red-600' : 'text-green-600' }}">

                                {{ number_format($pendingAmount, 2) }} บาท

                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
                 QUICK MENU
            ========================================================== --}}

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">

                <div>
                    <h3 class="text-lg font-bold text-gray-900">
                        เมนูการจัดการ
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        เข้าถึงฟังก์ชันหลักของระบบได้อย่างรวดเร็ว
                    </p>
                </div>


                <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">


                    {{-- ห้องพัก --}}
                    <a href="{{ route('rooms.index') }}"
                       class="group rounded-xl border border-gray-200 bg-white p-4 text-center transition duration-200 hover:-translate-y-0.5 hover:border-green-300 hover:bg-green-50 hover:shadow-sm">

                        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-green-700">

                            <svg class="h-5 w-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M3 10.5L12 3l9 7.5M5 9.5V21h14V9.5"/>

                            </svg>

                        </div>

                        <p class="mt-3 text-sm font-semibold text-gray-700 group-hover:text-green-700">
                            ห้องพัก
                        </p>

                    </a>


                    {{-- ผู้เช่า --}}
                    <a href="{{ route('tenants.index') }}"
                       class="group rounded-xl border border-gray-200 bg-white p-4 text-center transition duration-200 hover:-translate-y-0.5 hover:border-blue-300 hover:bg-blue-50 hover:shadow-sm">

                        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-700">

                            <svg class="h-5 w-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8z"/>

                            </svg>

                        </div>

                        <p class="mt-3 text-sm font-semibold text-gray-700 group-hover:text-blue-700">
                            ผู้เช่า
                        </p>

                    </a>


                    {{-- มิเตอร์ --}}
                    <a href="{{ route('meter-readings.index') }}"
                       class="group rounded-xl border border-gray-200 bg-white p-4 text-center transition duration-200 hover:-translate-y-0.5 hover:border-orange-300 hover:bg-orange-50 hover:shadow-sm">

                        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-orange-100 text-orange-700">

                            <svg class="h-5 w-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M13 2L4 14h7l-1 8 9-12h-7l1-8z"/>

                            </svg>

                        </div>

                        <p class="mt-3 text-sm font-semibold text-gray-700 group-hover:text-orange-700">
                            มิเตอร์
                        </p>

                    </a>


                    {{-- ค่าใช้จ่าย --}}
                    <a href="{{ route('bills.index') }}"
                       class="group rounded-xl border border-gray-200 bg-white p-4 text-center transition duration-200 hover:-translate-y-0.5 hover:border-indigo-300 hover:bg-indigo-50 hover:shadow-sm">

                        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700">

                            <svg class="h-5 w-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M9 14h6M9 18h6M9 6h6M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>

                            </svg>

                        </div>

                        <p class="mt-3 text-sm font-semibold text-gray-700 group-hover:text-indigo-700">
                            ค่าใช้จ่าย
                        </p>

                    </a>


                    {{-- การชำระเงิน --}}
                    <a href="{{ route('payments.index') }}"
                       class="group rounded-xl border border-gray-200 bg-white p-4 text-center transition duration-200 hover:-translate-y-0.5 hover:border-purple-300 hover:bg-purple-50 hover:shadow-sm">

                        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-purple-100 text-purple-700">

                            <svg class="h-5 w-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M3 10h18M7 15h2m4 0h4M5 6h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>

                            </svg>

                        </div>

                        <p class="mt-3 text-sm font-semibold text-gray-700 group-hover:text-purple-700">
                            การชำระเงิน
                        </p>

                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>