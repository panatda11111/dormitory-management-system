<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800 leading-tight">
                    🧾 จัดการค่าใช้จ่าย
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    จัดการใบแจ้งค่าใช้จ่ายของผู้เช่า
                </p>
            </div>

            <a
                href="{{ route('bills.create') }}"
                class="inline-flex items-center justify-center px-5 py-2.5 bg-green-600 text-white rounded-lg font-semibold text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition"
            >
                <span class="mr-1">＋</span>
                เพิ่มใบแจ้งค่าใช้จ่าย
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- แจ้งเตือนสำเร็จ --}}
            @if (session('success'))
                <div
                    class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-4 text-green-800"
                    role="alert"
                >
                    <div class="flex items-start gap-3">
                        <span class="text-xl">✅</span>

                        <div>
                            <p class="font-semibold">
                                ดำเนินการสำเร็จ
                            </p>

                            <p class="text-sm mt-1">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- แจ้งเตือนข้อผิดพลาด --}}
            @if ($errors->any())
                <div
                    class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-4 text-red-800"
                    role="alert"
                >
                    <div class="flex items-start gap-3">
                        <span class="text-xl">⚠️</span>

                        <div class="flex-1">
                            <p class="font-semibold">
                                กรุณาตรวจสอบข้อมูล
                            </p>

                            <ul class="mt-2 list-disc list-inside text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Card หลัก --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- ส่วนหัว --}}
                <div class="px-5 py-5 sm:px-6 border-b border-gray-100">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <h3 class="text-lg font-bold text-gray-800">
                                🧾 รายการใบแจ้งค่าใช้จ่าย
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                ใบแจ้งค่าใช้จ่ายทั้งหมด
                                <span class="font-semibold text-gray-700">
                                    {{ $bills->count() }}
                                </span>
                                รายการ
                            </p>
                        </div>

                        <div class="text-sm text-gray-500">
                            ระบบจัดการค่าใช้จ่าย
                        </div>

                    </div>
                </div>

                @if ($bills->count() > 0)

                    {{-- Desktop / Tablet --}}
                    <div class="hidden md:block overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase whitespace-nowrap">
                                        เดือน
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase whitespace-nowrap">
                                        ผู้เช่า
                                    </th>

                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase whitespace-nowrap">
                                        ห้อง
                                    </th>

                                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-600 uppercase whitespace-nowrap">
                                        ค่าเช่า
                                    </th>

                                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-600 uppercase whitespace-nowrap">
                                        ค่าน้ำ
                                    </th>

                                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-600 uppercase whitespace-nowrap">
                                        ค่าไฟ
                                    </th>

                                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-600 uppercase whitespace-nowrap">
                                        อื่น ๆ
                                    </th>

                                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-600 uppercase whitespace-nowrap">
                                        ยอดรวม
                                    </th>

                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase whitespace-nowrap">
                                        ครบกำหนด
                                    </th>

                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase whitespace-nowrap">
                                        สถานะ
                                    </th>

                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase whitespace-nowrap">
                                        จัดการ
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-gray-100 bg-white">

                                @foreach ($bills as $bill)

                                    <tr class="hover:bg-gray-50 transition">

                                        {{-- เดือน --}}
                                        <td class="px-4 py-4 text-center text-sm text-gray-700 whitespace-nowrap">
                                            {{ $bill->billing_month }}
                                        </td>

                                        {{-- ผู้เช่า --}}
                                        <td class="px-4 py-4 whitespace-nowrap">

                                            <div class="font-semibold text-gray-800">
                                                {{ $bill->tenant?->name ?? '-' }}
                                            </div>

                                        </td>

                                        {{-- ห้อง --}}
                                        <td class="px-4 py-4 text-center whitespace-nowrap">

                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-100 text-gray-700 font-semibold text-sm">
                                                ห้อง {{ $bill->tenant?->room?->room_number ?? '-' }}
                                            </span>

                                        </td>

                                        {{-- ค่าเช่า --}}
                                        <td class="px-4 py-4 text-right text-sm text-gray-700 whitespace-nowrap">
                                            {{ number_format($bill->rent ?? 0, 2) }}
                                        </td>

                                        {{-- ค่าน้ำ --}}
                                        <td class="px-4 py-4 text-right text-sm text-gray-700 whitespace-nowrap">
                                            {{ number_format($bill->water ?? 0, 2) }}
                                        </td>

                                        {{-- ค่าไฟ --}}
                                        <td class="px-4 py-4 text-right text-sm text-gray-700 whitespace-nowrap">
                                            {{ number_format($bill->electricity ?? 0, 2) }}
                                        </td>

                                        {{-- ค่าใช้จ่ายอื่น --}}
                                        <td class="px-4 py-4 text-right text-sm text-gray-700 whitespace-nowrap">
                                            {{ number_format($bill->other_charge ?? 0, 2) }}
                                        </td>

                                        {{-- ยอดรวม --}}
                                        <td class="px-4 py-4 text-right whitespace-nowrap">

                                            <span class="font-bold text-gray-900">
                                                {{ number_format($bill->total ?? 0, 2) }}
                                            </span>

                                            <span class="text-xs text-gray-500">
                                                บาท
                                            </span>

                                        </td>

                                        {{-- วันครบกำหนด --}}
                                        <td class="px-4 py-4 text-center text-sm text-gray-700 whitespace-nowrap">

                                            @if ($bill->due_date)
                                                {{ $bill->due_date->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif

                                        </td>

                                        {{-- สถานะ --}}
                                        <td class="px-4 py-4 text-center whitespace-nowrap">

                                            @if ($bill->status === 'ชำระแล้ว')

                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                    🟢 ชำระแล้ว
                                                </span>

                                            @elseif ($bill->status === 'ค้างชำระ')

                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                                    🔴 ค้างชำระ
                                                </span>

                                            @elseif ($bill->status === 'เกินกำหนด')

                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                                                    ⚠️ เกินกำหนด
                                                </span>

                                            @else

                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                                                    {{ $bill->status ?? 'รอชำระ' }}
                                                </span>

                                            @endif

                                        </td>

                                        {{-- จัดการ --}}
                                        <td class="px-4 py-4">

                                            <div class="flex items-center justify-center gap-2">

                                                <a
                                                    href="{{ route('bills.show', $bill->id) }}"
                                                    class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition"
                                                >
                                                    👁️ ดู
                                                </a>

                                                <a
                                                    href="{{ route('bills.edit', $bill->id) }}"
                                                    class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 transition"
                                                >
                                                    ✏️ แก้ไข
                                                </a>

                                                <form
                                                    action="{{ route('bills.destroy', $bill->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('คุณต้องการลบใบแจ้งค่าใช้จ่ายรายการนี้ใช่หรือไม่?')"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 transition"
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


                    {{-- Mobile --}}
                    <div class="md:hidden divide-y divide-gray-100">

                        @foreach ($bills as $bill)

                            <div class="p-4">

                                {{-- หัวการ์ด --}}
                                <div class="flex items-start justify-between gap-3">

                                    <div class="min-w-0">

                                        <p class="font-bold text-gray-800 truncate">
                                            {{ $bill->tenant?->name ?? '-' }}
                                        </p>

                                        <p class="text-sm text-gray-500 mt-1">
                                            🏠 ห้อง {{ $bill->tenant?->room?->room_number ?? '-' }}
                                        </p>

                                    </div>

                                    @if ($bill->status === 'ชำระแล้ว')

                                        <span class="shrink-0 inline-flex px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                            🟢 ชำระแล้ว
                                        </span>

                                    @elseif ($bill->status === 'ค้างชำระ')

                                        <span class="shrink-0 inline-flex px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                            🔴 ค้างชำระ
                                        </span>

                                    @elseif ($bill->status === 'เกินกำหนด')

                                        <span class="shrink-0 inline-flex px-2.5 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                                            ⚠️ เกินกำหนด
                                        </span>

                                    @else

                                        <span class="shrink-0 inline-flex px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                                            {{ $bill->status ?? 'รอชำระ' }}
                                        </span>

                                    @endif

                                </div>


                                {{-- เดือน --}}
                                <div class="mt-4 rounded-xl bg-gray-50 p-3">

                                    <div class="flex justify-between gap-3 text-sm">
                                        <span class="text-gray-500">
                                            📅 เดือน
                                        </span>

                                        <span class="font-semibold text-gray-800 text-right">
                                            {{ $bill->billing_month }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between gap-3 text-sm mt-2">
                                        <span class="text-gray-500">
                                            🏠 ค่าเช่า
                                        </span>

                                        <span class="text-gray-800">
                                            {{ number_format($bill->rent ?? 0, 2) }} บาท
                                        </span>
                                    </div>

                                    <div class="flex justify-between gap-3 text-sm mt-2">
                                        <span class="text-gray-500">
                                            💧 ค่าน้ำ
                                        </span>

                                        <span class="text-gray-800">
                                            {{ number_format($bill->water ?? 0, 2) }} บาท
                                        </span>
                                    </div>

                                    <div class="flex justify-between gap-3 text-sm mt-2">
                                        <span class="text-gray-500">
                                            ⚡ ค่าไฟ
                                        </span>

                                        <span class="text-gray-800">
                                            {{ number_format($bill->electricity ?? 0, 2) }} บาท
                                        </span>
                                    </div>

                                    <div class="flex justify-between gap-3 text-sm mt-2">
                                        <span class="text-gray-500">
                                            💰 ค่าใช้จ่ายอื่น
                                        </span>

                                        <span class="text-gray-800">
                                            {{ number_format($bill->other_charge ?? 0, 2) }} บาท
                                        </span>
                                    </div>

                                    <div class="border-t border-gray-200 mt-3 pt-3 flex justify-between gap-3">

                                        <span class="font-bold text-gray-700">
                                            💰 ยอดรวม
                                        </span>

                                        <span class="font-bold text-green-700">
                                            {{ number_format($bill->total ?? 0, 2) }} บาท
                                        </span>

                                    </div>

                                    <div class="flex justify-between gap-3 text-sm mt-2">

                                        <span class="text-gray-500">
                                            📅 ครบกำหนด
                                        </span>

                                        <span class="text-gray-700">
                                            @if ($bill->due_date)
                                                {{ $bill->due_date->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </span>

                                    </div>

                                </div>


                                {{-- ปุ่มจัดการ --}}
                                <div class="grid grid-cols-3 gap-2 mt-4">

                                    <a
                                        href="{{ route('bills.show', $bill->id) }}"
                                        class="inline-flex items-center justify-center px-3 py-2 rounded-lg text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition"
                                    >
                                        👁️ ดู
                                    </a>

                                    <a
                                        href="{{ route('bills.edit', $bill->id) }}"
                                        class="inline-flex items-center justify-center px-3 py-2 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 transition"
                                    >
                                        ✏️ แก้ไข
                                    </a>

                                    <form
                                        action="{{ route('bills.destroy', $bill->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('คุณต้องการลบใบแจ้งค่าใช้จ่ายรายการนี้ใช่หรือไม่?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="w-full inline-flex items-center justify-center px-3 py-2 rounded-lg text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 transition"
                                        >
                                            🗑️ ลบ
                                        </button>

                                    </form>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    {{-- ไม่มีข้อมูล --}}
                    <div class="px-6 py-16 text-center">

                        <div class="text-6xl mb-5">
                            🧾
                        </div>

                        <h3 class="text-lg font-bold text-gray-800">
                            ยังไม่มีใบแจ้งค่าใช้จ่าย
                        </h3>

                        <p class="text-sm text-gray-500 mt-2">
                            เริ่มต้นด้วยการสร้างใบแจ้งค่าใช้จ่ายรายการแรก
                        </p>

                        <a
                            href="{{ route('bills.create') }}"
                            class="inline-flex items-center justify-center mt-5 px-5 py-2.5 bg-green-600 text-white rounded-lg font-semibold text-sm hover:bg-green-700 transition"
                        >
                            ＋ เพิ่มใบแจ้งค่าใช้จ่ายรายการแรก
                        </a>

                    </div>

                @endif

            </div>

        </div>
    </div>

</x-app-layout>