<div class="py-24 sm:py-32">
    <div class="relative isolate overflow-hidden">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div
                class="mx-auto max-w-2xl text-center fade-in-up"
                style="--delay: 100ms"
            >
                <h2
                    class="text-3xl font-bold tracking-tight text-white sm:text-4xl"
                >
                    {{ __('home.final_cta.title') }}
                </h2>
                <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-300">
                    {{ __('home.final_cta.subtitle') }}
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a
                        href="{{ route('register') }}"
                        class="rounded-md bg-indigo-500 px-5 py-3 text-sm font-semibold text-white shadow-lg transition-transform duration-200 hover:scale-105 hover:bg-indigo-400"
                        >{{ __('home.final_cta.cta_btn') }}</a
                    >
                </div>
            </div>
        </div>
    </div>
</div>
