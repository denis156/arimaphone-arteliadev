<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Page Title' }}</title>
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-base-100 w-full min-h-dvh overflow-x-hidden">
    {{-- Navbar --}}
    <livewire:landing-page.component.navbar />

    {{-- Content --}}
    <main class="relative">
        {{ $slot }}
    </main>

    {{-- Footer --}}

    <livewire:landing-page.component.footer />
    {{-- Toast --}}
    <x-toast position="toast-top toast-end" />
</body>
@livewireScripts
</html>
