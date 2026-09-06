<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            เพิ่มห้องพัก
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-6">
                        🏠 ข้อมูลห้องพัก
                    </h3>

                    <form action="{{ route('rooms.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                เลขห้อง
                            </label>

                            <input
                                type="text"
                                name="room_number"
                                value="{{ old('room_number') }}"
                                class="w-full border-gray-300 rounded-lg"
                                placeholder="เช่น 101"
                                required
                            >

                            @error('room_number')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                ชั้น
                            </label>

                            <input
                                type="text"
                                name="floor"
                                value="{{ old('floor') }}"
                                class="w-full border-gray-300 rounded-lg"
                                placeholder="เช่น 1"
                            >

                            @error('floor')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                ประเภทห้อง
                            </label>

                            <select
                                name="room_type"
                                class="w-full border-gray-300 rounded-lg"
                            >
                                <option value="ห้องธรรมดา">
                                    ห้องธรรมดา
                                </option>

                                <option value="ห้องแอร์">
                                    ห้องแอร์
                                </option>

                                <option value="ห้องพิเศษ">
                                    ห้องพิเศษ
                                </option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                ค่าเช่า
                            </label>

                            <input
                                type="number"
                                name="rent"
                                value="{{ old('rent') }}"
                                class="w-full border-gray-300 rounded-lg"
                                placeholder="เช่น 3500"
                                min="0"
                                step="0.01"
                                required
                            >

                            @error('rent')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                สถานะห้อง
                            </label>

                            <select
                                name="status"
                                class="w-full border-gray-300 rounded-lg"
                            >
                                <option value="ว่าง">ว่าง</option>
                                <option value="มีผู้เช่า">มีผู้เช่า</option>
                                <option value="จอง">จอง</option>
                                <option value="ซ่อมแซม">ซ่อมแซม</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block font-medium mb-2">
                                รายละเอียด
                            </label>

                            <textarea
                                name="description"
                                rows="4"
                                class="w-full border-gray-300 rounded-lg"
                                placeholder="รายละเอียดเพิ่มเติม"
                            >{{ old('description') }}</textarea>
                        </div>

                        <div class="flex gap-3">

                            <button
                                type="submit"
                                class="px-5 py-2 bg-blue-600 text-white rounded-lg"
                            >
                                💾 บันทึกห้องพัก
                            </button>

                            <a
                                href="{{ route('rooms.index') }}"
                                class="px-5 py-2 bg-gray-500 text-white rounded-lg"
                            >
                                ยกเลิก
                            </a>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>