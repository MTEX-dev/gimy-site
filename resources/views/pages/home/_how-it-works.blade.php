<div id="how-it-works" class="py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
            <h2
                class="text-base font-semibold leading-7 text-indigo-400 fade-in-up"
            >
                {{ __('home.how_it_works.section_title') }}
            </h2>
            <p
                class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-4xl fade-in-up"
                style="--delay: 100ms"
            >
                {{ __('home.how_it_works.title') }}
            </p>
        </div>
        <div
            class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 text-center sm:mt-20 lg:max-w-none lg:grid-cols-3"
        >
            <div class="fade-in-up" style="--delay: 200ms">
                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-indigo-500/10 ring-2 ring-indigo-500"
                >
                    <i class="bi bi-person-plus-fill text-2xl text-indigo-400"></i>
                </div>
                <h3 class="mt-6 text-xl font-semibold text-white">
                    {{ __('home.how_it_works.steps.0.title') }}
                </h3>
                <p class="mt-2 text-gray-400">
                    {{ __('home.how_it_works.steps.0.description') }}
                </p>
            </div>
            <div class="fade-in-up" style="--delay: 350ms">
                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-indigo-500/10 ring-2 ring-indigo-500"
                >
                    <i class="bi bi-code-slash text-2xl text-indigo-400"></i>
                </div>
                <h3 class="mt-6 text-xl font-semibold text-white">
                    {{ __('home.how_it_works.steps.1.title') }}
                </h3>
                <p class="mt-2 text-gray-400">
                    {{ __('home.how_it_works.steps.1.description') }}
                </p>
            </div>
            <div class="fade-in-up" style="--delay: 500ms">
                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-indigo-500/10 ring-2 ring-indigo-500"
                >
                    <i class="bi bi-rocket-takeoff-fill text-2xl text-indigo-400"></i>
                </div>
                <h3 class="mt-6 text-xl font-semibold text-white">
                    {{ __('home.how_it_works.steps.2.title') }}
                </h3>
                <p class="mt-2 text-gray-400">
                    {{ __('home.how_it_works.steps.2.description') }}
                </p>
            </div>
        </div>
    </div>
</div>