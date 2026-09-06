<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                    จัดการห้องพัก
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    จัดการข้อมูลห้องพักและตรวจสอบสถานะการเข้าพัก
                </p>
            </div>

            <a
                href="{{ route('rooms.create') }}"
                class="btn-primary w-full sm:w-auto"
            >
                <span class="text-lg leading-none">+</span>
                เพิ่มห้องพัก
            </a>
        </div>
    </x-slot>


    <div class="py-6 sm:py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- =====================================================
                 ALERTS
            ====================================================== --}}

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3">
                    <div class="flex items-center gap-3 text-sm font-medium text-green-700">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-green-100">
                            ✓
                        </span>

                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif


            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-4">

                    <div class="flex items-center gap-2 text-sm font-semibold text-red-700">
                        <span>⚠️</span>
                        <span>กรุณาตรวจสอบข้อมูล</span>
                    </div>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif


            {{-- =====================================================
                 SUMMARY
            ====================================================== --}}

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">

                {{-- Total --}}
                <div class="dorm-card p-4 sm:p-5">

                    <div class="flex items-center justify-between gap-3">

                        <div>
                            <p class="text-xs font-medium text-gray-500 sm:text-sm">
                                ห้องทั้งหมด
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl">
                                {{ $rooms->count() }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                ห้อง
                            </p>
                        </div>

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-lg sm:h-11 sm:w-11">
                            🏠
                        </div>

                    </div>

                </div>


                {{-- Available --}}
                <div class="dorm-card p-4 sm:p-5">

                    <div class="flex items-center justify-between gap-3">

                        <div>
                            <p class="text-xs font-medium text-gray-500 sm:text-sm">
                                ห้องว่าง
                            </p>

                            <p class="mt-2 text-2xl font-bold text-green-600 sm:text-3xl">
                                {{ $rooms->where('status', 'ว่าง')->count() }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                พร้อมให้เช่า
                            </p>
                        </div>

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-50 text-lg sm:h-11 sm:w-11">
                            ✓
                        </div>

                    </div>

                </div>


                {{-- Occupied --}}
                <div class="dorm-card p-4 sm:p-5">

                    <div class="flex items-center justify-between gap-3">

                        <div>
                            <p class="text-xs font-medium text-gray-500 sm:text-sm">
                                มีผู้เช่า
                            </p>

                            <p class="mt-2 text-2xl font-bold text-blue-600 sm:text-3xl">
                                {{ $rooms->where('status', 'มีผู้เช่า')->count() }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                ห้อง
                            </p>
                        </div>

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-lg sm:h-11 sm:w-11">
                            👤
                        </div>

                    </div>

                </div>


                {{-- Other status --}}
                <div class="dorm-card p-4 sm:p-5">

                    <div class="flex items-center justify-between gap-3">

                        <div>
                            <p class="text-xs font-medium text-gray-500 sm:text-sm">
                                จอง / ซ่อมแซม
                            </p>

                            <p class="mt-2 text-2xl font-bold text-yellow-600 sm:text-3xl">
                                {{
                                    $rooms->whereIn('status', ['จอง', 'ซ่อมแซม'])->count()
                                }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                ห้อง
                            </p>
                        </div>

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-yellow-50 text-lg sm:h-11 sm:w-11">
                            ⚠️
                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 ROOM LIST
            ====================================================== --}}

            <div class="dorm-card mt-6 overflow-hidden">

                {{-- Section Header --}}
                <div class="border-b border-gray-200 px-5 py-5 sm:px-6">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-700">

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
                                        d="M3 10.5L12 3l9 7.5M5 9.5V21h14V9.5M9 21v-6h6v6"
                                    />
                                </svg>

                            </div>

                            <div>

                                <h3 class="text-lg font-bold text-gray-900">
                                    รายการห้องพัก
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    ข้อมูลห้องพักทั้งหมดของหอพัก
                                </p>

                            </div>

                        </div>


                        <div class="text-sm text-gray-500">
                            ทั้งหมด
                            <span class="font-semibold text-gray-900">
                                {{ $rooms->count() }}
                            </span>
                            ห้อง
                        </div>

                    </div>

                </div>


                {{-- =================================================
                     ROOM TABLE
                ================================================== --}}

                @if ($rooms->count() > 0)

                    <div class="overflow-x-auto">

                        <table class="dorm-table min-w-[850px]">

                            <thead>
                                <tr>

                                    <th class="w-24 text-center">
                                        ห้อง
                                    </th>

                                    <th class="w-20 text-center">
                                        ชั้น
                                    </th>

                                    <th>
                                        ประเภทห้อง
                                    </th>

                                    <th class="text-right">
                                        ค่าเช่ารายเดือน
                                    </th>

                                    <th class="text-center">
                                        สถานะ
                                    </th>

                                    <th class="w-48 text-center">
                                        จัดการ
                                    </th>

                                </tr>
                            </thead>


                            <tbody>

                                @foreach ($rooms as $room)

                                    <tr>

                                        {{-- Room Number --}}
                                        <td class="text-center">

                                            <span class="inline-flex min-w-12 items-center justify-center rounded-lg bg-gray-100 px-3 py-1.5 font-bold text-gray-900">
                                                {{ $room->room_number }}
                                            </span>

                                        </td>


                                        {{-- Floor --}}
                                        <td class="text-center">

                                            <span class="text-sm font-medium text-gray-700">
                                                {{ $room->floor }}
                                            </span>

                                        </td>


                                        {{-- Room Type --}}
                                        <td>

                                            <div class="font-medium text-gray-800">
                                                {{ $room->room_type }}
                                            </div>

                                            @if (!empty($room->description))
                                                <div class="mt-1 max-w-xs truncate text-xs text-gray-400">
                                                    {{ $room->description }}
                                                </div>
                                            @endif

                                        </td>


                                        {{-- Rent --}}
                                        <td class="text-right">

                                            <span class="font-semibold text-gray-900">
                                                {{ number_format($room->rent, 2) }}
                                            </span>

                                            <span class="text-xs text-gray-500">
                                                บาท
                                            </span>

                                        </td>


                                        {{-- Status --}}
                                        <td class="text-center">

                                            @if ($room->status === 'ว่าง')

                                                <span class="status-success">
                                                    <span>●</span>
                                                    ว่าง
                                                </span>

                                            @elseif ($room->status === 'มีผู้เช่า')

                                                <span class="status-danger">
                                                    <span>●</span>
                                                    มีผู้เช่า
                                                </span>

                                            @elseif ($room->status === 'จอง')

                                                <span class="status-warning">
                                                    <span>●</span>
                                                    จอง
                                                </span>

                                            @elseif ($room->status === 'ซ่อมแซม')

                                                <span class="inline-flex items-center gap-1 rounded-full bg-orange-100 px-2.5 py-1 text-xs font-semibold text-orange-700">
                                                    <span>●</span>
                                                    ซ่อมแซม
                                                </span>

                                            @else

                                                <span class="status-info">
                                                    {{ $room->status }}
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Actions --}}
                                        <td>

                                            <div class="flex items-center justify-center gap-2">

                                                <a
                                                    href="{{ route('rooms.edit', $room->id) }}"
                                                    class="inline-flex items-center justify-center rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 transition hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                >
                                                    <span class="mr-1">✏️</span>
                                                    แก้ไข
                                                </a>


                                                <form
                                                    action="{{ route('rooms.destroy', $room->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('คุณต้องการลบห้อง {{ $room->room_number }} ใช่หรือไม่?')"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500"
                                                    >
                                                        <span class="mr-1">🗑️</span>
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
                         EMPTY STATE
                    ================================================== --}}

                    <div class="px-5 py-16 text-center sm:px-6">

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-green-50 text-3xl">
                            🏠
                        </div>

                        <h3 class="mt-5 text-lg font-bold text-gray-900">
                            ยังไม่มีข้อมูลห้องพัก
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">
                            เริ่มต้นจัดการหอพักด้วยการเพิ่มห้องพักเข้าสู่ระบบ
                        </p>

                        <a
                            href="{{ route('rooms.create') }}"
                            class="btn-primary mt-6"
                        >
                            <span class="mr-2 text-lg">+</span>
                            เพิ่มห้องพัก
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>