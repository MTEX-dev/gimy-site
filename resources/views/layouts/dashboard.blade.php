@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen bg-gray-900 text-white">
        <aside class="w-64 bg-gray-800 shadow-lg fixed h-screen z-40 md:relative md:h-auto transition-transform duration-300 ease-in-out transform -translate-x-full md:translate-x-0" id="sidenav">
            <div class="p-6 text-2xl font-bold text-center border-b border-gray-700 flex justify-between items-center">
                <span>gimy.site</span>
                <button id="sidenav-close" class="text-white focus:outline-none md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <nav class="mt-5 flex flex-col h-[calc(100%-70px)]">
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

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex items-center justify-between px-6 py-4 bg-gray-800 shadow-md">
                <button id="sidenav-toggle" class="text-white focus:outline-none md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h1 class="text-xl font-semibold text-white md:ml-0 ml-4">Dashboard</h1>
                <button id="dark-mode-toggle-desktop" class="text-white focus:outline-none hidden md:block">
                    <i class="bi bi-sun-fill text-xl dark:hidden"></i>
                    <i class="bi bi-moon-fill text-xl hidden dark:inline"></i>
                </button>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                <nav class="text-sm font-semibold mb-6 flex items-center space-x-2">
                    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white">Dashboard</a>
                    @hasSection('breadcrumbs')
                        <span class="text-gray-500">/</span>
                        @yield('breadcrumbs')
                    @endif
                </nav>

                <h2 class="text-3xl font-bold mb-8 text-white">
                    @yield('title', 'Dashboard')
                </h2>

                @yield('dashboard-content')
            </main>
        </div>
    </div>

    <script>
        const html = document.documentElement;
        const darkModeToggleDesktop = document.getElementById('dark-mode-toggle-desktop');
        const sidenavToggle = document.getElementById('sidenav-toggle');
        const sidenavClose = document.getElementById('sidenav-close');
        const sidenav = document.getElementById('sidenav');

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

        if (darkModeToggleDesktop) {
            darkModeToggleDesktop.addEventListener('click', toggleDarkMode);
        }

        if (sidenavToggle) {
            sidenavToggle.addEventListener('click', function () {
                sidenav.classList.remove('-translate-x-full');
            });
        }

        if (sidenavClose) {
            sidenavClose.addEventListener('click', function () {
                sidenav.classList.add('-translate-x-full');
            });
        }

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                sidenav.classList.remove('-translate-x-full');
            } else {
                sidenav.classList.add('-translate-x-full');
            }
        });
    </script>
@endsection