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
    </head>
    <body class="antialiased text-gray-900">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#0f172a] relative overflow-hidden">
            <!-- Animated decorative elements -->
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-600/20 blur-[120px] rounded-full animate-pulse"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-600/20 blur-[120px] rounded-full animate-pulse" style="animation-delay: 1s"></div>

            <div class="animate-fade-up relative z-10">
                <a href="/" class="flex flex-col items-center gap-4 group">
                    <div class="w-16 h-16 bg-[linear-gradient(135deg,#6366f1_0%,#a855f7_100%)] rounded-3xl flex items-center justify-center shadow-2xl shadow-indigo-500/50 group-hover:scale-110 transition-transform duration-500">
                        <x-application-logo class="w-10 h-10 fill-current text-white" />
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-10 px-6 py-8 bg-white/90 backdrop-blur-2xl border border-white/20 shadow-2xl rounded-[2rem] animate-fade-up relative z-10" style="animation-delay: 0.2s">
                {{ $slot }}
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
        </div>
    </body>
</html>
