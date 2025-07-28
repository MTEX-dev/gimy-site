<nav>
    <ul class="space-y-2">
        <li>
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 @if (request()->routeIs('dashboard')) bg-gray-100 dark:bg-gray-700 @endif"
            >
                <i class="bi bi-speedometer2 w-5 h-5 mr-3"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a
                href="{{ route('sites.create') }}"
                class="flex items-center p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 @if (request()->routeIs('sites.create')) bg-gray-100 dark:bg-gray-700 @endif"
            >
                <i class="bi bi-plus-circle w-5 h-5 mr-3"></i>
                Create Site
            </a>
        </li>
        <li>
            <h3 class="text-xs uppercase text-gray-500 mt-4 mb-2">My Sites</h3>
            <ul class="space-y-1">
                @foreach (Auth::user()->sites as $site)
                    <li>
                        <a
                            href="{{ route('sites.edit', $site) }}"
                            class="flex items-center p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 @if (isset($currentSite) && $currentSite->id === $site->id) bg-gray-100 dark:bg-gray-700 @endif"
                        >
                            <i class="bi bi-globe w-5 h-5 mr-3"></i>
                            {{ $site->subdomain }}.gimy.site
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li>
            <a
                href="{{ route('user.settings.show') }}"
                class="flex items-center p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 @if (request()->routeIs('user.settings.*')) bg-gray-100 dark:bg-gray-700 @endif"
            >
                <i class="bi bi-gear w-5 h-5 mr-3"></i>
                Settings
            </a>
        </li>
    </ul>
</nav>