<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="bg-[#F8FAF6] text-[#26342A] antialiased">

    <div class="min-h-screen" x-data="{
            sidebarOpen: false,
            collapsed: localStorage.getItem('servora-sidebar-collapsed') === 'true',

            toggleCollapse() {
                this.collapsed = !this.collapsed;

                localStorage.setItem(
                    'servora-sidebar-collapsed',
                    this.collapsed
                );
            }
        }">

        {{-- Sidebar --}}
        <x-servora.dashboard.sidebar />

        {{-- Main Content --}}
        <div class="min-h-screen transition-[padding] duration-200 ease-out"
            :class="collapsed ? 'lg:pl-[72px]' : 'lg:pl-64'">

            <main class="p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>

        </div>

    </div>

    @livewireScripts

</body>

</html>