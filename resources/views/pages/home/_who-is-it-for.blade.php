<div class="py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
            <h2
                class="text-base font-semibold leading-7 text-indigo-400 fade-in-up"
            >
                {{ __('home.who_is_it_for.section_title') }}
            </h2>
            <p
                class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-4xl fade-in-up"
                style="--delay: 100ms"
            >
                {{ __('home.who_is_it_for.title') }}
            </p>
        </div>
        <div
            class="mx-auto mt-16 grid max-w-lg grid-cols-1 gap-8 sm:grid-cols-2 lg:max-w-none lg:grid-cols-4"
        >
            @foreach (__('home.who_is_it_for.cards') as $card)
                <div class="zoom-in" style="--delay: {{ $loop->index * 100 + 200 }}ms">
                    <div
                        class="flex flex-col items-center text-center p-6 bg-gray-800/40 rounded-xl transition-transform duration-300 hover:-translate-y-2 h-full"
                    >
                        <i class="bi bi-braces text-4xl text-indigo-400"></i>
                        <h3 class="mt-4 text-lg font-semibold text-white">
                            {{ $card['title'] }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-400">
                            {{ $card['description'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
