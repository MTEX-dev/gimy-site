{{-- resources/views/pages/home/_community-showcase.blade.php --}}
<div class="py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
            <h2 class="text-base font-semibold leading-7 text-indigo-400 fade-in-up">{{ __('home.showcase.section_title') }}</h2>
            <p class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-4xl fade-in-up" style="--delay: 100ms">{{ __('home.showcase.title') }}</p>
            <p class="mt-6 text-lg leading-8 text-gray-300 fade-in-up" style="--delay: 200ms">{{ __('home.showcase.subtitle') }}</p>
        </div>
        <div class="mx-auto mt-16 grid max-w-lg grid-cols-1 gap-8 sm:grid-cols-2 lg:max-w-none lg:grid-cols-3">
            @foreach (__('home.showcase.projects') as $project)
                <div class="flex flex-col overflow-hidden rounded-lg bg-gray-800/40 ring-1 ring-white/10 transition-transform duration-300 hover:-translate-y-2 zoom-in" style="--delay: {{ $loop->index * 150 + 300 }}ms">
                    <div class="flex-shrink-0">
                        {{-- Placeholder for project image --}}
                        <div class="h-48 w-full bg-gray-700 flex items-center justify-center">
                           <i class="bi bi-image text-4xl text-gray-500"></i>
                        </div>
                    </div>
                    <div class="flex flex-1 flex-col justify-between p-6">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-white">{{ $project['title'] }}</h3>
                            <p class="mt-3 text-base text-gray-400">{{ $project['description'] }}</p>
                        </div>
                        <div class="mt-6">
                            <a href="#" class="text-sm font-semibold leading-6 text-indigo-400 hover:text-indigo-300">{{ __('home.showcase.view_project_btn') }} <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
