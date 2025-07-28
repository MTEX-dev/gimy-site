@php
    $breadcrumbs = [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        // Add more based on the current route and context
    ];

    // Example: For site edit page
    if (isset($site)) {
        $breadcrumbs[] = ['name' => 'Sites', 'url' => route('dashboard')]; // Or a dedicated sites list page
        $breadcrumbs[] = ['name' => $site->subdomain, 'url' => route('sites.edit', $site)];
        if (isset($page)) {
             $breadcrumbs[] = ['name' => 'Pages', 'url' => route('sites.edit', $site) . '#pages']; // Anchor link
             $breadcrumbs[] = ['name' => $page->title, 'url' => route('pages.edit', $page)];
        }
        if (isset($asset) && !isset($page)) { // If editing an asset directly
             $breadcrumbs[] = ['name' => 'Assets', 'url' => route('sites.edit', $site) . '#assets']; // Anchor link
             $breadcrumbs[] = ['name' => $asset->file_name, 'url' => route('assets.edit', [$site, $asset])];
        }
    }
    // You'd add more logic for asset create, page create, etc.
@endphp

<nav class="mb-4 text-sm text-gray-600 dark:text-gray-400">
    <ol class="list-none p-0 inline-flex">
        @foreach ($breadcrumbs as $index => $breadcrumb)
            <li class="flex items-center">
                @if (isset($breadcrumb['url']) && !$loop->last)
                    <a href="{{ $breadcrumb['url'] }}" class="hover:text-gray-900 dark:hover:text-gray-100">
                        {{ $breadcrumb['name'] }}
                    </a>
                    <svg
                        class="fill-current w-3 h-3 mx-3"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 320 512"
                    >
                        <path
                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 79.243c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"
                        ></path>
                    </svg>
                @else
                    <span>{{ $breadcrumb['name'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>