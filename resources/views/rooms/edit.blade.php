<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            แก้ไขห้องพัก
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-6">
                        🏠 แก้ไขข้อมูลห้องพัก
                    </h3>

                    <form action="{{ route('rooms.update', $room->id) }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                เลขห้อง
                            </label>

                            <input
                                type="text"
                                name="room_number"
                                value="{{ old('room_number', $room->room_number) }}"
                                class="w-full border-gray-300 rounded-lg"
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
                                value="{{ old('floor', $room->floor) }}"
                                class="w-full border-gray-300 rounded-lg"
                            >
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                ประเภทห้อง
                            </label>

                            <select
                                name="room_type"
                                class="w-full border-gray-300 rounded-lg"
                            >

                                <option value="ห้องธรรมดา"
                                    {{ $room->room_type == 'ห้องธรรมดา' ? 'selected' : '' }}>
                                    ห้องธรรมดา
                                </option>

                                <option value="ห้องแอร์"
                                    {{ $room->room_type == 'ห้องแอร์' ? 'selected' : '' }}>
                                    ห้องแอร์
                                </option>

                                <option value="ห้องพิเศษ"
                                    {{ $room->room_type == 'ห้องพิเศษ' ? 'selected' : '' }}>
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
                                value="{{ old('rent', $room->rent) }}"
                                class="w-full border-gray-300 rounded-lg"
                                min="0"
                                step="0.01"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                สถานะห้อง
                            </label>

                            <select
                                name="status"
                                class="w-full border-gray-300 rounded-lg"
                            >

                                <option value="ว่าง"
                                    {{ $room->status == 'ว่าง' ? 'selected' : '' }}>
                                    ว่าง
                                </option>

                                <option value="มีผู้เช่า"
                                    {{ $room->status == 'มีผู้เช่า' ? 'selected' : '' }}>
                                    มีผู้เช่า
                                </option>

                                <option value="จอง"
                                    {{ $room->status == 'จอง' ? 'selected' : '' }}>
                                    จอง
                                </option>

                                <option value="ซ่อมแซม"
                                    {{ $room->status == 'ซ่อมแซม' ? 'selected' : '' }}>
                                    ซ่อมแซม
                                </option>

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
                            >{{ old('description', $room->description) }}</textarea>
                        </div>

                        <div class="flex gap-3">

                            <button
                                type="submit"
                                class="px-5 py-2 bg-blue-600 text-white rounded-lg"
                            >
                                💾 บันทึกการแก้ไข
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