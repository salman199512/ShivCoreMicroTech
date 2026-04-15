<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/premium.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="antialiased text-slate-800">
        <div class="min-h-screen relative overflow-hidden">
             <!-- Background Glows -->
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-indigo-50/50 blur-[120px] rounded-full pointer-events-none z-0"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[50%] bg-purple-50/50 blur-[120px] rounded-full pointer-events-none z-0"></div>

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-3 relative z-10">
                    {{ $header }}
                </header>
            @endisset

            <!-- Page Content -->
            <main class="relative z-10">
                {{ $slot }}
            </main>
        </div>

        @if(session('success') || session('error') || session('warning') || session('status') || session('info'))
            @php
                $toastMessage = session('success') ?: session('error') ?: session('warning') ?: session('info') ?: session('status');
                $toastType = session('success') ? 'success' : (session('error') ? 'error' : (session('warning') ? 'warning' : (session('info') ? 'info' : 'info')));
            @endphp
            <div x-data="{ show: true, message: @json($toastMessage), type: '{{ $toastType }}' }" x-show="show" x-cloak x-init="setTimeout(() => show = false, 6000)" x-transition.opacity class="premium-toast" :data-type="type">
                <strong class="toast-title" x-text="type.charAt(0).toUpperCase() + type.slice(1)"></strong>
                <div class="toast-body" x-text="message"></div>
                <button type="button" class="toast-close" @click="show = false">×</button>
            </div>
        @endif

        @stack('scripts')
    </body>
</html>
