<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        
        @vite(['resources/css/app.css', 'resources/css/premium.css', 'resources/js/app.js'])
        @stack('styles')
        <style>
            * { font-family: 'Poppins', sans-serif !important; }
            [x-cloak] { display: none !important; }
            
            /* Premium Toastr Styling */
            #toast-container > .toast {
                border-radius: 16px !important;
                box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.3) !important;
                opacity: 1 !important;
                font-weight: 700 !important;
                padding: 18px 20px 18px 50px !important;
                background-image: none !important;
            }
            .toast-success { background-color: #10b981 !important; border-left: 6px solid #059669 !important; }
            .toast-error { background-color: #f43f5e !important; border-left: 6px solid #e11d48 !important; }
            .toast-warning { background-color: #f59e0b !important; border-left: 6px solid #d97706 !important; }
            .toast-info { background-color: #3b82f6 !important; border-left: 6px solid #2563eb !important; }
        </style>
    </head>
    <body class="antialiased text-slate-800">
        <div class="min-h-screen relative overflow-hidden">
             <!-- Background Glows -->
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-indigo-50/50 blur-[120px] rounded-full pointer-events-none z-0"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[50%] bg-purple-50/50 blur-[120px] rounded-full pointer-events-none z-0"></div>

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="border-b border-slate-100/50 bg-gradient-to-b from-white/80 to-transparent backdrop-blur-sm relative z-10">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="relative z-10">
                {{ $slot }}
            </main>
        </div>

    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "6000",
                "showMethod": "slideDown",
                "hideMethod": "slideUp"
            };

            @if(session('success') || session('message') && session('alert-type') === 'success')
                toastr.success("{{ session('success') ?: session('message') }}");
            @endif

            @if(session('error') || session('message') && session('alert-type') === 'error')
                toastr.error("{{ session('error') ?: session('message') }}");
            @endif

            @if(session('warning') || session('message') && session('alert-type') === 'warning')
                toastr.warning("{{ session('warning') ?: session('message') }}");
            @endif

            @if(session('info') || session('status') || session('message') && session('alert-type') === 'info')
                toastr.info("{{ session('info') ?: session('status') ?: session('message') }}");
            @endif

            @if($errors->any())
                @foreach($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>
