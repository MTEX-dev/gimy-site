<div class="py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="text-center mx-auto max-w-2xl lg:max-w-4xl zoom-in">
            <h2 class="text-base font-semibold leading-7 text-indigo-400">{{ __('home.features_detailed.section_title') }}</h2>
            <p class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                {{ __('home.features_detailed.title') }}
            </p>
            <p class="mt-6 text-lg leading-8 text-gray-300">
                {{ __('home.features_detailed.subtitle') }}
            </p>
        </div>
        <div class="mt-16 grid grid-cols-1 gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3 lg:gap-y-16">
            @foreach (__('home.features_detailed.features') as $feature)
                <div class="flex flex-col items-center text-center p-6 rounded-lg bg-gray-800/40 fade-in-up" style="--delay: {{ $loop->index * 100 }}ms">
                    <div class="flex-shrink-0">
                        <i class="bi bi-folder-symlink text-4xl text-indigo-400"></i>
                    </div>
                    <h3 class="mt-4 text-xl font-semibold text-white">{{ $feature['title'] }}</h3>
                    <p class="mt-2 text-base text-gray-400">
                        {{ $feature['description'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</div>