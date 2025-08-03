{{-- layouts/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen bg-gray-900 text-white">
        {{-- Sidenav --}}
        <aside class="w-64 bg-gray-800 shadow-lg fixed md:relative h-screen md:h-auto z-40 hidden md:block" id="sidenav">
            <div class="p-6 text-2xl font-bold text-center border-b border-gray-700">
                gimy.site
            </div>
            <nav class="mt-5">
                <a href="{{ route('home') }}" class="flex items-center py-2 px-6 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200">
                    <i class="bi bi-house-fill mr-3"></i> Home
                </a>
                <a href="{{ route('dashboard') }}" class="flex items-center py-2 px-6 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200 {{ request()->routeIs('dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="bi bi-grid-fill mr-3"></i> Dashboard
                </a>
                <a href="{{ route('sites.index') }}" class="flex items-center py-2 px-6 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200 {{ request()->routeIs('sites.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="bi bi-browser-chrome mr-3"></i> My Sites
                </a>
                <a href="{{ route('logs.index') }}" class="flex items-center py-2 px-6 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200 {{ request()->routeIs('logs.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="bi bi-bug-fill mr-3"></i> Logs
                </a>
                <a href="#" class="flex items-center py-2 px-6 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200">
                    <i class="bi bi-gear-fill mr-3"></i> Settings
                </a>
                <form action="{{ route('logout') }}" method="POST" class="mt-auto">
                    @csrf
                    <button type="submit" class="flex items-center w-full text-left py-2 px-6 text-red-400 hover:bg-gray-700 transition duration-200">
                        <i class="bi bi-box-arrow-right mr-3"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Top Bar for Mobile Sidenav Toggle and Dark Mode --}}
            <header class="flex items-center justify-between px-6 py-4 bg-gray-800 shadow-md md:hidden">
                <button id="sidenav-toggle" class="text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h1 class="text-xl font-semibold text-white">Dashboard</h1>
                <button id="dark-mode-toggle-mobile" class="text-white focus:outline-none">
                    <i class="bi bi-sun-fill text-xl dark:hidden"></i>
                    <i class="bi bi-moon-fill text-xl hidden dark:inline"></i>
                </button>
            </header>

            {{-- Main Content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                {{-- Breadcrumbs --}}
                <nav class="text-sm font-semibold mb-6 flex items-center space-x-2">
                    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white">Dashboard</a>
                    @hasSection('breadcrumbs')
                        <span class="text-gray-500">/</span>
                        @yield('breadcrumbs')
                    @endif
                </nav>

                {{-- Page Title --}}
                <h2 class="text-3xl font-bold mb-8 text-white">
                    @yield('title', 'Dashboard')
                </h2>

                @yield('dashboard-content')
            </main>
        </div>
    </div>

    {{-- Dark Mode Script --}}
    <script>
        const html = document.documentElement;
        const darkModeToggleDesktop = document.getElementById('dark-mode-toggle-desktop');
        const darkModeToggleMobile = document.getElementById('dark-mode-toggle-mobile');
        const sidenavToggle = document.getElementById('sidenav-toggle');
        const sidenav = document.getElementById('sidenav');

        // Initial check for dark mode
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        function toggleDarkMode() {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }

        // Check if desktop toggle exists before adding event listener
        if (darkModeToggleDesktop) {
            darkModeToggleDesktop.addEventListener('click', toggleDarkMode);
        }
        if (darkModeToggleMobile) {
            darkModeToggleMobile.addEventListener('click', toggleDarkMode);
        }

        // Sidenav toggle for mobile
        if (sidenavToggle) {
            sidenavToggle.addEventListener('click', function () {
                sidenav.classList.toggle('hidden');
            });
        }

        // Close sidenav on larger screens if open on mobile
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768 && sidenav.classList.contains('hidden')) {
                sidenav.classList.remove('hidden');
            } else if (window.innerWidth < 768 && !sidenav.classList.contains('hidden')) {
                // Optional: keep it open on resize if it was open, or always close it.
                // For simplicity, we'll let it stay open if it was already open.
                // If you want it to close automatically, add: sidenav.classList.add('hidden');
            }
        });
    </script>
@endsection