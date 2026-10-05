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

    <x-servora.layout.navbar />

    <main>
        {{ $slot }}
    </main>

    <x-servora.layout.footer />

    @livewireScripts
</body>


</html>