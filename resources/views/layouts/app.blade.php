<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') | {{ config('app.name', 'ระบบบริหารจัดการหอพัก') }}
        @else
            {{ config('app.name', 'ระบบบริหารจัดการหอพัก') }}
        @endif
    </title>

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700"
        rel="stylesheet"
    >

    {{-- Vite --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>


<body class="font-sans antialiased bg-gray-50 text-gray-800">

    <div class="min-h-screen flex flex-col">

        {{-- =====================================================
             Navigation
        ====================================================== --}}
        @include('layouts.navigation')


        {{-- =====================================================
             Desktop Main Area
        ====================================================== --}}
        <div class="flex-1 lg:pl-64">

            {{-- =================================================
                 Desktop Topbar Space
            ================================================== --}}
            <div class="hidden lg:block h-20"></div>


            {{-- =================================================
                 Page Header
            ================================================== --}}
            @isset($header)

                <header class="bg-white border-b border-gray-200">

                    <div class="max-w-7xl mx-auto px-4 py-5 sm:px-6 lg:px-8">

                        {{ $header }}

                    </div>

                </header>

            @endisset


            {{-- =================================================
                 Main Content
            ================================================== --}}
            <main class="flex-1">

                {{ $slot }}

            </main>


            {{-- =================================================
                 Footer
            ================================================== --}}
            <footer class="border-t border-gray-200 bg-white">

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <div class="py-5">

                        <div class="flex flex-col sm:flex-row
                                    items-center justify-between
                                    gap-3 text-sm">

                            <div class="flex items-center gap-2">

                                <span class="flex h-8 w-8 items-center justify-center
                                             rounded-lg bg-green-50 text-green-700">
                                    🏠
                                </span>

                                <span class="font-semibold text-gray-700">
                                    ระบบบริหารจัดการหอพัก
                                </span>

                            </div>


                            <div class="text-gray-500 text-center sm:text-right">

                                ระบบจัดการห้องพัก ผู้เช่า
                                ค่าใช้จ่าย และการชำระเงิน

                            </div>

                        </div>

                    </div>

                </div>

            </footer>

        </div>

    </div>

</body>

</html>