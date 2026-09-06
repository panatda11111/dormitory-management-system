<nav x-data="{ open: false }">

    {{-- =========================================================
         DESKTOP SIDEBAR
    ========================================================== --}}
    <aside
        class="hidden lg:flex fixed inset-y-0 left-0 z-40
               w-64 bg-white border-r border-gray-200
               flex-col">

        {{-- Logo --}}
        <div class="h-20 flex items-center px-6 border-b border-gray-200">

            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3">

                <div
                    class="w-10 h-10 rounded-xl bg-green-600
                           flex items-center justify-center
                           text-white text-xl shadow-sm">
                    🏠
                </div>

                <div class="min-w-0">

                    <div class="font-bold text-gray-800 text-sm truncate">
                        ระบบบริหารจัดการหอพัก
                    </div>

                    <div class="text-xs text-gray-400 mt-0.5">
                        Dormitory Management
                    </div>

                </div>

            </a>

        </div>


        {{-- =====================================================
             USER INFORMATION
        ====================================================== --}}
        <div class="px-5 py-5 border-b border-gray-100">

            <div class="flex items-center gap-3">

                <div
                    class="w-11 h-11 shrink-0 rounded-full
                           bg-green-100
                           flex items-center justify-center
                           text-green-700 font-bold">

                    {{ mb_substr(Auth::user()->name, 0, 1) }}

                </div>

                <div class="min-w-0">

                    <div
                        class="font-semibold text-gray-800 text-sm truncate">

                        {{ Auth::user()->name }}

                    </div>

                    <div class="text-xs text-gray-500 mt-0.5">

                        @if (Auth::user()->role === 'admin')
                            ผู้ดูแลระบบ
                        @else
                            ผู้เช่า
                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             MAIN MENU
        ====================================================== --}}
        <div class="flex-1 overflow-y-auto px-4 py-5">

            <div
                class="text-xs font-semibold text-gray-400
                       uppercase tracking-wider px-3 mb-3">

                เมนูหลัก

            </div>


            {{-- =================================================
                 DASHBOARD
            ================================================== --}}
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-3 py-3
                       rounded-xl text-sm font-medium mb-1
                       transition duration-200
                       {{ request()->routeIs('dashboard')
                            ? 'bg-green-50 text-green-700'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                <span class="text-lg leading-none">📊</span>

                <span>แดชบอร์ด</span>

            </a>


            {{-- =================================================
                 ADMIN MENU
            ================================================== --}}
            @if (Auth::user()->role === 'admin')

                {{-- Rooms --}}
                <a
                    href="{{ route('rooms.index') }}"
                    class="flex items-center gap-3 px-3 py-3
                           rounded-xl text-sm font-medium mb-1
                           transition duration-200
                           {{ request()->routeIs('rooms.*')
                                ? 'bg-green-50 text-green-700'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                    <span class="text-lg leading-none">🏠</span>

                    <span>จัดการห้องพัก</span>

                </a>


                {{-- Tenants --}}
                <a
                    href="{{ route('tenants.index') }}"
                    class="flex items-center gap-3 px-3 py-3
                           rounded-xl text-sm font-medium mb-1
                           transition duration-200
                           {{ request()->routeIs('tenants.*')
                                ? 'bg-green-50 text-green-700'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                    <span class="text-lg leading-none">👤</span>

                    <span>จัดการผู้เช่า</span>

                </a>


                {{-- Meter Readings --}}
                <a
                    href="{{ route('meter-readings.index') }}"
                    class="flex items-center gap-3 px-3 py-3
                           rounded-xl text-sm font-medium mb-1
                           transition duration-200
                           {{ request()->routeIs('meter-readings.*')
                                ? 'bg-green-50 text-green-700'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                    <span class="text-lg leading-none">⚡</span>

                    <span>มิเตอร์น้ำ / ไฟ</span>

                </a>


                {{-- Bills --}}
                <a
                    href="{{ route('bills.index') }}"
                    class="flex items-center gap-3 px-3 py-3
                           rounded-xl text-sm font-medium mb-1
                           transition duration-200
                           {{ request()->routeIs('bills.*')
                                ? 'bg-green-50 text-green-700'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                    <span class="text-lg leading-none">🧾</span>

                    <span>ค่าใช้จ่าย</span>

                </a>


                {{-- Payments --}}
                <a
                    href="{{ route('payments.index') }}"
                    class="flex items-center gap-3 px-3 py-3
                           rounded-xl text-sm font-medium mb-1
                           transition duration-200
                           {{ request()->routeIs('payments.*')
                                ? 'bg-green-50 text-green-700'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                    <span class="text-lg leading-none">💳</span>

                    <span>การชำระเงิน</span>

                </a>

            @endif


            {{-- =================================================
                 TENANT MENU
            ================================================== --}}
            @if (Auth::user()->role === 'tenant')

                {{-- Tenant Bills --}}
                <a
                    href="{{ route('tenant.bills') }}"
                    class="flex items-center gap-3 px-3 py-3
                           rounded-xl text-sm font-medium mb-1
                           transition duration-200
                           {{ request()->routeIs('tenant.bills*')
                                ? 'bg-green-50 text-green-700'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                    <span class="text-lg leading-none">🧾</span>

                    <span>ใบแจ้งค่าใช้จ่าย</span>

                </a>


                {{-- Tenant Payments --}}
                <a
                    href="{{ route('tenant.payments') }}"
                    class="flex items-center gap-3 px-3 py-3
                           rounded-xl text-sm font-medium mb-1
                           transition duration-200
                           {{ request()->routeIs('tenant.payments')
                                ? 'bg-green-50 text-green-700'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                    <span class="text-lg leading-none">💳</span>

                    <span>ประวัติการชำระเงิน</span>

                </a>

            @endif

        </div>


        {{-- =====================================================
             SIDEBAR BOTTOM
        ====================================================== --}}
        <div class="p-4 border-t border-gray-200">

            {{-- Profile --}}
            <a
                href="{{ route('profile.edit') }}"
                class="flex items-center gap-3
                       px-3 py-3 rounded-xl
                       text-sm text-gray-600
                       hover:bg-gray-50 hover:text-gray-900
                       transition duration-200">

                <span class="text-lg leading-none">⚙️</span>

                <span>ตั้งค่าบัญชี</span>

            </a>


            {{-- Logout --}}
            <form
                method="POST"
                action="{{ route('logout') }}">

                @csrf

                <button
                    type="submit"
                    class="w-full flex items-center gap-3
                           px-3 py-3 rounded-xl
                           text-sm text-red-600
                           hover:bg-red-50
                           transition duration-200">

                    <span class="text-lg leading-none">🚪</span>

                    <span>ออกจากระบบ</span>

                </button>

            </form>

        </div>

    </aside>


    {{-- =========================================================
         DESKTOP TOPBAR
    ========================================================== --}}
    <header
        class="hidden lg:flex fixed top-0 right-0 left-64 z-30
               h-20 bg-white border-b border-gray-200
               items-center justify-between px-8">

        {{-- Page Title --}}
        <div class="min-w-0">

            <div class="text-lg font-bold text-gray-800">

                @if (request()->routeIs('dashboard'))

                    แดชบอร์ด

                @elseif (request()->routeIs('rooms.*'))

                    จัดการห้องพัก

                @elseif (request()->routeIs('tenants.*'))

                    จัดการผู้เช่า

                @elseif (request()->routeIs('meter-readings.*'))

                    มิเตอร์น้ำ / ไฟ

                @elseif (request()->routeIs('bills.*'))

                    ค่าใช้จ่าย

                @elseif (request()->routeIs('payments.*'))

                    การชำระเงิน

                @elseif (request()->routeIs('tenant.bills*'))

                    ใบแจ้งค่าใช้จ่าย

                @elseif (request()->routeIs('tenant.payments'))

                    ประวัติการชำระเงิน

                @elseif (request()->routeIs('profile.*'))

                    ตั้งค่าบัญชี

                @else

                    ระบบบริหารจัดการหอพัก

                @endif

            </div>

            <div class="text-xs text-gray-400 mt-1">
                ระบบบริหารจัดการหอพักออนไลน์
            </div>

        </div>


        {{-- Current User --}}
        <div class="flex items-center gap-4 shrink-0">

            <div class="text-right">

                <div class="text-sm font-semibold text-gray-800">
                    {{ Auth::user()->name }}
                </div>

                <div class="text-xs text-gray-500">

                    @if (Auth::user()->role === 'admin')
                        ผู้ดูแลระบบ
                    @else
                        ผู้เช่า
                    @endif

                </div>

            </div>


            <div
                class="w-10 h-10 rounded-full
                       bg-green-100
                       flex items-center justify-center
                       text-green-700 font-bold">

                {{ mb_substr(Auth::user()->name, 0, 1) }}

            </div>

        </div>

    </header>


    {{-- =========================================================
         MOBILE HEADER
    ========================================================== --}}
    <header
        class="lg:hidden h-16 bg-white border-b border-gray-200
               flex items-center justify-between px-4
               sticky top-0 z-40">

        <a
            href="{{ route('dashboard') }}"
            class="flex items-center gap-2 min-w-0">

            <div
                class="w-9 h-9 shrink-0 rounded-lg
                       bg-green-600
                       flex items-center justify-center
                       text-white">

                🏠

            </div>

            <span class="font-bold text-gray-800 text-sm truncate">
                ระบบบริหารจัดการหอพัก
            </span>

        </a>


        {{-- Mobile Menu Button --}}
        <button
            type="button"
            @click="open = !open"
            class="shrink-0 p-2 rounded-lg
                   text-gray-600
                   hover:bg-gray-100
                   focus:outline-none
                   focus:ring-2
                   focus:ring-green-500"
            :aria-expanded="open.toString()"
            aria-controls="mobile-navigation"
            aria-label="เปิดเมนู">

            <svg
                class="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                aria-hidden="true">

                {{-- Hamburger --}}
                <path
                    x-show="!open"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />

                {{-- Close --}}
                <path
                    x-show="open"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />

            </svg>

        </button>

    </header>


    {{-- =========================================================
         MOBILE MENU
    ========================================================== --}}
    <div
        id="mobile-navigation"
        x-show="open"
        x-transition
        x-cloak
        class="lg:hidden fixed inset-0 z-50">

        {{-- Overlay --}}
        <div
            @click="open = false"
            class="absolute inset-0 bg-black/30"
            aria-hidden="true">
        </div>


        {{-- Drawer --}}
        <aside
            class="absolute left-0 top-0 bottom-0
                   w-72 max-w-[85%]
                   bg-white shadow-xl
                   flex flex-col">

            {{-- Mobile Logo --}}
            <div
                class="h-20 px-5 flex items-center
                       border-b border-gray-200">

                <div class="flex items-center gap-3">

                    <div
                        class="w-10 h-10 rounded-xl
                               bg-green-600
                               flex items-center
                               justify-center
                               text-white text-xl">

                        🏠

                    </div>

                    <div>

                        <div class="font-bold text-gray-800 text-sm">
                            ระบบบริหารจัดการหอพัก
                        </div>

                        <div class="text-xs text-gray-400 mt-0.5">
                            Dormitory Management
                        </div>

                    </div>

                </div>

            </div>


            {{-- Mobile User --}}
            <div
                class="px-5 py-4 border-b border-gray-100">

                <div class="flex items-center gap-3">

                    <div
                        class="w-10 h-10 shrink-0 rounded-full
                               bg-green-100
                               flex items-center
                               justify-center
                               text-green-700 font-bold">

                        {{ mb_substr(Auth::user()->name, 0, 1) }}

                    </div>

                    <div class="min-w-0">

                        <div
                            class="font-semibold text-sm text-gray-800 truncate">

                            {{ Auth::user()->name }}

                        </div>

                        <div class="text-xs text-gray-500">

                            @if (Auth::user()->role === 'admin')
                                ผู้ดูแลระบบ
                            @else
                                ผู้เช่า
                            @endif

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 MOBILE MENU ITEMS
            ================================================== --}}
            <div class="flex-1 overflow-y-auto p-4">

                {{-- Dashboard --}}
                <a
                    href="{{ route('dashboard') }}"
                    @click="open = false"
                    class="flex items-center gap-3
                           px-4 py-3 rounded-xl mb-1
                           text-sm font-medium
                           transition duration-200
                           {{ request()->routeIs('dashboard')
                                ? 'bg-green-50 text-green-700'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                    <span class="text-lg leading-none">📊</span>

                    <span>แดชบอร์ด</span>

                </a>


                {{-- Admin Menu --}}
                @if (Auth::user()->role === 'admin')

                    {{-- Rooms --}}
                    <a
                        href="{{ route('rooms.index') }}"
                        @click="open = false"
                        class="flex items-center gap-3
                               px-4 py-3 rounded-xl mb-1
                               text-sm font-medium
                               transition duration-200
                               {{ request()->routeIs('rooms.*')
                                    ? 'bg-green-50 text-green-700'
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                        <span class="text-lg leading-none">🏠</span>

                        <span>จัดการห้องพัก</span>

                    </a>


                    {{-- Tenants --}}
                    <a
                        href="{{ route('tenants.index') }}"
                        @click="open = false"
                        class="flex items-center gap-3
                               px-4 py-3 rounded-xl mb-1
                               text-sm font-medium
                               transition duration-200
                               {{ request()->routeIs('tenants.*')
                                    ? 'bg-green-50 text-green-700'
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                        <span class="text-lg leading-none">👤</span>

                        <span>จัดการผู้เช่า</span>

                    </a>


                    {{-- Meter Readings --}}
                    <a
                        href="{{ route('meter-readings.index') }}"
                        @click="open = false"
                        class="flex items-center gap-3
                               px-4 py-3 rounded-xl mb-1
                               text-sm font-medium
                               transition duration-200
                               {{ request()->routeIs('meter-readings.*')
                                    ? 'bg-green-50 text-green-700'
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                        <span class="text-lg leading-none">⚡</span>

                        <span>มิเตอร์น้ำ / ไฟ</span>

                    </a>


                    {{-- Bills --}}
                    <a
                        href="{{ route('bills.index') }}"
                        @click="open = false"
                        class="flex items-center gap-3
                               px-4 py-3 rounded-xl mb-1
                               text-sm font-medium
                               transition duration-200
                               {{ request()->routeIs('bills.*')
                                    ? 'bg-green-50 text-green-700'
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                        <span class="text-lg leading-none">🧾</span>

                        <span>ค่าใช้จ่าย</span>

                    </a>


                    {{-- Payments --}}
                    <a
                        href="{{ route('payments.index') }}"
                        @click="open = false"
                        class="flex items-center gap-3
                               px-4 py-3 rounded-xl mb-1
                               text-sm font-medium
                               transition duration-200
                               {{ request()->routeIs('payments.*')
                                    ? 'bg-green-50 text-green-700'
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                        <span class="text-lg leading-none">💳</span>

                        <span>การชำระเงิน</span>

                    </a>

                @endif


                {{-- Tenant Menu --}}
                @if (Auth::user()->role === 'tenant')

                    {{-- Tenant Bills --}}
                    <a
                        href="{{ route('tenant.bills') }}"
                        @click="open = false"
                        class="flex items-center gap-3
                               px-4 py-3 rounded-xl mb-1
                               text-sm font-medium
                               transition duration-200
                               {{ request()->routeIs('tenant.bills*')
                                    ? 'bg-green-50 text-green-700'
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                        <span class="text-lg leading-none">🧾</span>

                        <span>ใบแจ้งค่าใช้จ่าย</span>

                    </a>


                    {{-- Tenant Payments --}}
                    <a
                        href="{{ route('tenant.payments') }}"
                        @click="open = false"
                        class="flex items-center gap-3
                               px-4 py-3 rounded-xl mb-1
                               text-sm font-medium
                               transition duration-200
                               {{ request()->routeIs('tenant.payments')
                                    ? 'bg-green-50 text-green-700'
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                        <span class="text-lg leading-none">💳</span>

                        <span>ประวัติการชำระเงิน</span>

                    </a>

                @endif

            </div>


            {{-- =================================================
                 MOBILE BOTTOM
            ================================================== --}}
            <div
                class="p-4 border-t border-gray-200">

                {{-- Profile --}}
                <a
                    href="{{ route('profile.edit') }}"
                    @click="open = false"
                    class="flex items-center gap-3
                           px-4 py-3 rounded-xl
                           text-sm text-gray-600
                           hover:bg-gray-50
                           hover:text-gray-900
                           transition duration-200">

                    <span class="text-lg leading-none">⚙️</span>

                    <span>ตั้งค่าบัญชี</span>

                </a>


                {{-- Logout --}}
                <form
                    method="POST"
                    action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="w-full flex items-center gap-3
                               px-4 py-3 rounded-xl
                               text-sm text-red-600
                               hover:bg-red-50
                               transition duration-200">

                        <span class="text-lg leading-none">🚪</span>

                        <span>ออกจากระบบ</span>

                    </button>

                </form>

            </div>

        </aside>

    </div>

</nav>