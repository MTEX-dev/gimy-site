<header class="absolute inset-x-0 top-0 z-50 h-16 bg-gray-400 bg-opacity-20 backdrop-blur-sm backdrop-filter">
    <nav class="flex h-full items-center justify-between px-4 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="{{ route('home') }}" class="-m-1.5 p-1.5 text-xl font-bold text-white">gimy.site</a>
        </div>
        <div class="flex items-center gap-x-4">
            @auth
                <a href="{{ route('dashboard') }}" class="rounded-md bg-indigo-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-transform duration-150 hover:scale-105 hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-semibold text-gray-300 hover:text-white">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-300 hover:text-white">Log in</a>
                <a href="{{ route('register') }}" class="rounded-md bg-indigo-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-transform duration-150 hover:scale-105 hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Register</a>
            @endauth
        </div>
    </nav>
</header>
