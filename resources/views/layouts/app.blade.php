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
        <link rel="stylesheet" href="{{ asset('style.css') }}">
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        @vite(['resources/css/app.css', 'resources/css/premium.css', 'resources/css/custom-checkbox.css', 'resources/js/app.js'])
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

            /* Table Force Normal Render on Mobile */
            @media (max-width: 768px) {
                .premium-table, table {
                    display: table !important;
                    min-width: 600px !important;
                    width: 100% !important;
                }
                .premium-table thead, table thead {
                    display: table-header-group !important;
                }
                .premium-table tbody, table tbody {
                    display: table-row-group !important;
                }
                .premium-table tr, table tr {
                    display: table-row !important;
                }
                .premium-table th, table th, .premium-table td, table td {
                    display: table-cell !important;
                }
                .overflow-x-auto {
                    overflow-x: auto !important;
                    -webkit-overflow-scrolling: touch !important;
                }
            }

            /* Responsive Header Helper */
            .responsive-header {
                display: flex !important;
                flex-direction: row !important;
                justify-content: space-between !important;
                align-items: center !important;
                gap: 1.5rem !important;
                width: 100% !important;
                text-align: left !important;
            }
            .responsive-header > div {
                text-align: left !important;
            }
            @media (max-width: 768px) {
                .responsive-header {
                    flex-direction: column !important;
                    align-items: flex-start !important;
                    gap: 1rem !important;
                }
            }

            /* Disable desktop scrollbar on overflow-x-auto elements */
            @media (min-width: 769px) {
                .overflow-x-auto {
                    overflow-x: visible !important;
                }
                header > div,
                header .flex,
                .responsive-header {
                    display: flex !important;
                    flex-direction: row !important;
                    justify-content: space-between !important;
                    align-items: center !important;
                    text-align: left !important;
                }
                header h2, header h2 span, header p, .responsive-header div {
                    text-align: left !important;
                }
            }

            /* Prevent button text wrapping globally on all viewports */
            .btn-vibrant, .btn-premium, button, a.inline-flex, a.btn-vibrant, a.btn-premium, .inline-flex {
                white-space: nowrap !important;
                flex-shrink: 0 !important;
            }

            /* Custom Mobile Bottom Navigation Style */
            @media (min-width: 769px) {
                .mobile-bottom-nav {
                    display: none !important;
                }
            }
            @media (max-width: 768px) {
                .mobile-bottom-nav {
                    display: flex !important;
                    position: fixed !important;
                    bottom: 0 !important;
                    left: 0 !important;
                    right: 0 !important;
                    z-index: 100 !important;
                    background: rgba(255, 255, 255, 0.95) !important;
                    backdrop-filter: blur(12px) !important;
                    border-top: 1px solid rgba(226, 232, 240, 0.9) !important;
                    padding: 0.5rem 0 !important;
                    justify-content: space-around !important;
                    align-items: center !important;
                    box-shadow: 0 -8px 25px rgba(0, 0, 0, 0.08) !important;
                    height: 64px !important;
                }
                .mobile-bottom-nav a {
                    flex: 1 !important;
                    display: flex !important;
                    flex-direction: column !important;
                    align-items: center !important;
                    justify-content: center !important;
                    text-align: center !important;
                    color: #64748b !important;
                    text-decoration: none !important;
                    gap: 0.15rem !important;
                    height: 100% !important;
                    padding: 4px 0 !important;
                    min-width: 0 !important;
                }
                .mobile-bottom-nav a:hover, .mobile-bottom-nav a.active {
                    color: #4f46e5 !important;
                }
                .mobile-bottom-nav a span {
                    font-size: 11px !important;
                    font-weight: 800 !important;
                    letter-spacing: 0.05em !important;
                    text-transform: uppercase !important;
                    margin-top: 2px !important;
                    display: block !important;
                }
                .mobile-bottom-nav svg {
                    width: 22px !important;
                    height: 22px !important;
                    display: block !important;
                    margin: 0 auto !important;
                }
            }

            /* Fix Invoice Import section on Desktop */
            .import-flex-row {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: space-between !important;
                width: 100% !important;
                gap: 1.5rem !important;
            }
            .import-flex-row .flex-grow {
                flex-grow: 1 !important;
                width: auto !important;
            }
            .import-flex-row button {
                width: auto !important;
            }
            @media (max-width: 768px) {
                .import-flex-row {
                    flex-direction: column !important;
                    align-items: stretch !important;
                    gap: 1rem !important;
                }
                .import-flex-row button {
                    width: 100% !important;
                }
            }
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
            <main class="relative z-10 pb-20 md:pb-0">
                {{ $slot }}
            </main>

            <!-- Mobile Bottom Fixed Navigation -->
            <div class="mobile-bottom-nav">
                <a href="{{ route('customers.index') }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span>Customer</span>
                </a>

                <a href="{{ route('invoices.index') }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Invoice</span>
                </a>

                <a href="{{ route('payments.index') }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Payment</span>
                </a>

                <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
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
