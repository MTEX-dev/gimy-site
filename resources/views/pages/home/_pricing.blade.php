<div class="py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Heading -->
        <div class="mx-auto max-w-4xl text-center">
            <h2
                class="text-base font-semibold leading-7 text-indigo-400 fade-in-up"
            >
                {{ __('home.pricing.section_title') }}
            </h2>
            <p
                class="mt-2 text-4xl font-bold tracking-tight text-white sm:text-5xl fade-in-up"
                style="--delay: 100ms"
            >
                {{ __('home.pricing.title') }}
            </p>
        </div>

        <!-- Subheading -->
        <p
            class="mx-auto mt-6 max-w-2xl text-center text-lg leading-8 text-gray-300 fade-in-up"
            style="--delay: 200ms"
        >
            {{ __('home.pricing.subtitle') }}
        </p>

        <!-- Pricing Cards -->
        <div
            class="isolate mx-auto mt-16 grid max-w-md grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-3"
        >
            <!-- Free Plan -->
            <div class="pop-in" style="--delay: 300ms">
                <div
                    class="relative h-full rounded-3xl bg-gray-900 ring-2 ring-indigo-500 transition-transform duration-300 hover:scale-105"
                >
                    <div
                        class="absolute -top-3 left-1/2 -translate-x-1/2 z-10"
                    >
                        <span
                            class="rounded-full bg-indigo-500 px-5 py-1 text-xs font-bold uppercase tracking-wide text-white shadow-md ring-2 ring-white/20"
                        >
                            Best Value
                        </span>
                    </div>
                    <div class="flex h-full flex-col p-8 xl:p-10">
                        <h3 class="text-lg font-semibold leading-8 text-white">
                            {{ __('home.pricing.free_plan.name') }}
                        </h3>
                        <p class="mt-4 text-sm leading-6 text-gray-300">
                            {{ __('home.pricing.free_plan.description') }}
                        </p>
                        <p class="mt-6 flex items-baseline gap-x-1">
                            <span
                                class="text-4xl font-bold tracking-tight text-white"
                                >{{ __('home.pricing.free_plan.price') }}</span
                            >
                            <span class="text-sm font-semibold text-gray-300"
                                >{{ __('home.pricing.free_plan.period') }}</span
                            >
                        </p>
                        <a
                            href="{{ route('register') }}"
                            class="mt-6 block rounded-md bg-indigo-500 px-3 py-2 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        >
                            {{ __('home.pricing.free_plan.cta_btn') }}
                        </a>
                        <ul
                            class="mt-8 flex-1 space-y-3 text-sm leading-6 text-gray-300 xl:mt-10"
                        >
                            @foreach (__('home.pricing.free_plan.features') as $feature)
                                <li class="flex gap-x-3 items-start">
                                    <i
                                        class="bi bi-check-circle-fill h-5 w-5 flex-none text-indigo-400 mt-0.5"
                                    ></i>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <p class="mt-4 text-xs leading-5 text-gray-500 italic">
                            *{{ __('home.pricing.free_plan.disclaimer') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="pop-in" style="--delay: 400ms">
                <div
                    class="h-full rounded-3xl bg-gray-900 ring-1 ring-gray-700 transition-transform duration-300 hover:scale-105"
                >
                    <div class="flex h-full flex-col p-8 xl:p-10">
                        <h3 class="text-lg font-semibold leading-8 text-white">
                            {{ __('home.pricing.premium_plan.name') }}
                        </h3>
                        <p class="mt-4 text-sm leading-6 text-gray-300">
                            {{ __('home.pricing.premium_plan.description') }}
                        </p>
                        <p class="mt-6 flex items-baseline gap-x-1">
                            <span
                                class="text-4xl font-bold tracking-tight text-white"
                                >{{ __('home.pricing.premium_plan.price') }}</span
                            >
                        </p>
                        <button
                            disabled
                            class="mt-6 block w-full cursor-not-allowed rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold leading-6 text-gray-400"
                        >
                            {{ __('home.pricing.premium_plan.cta_btn') }}
                        </button>
                        <ul
                            class="mt-8 flex-1 space-y-3 text-sm leading-6 text-gray-300 xl:mt-10"
                        >
                            @foreach (__('home.pricing.premium_plan.features') as $feature)
                                <li class="flex gap-x-3 items-start">
                                    <i
                                        class="bi bi-check-circle-fill h-5 w-5 flex-none text-indigo-400 mt-0.5"
                                    ></i>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Pro Plan -->
            <div class="pop-in" style="--delay: 500ms">
                <div
                    class="h-full rounded-3xl bg-gray-900 ring-1 ring-gray-700 transition-transform duration-300 hover:scale-105"
                >
                    <div class="flex h-full flex-col p-8 xl:p-10">
                        <h3 class="text-lg font-semibold leading-8 text-white">
                            {{ __('home.pricing.pro_plan.name') }}
                        </h3>
                        <p class="mt-4 text-sm leading-6 text-gray-300">
                            {{ __('home.pricing.pro_plan.description') }}
                        </p>
                        <p class="mt-6 flex items-baseline gap-x-1">
                            <span
                                class="text-4xl font-bold tracking-tight text-white"
                                >{{ __('home.pricing.pro_plan.price') }}</span
                            >
                        </p>
                        <button
                            disabled
                            class="mt-6 block w-full cursor-not-allowed rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold leading-6 text-gray-400"
                        >
                            {{ __('home.pricing.pro_plan.cta_btn') }}
                        </button>
                        <ul
                            class="mt-8 flex-1 space-y-3 text-sm leading-6 text-gray-300 xl:mt-10"
                        >
                            @foreach (__('home.pricing.pro_plan.features') as $feature)
                                <li class="flex gap-x-3 items-start">
                                    <i
                                        class="bi bi-check-circle-fill h-5 w-5 flex-none text-indigo-400 mt-0.5"
                                    ></i>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
