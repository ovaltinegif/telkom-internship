<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
        <!-- Flatpickr CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        <!-- Trix Editor CSS -->
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts -->
        {{ Vite::useScriptTagAttributes(['data-turbo-track' => 'reload']) }}
        {{ Vite::useStyleTagAttributes(['data-turbo-track' => 'reload']) }}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            // Anti-flash script
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
        <style>
            body { font-family: 'Inter', sans-serif; }
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body 
        x-data="{ 
            darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
            toggleTheme() {
                this.darkMode = !this.darkMode;
                localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        }"
        class="font-sans antialiased text-slate-800 dark:text-slate-200 bg-slate-50 dark:bg-slate-950 transition-colors duration-300"
    >
        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'mentor']))
            {{-- Unified Layout: Sidebar + Topbar --}}
            <div class="flex h-screen overflow-hidden text-slate-800 dark:text-slate-200 antialiased bg-[#f8fafc] dark:bg-slate-950">
                @if(auth()->user()->role === 'admin')
                    @include('layouts.admin-sidebar')
                @else
                    @include('layouts.mentor-sidebar')
                @endif
                
                <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
                    @if(auth()->user()->role === 'admin')
                        @include('layouts.admin-topbar')
                    @else
                        @include('layouts.mentor-topbar')
                    @endif
                    
                    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f8fafc] dark:bg-slate-950 transition-colors duration-300 flex flex-col justify-between">
                        <div>
                            {{ $slot }}
                        </div>
                        <div class="mt-auto block w-full">
                            @include('partials.footer')
                        </div>
                    </main>
                </div>
            </div>
        @else
            {{-- Standard Layout: Navigation only --}}
            <div class="w-full block min-h-screen bg-slate-50 dark:bg-slate-950">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white dark:bg-slate-900 shadow-sm border-b border-gray-100 dark:border-slate-800 transition-colors duration-300 w-full block">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 w-full block">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="w-full block">
                    {{ $slot }}
                </main>
            </div>
            @include('partials.footer')
        @endif
        
        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

        <!-- Trix Editor JS -->
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

        @stack('scripts')
    </body>
</html>
