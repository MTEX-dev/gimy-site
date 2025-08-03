<div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
    <div>
        <button
            type="button"
            class="inline-flex justify-center w-full rounded-md px-3 py-2 text-sm font-semibold text-gray-300 hover:text-white"
            id="menu-button"
            aria-expanded="true"
            aria-haspopup="true"
            @click="open = !open"
        >
            @php
                $currentLocaleCode = App::getLocale();
                $currentLocaleName = config('locales.supported')[$currentLocaleCode] ?? $currentLocaleCode;
            @endphp
            <img
                src="{{ asset('data/flags/' . $currentLocaleCode . '.png') }}"
                alt="{{ $currentLocaleName }} flag"
                class="w-9 h-7 mr-0 inline-block rounded" 
            />
            {{-- $currentLocaleName --}}
            <svg
                class="-mr-1 h-8 w-8 text-gray-300"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
            >
                <path
                    fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd"
                />
            </svg>
        </button>
    </div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 z-10 mt-2 w-36 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="menu-button"
        tabindex="-1"
    >
        <div class="py-1" role="none">
            @foreach (config('locales.supported') as $localeCode => $localeName)
                <a
                    href="{{ route('locale.switch', $localeCode) }}"
                    class="text-gray-700 block px-4 py-2 text-sm {{ App::getLocale() === $localeCode ? 'bg-gray-100' : '' }} flex items-center"
                    role="menuitem"
                    tabindex="-1"
                    id="menu-item-{{ $localeCode }}"
                    @click="open = false"
                >
                    <img
                        src="{{ asset('data/flags/' . $localeCode . '.png') }}"
                        alt="{{ $localeName }} flag"
                        class="w-7 h-5 mr-2 rounded"
                    />
                    {{ $localeName }}
                </a>
            @endforeach
        </div>
    </div>
</div>