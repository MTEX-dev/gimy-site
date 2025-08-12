<div
    class="relative isolate overflow-hidden px-6 pt-14 lg:px-8"
    style="min-height: 100vh;"
>
    <!-- Background Glow -->
    <div
        class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
        aria-hidden="true"
    >
        <div
            class="hero-glow relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
            style="
                clip-path: polygon(
                    74.1% 44.1%,
                    100% 61.6%,
                    97.5% 26.9%,
                    85.5% 0.1%,
                    80.7% 2%,
                    72.5% 32.5%,
                    60.2% 62.4%,
                    52.4% 68.1%,
                    47.5% 58.3%,
                    45.2% 34.5%,
                    27.5% 76.7%,
                    0.1% 64.9%,
                    17.9% 100%,
                    27.6% 76.8%,
                    76.1% 97.7%,
                    74.1% 44.1%
                );
            "
        ></div>
    </div>

    <!-- Content -->
    <div class="mx-auto max-w-3xl py-40 sm:py-56 lg:py-64 text-center">
        <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl fade-in-up">
            {{ __('home.hero.title') }}
        </h1>
        <p
            class="mt-6 text-lg leading-8 text-gray-300 fade-in-up"
            style="--delay: 150ms"
        >
            {{ __('home.hero.subtitle') }}
        </p>
        <div
            class="mt-10 flex items-center justify-center gap-x-6 fade-in-up"
            style="--delay: 300ms"
        >
            <a
                href="{{ route('register') }}"
                class="rounded-md bg-indigo-500 px-5 py-3 text-sm font-semibold text-white shadow-lg transition-transform duration-210 hover:scale-105 hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
            >
                {{ __('home.hero.cta_btn') }}
            </a>
        </div>
    </div>
</div>
