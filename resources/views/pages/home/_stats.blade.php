<div id="stats-section" class="py-24 sm:py-32 bg-gray-900">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Heading -->
        <div class="mx-auto max-w-3xl text-center mb-16">
            <h2
                class="text-base font-semibold leading-7 text-indigo-400 fade-in-up"
            >
                Stats
            </h2>
            <p
                class="mt-2 text-4xl font-bold tracking-tight text-white sm:text-5xl fade-in-up"
                style="--delay: 100ms"
            >
                Some Statistics
            </p>
        </div>

        <!-- Stats Grid -->
        <div
            class="grid grid-cols-1 gap-8 text-center md:grid-cols-2 lg:grid-cols-3"
        >
            <!-- Users Stat -->
            <div class="zoom-in" style="--delay: 100ms">
                <div
                    class="flex items-center gap-x-6 rounded-xl bg-gray-800/40 p-8 transition-transform duration-300 hover:-translate-y-2"
                >
                    <i class="bi bi-people-fill text-5xl text-indigo-400"></i>
                    <div class="text-left">
                        <dd
                            class="order-first text-4xl font-semibold tracking-tight text-white sm:text-5xl"
                            data-target="{{ $stats['users'] }}"
                        >
                            0
                        </dd>
                        <dt class="mt-1 text-base leading-7 text-gray-400">
                            Developers Joined
                        </dt>
                    </div>
                </div>
            </div>
            <!-- Sites Stat -->
            <div class="zoom-in" style="--delay: 250ms">
                <div
                    class="flex items-center gap-x-6 rounded-xl bg-gray-800/40 p-8 transition-transform duration-300 hover:-translate-y-2"
                >
                    <i class="bi bi-window-stack text-5xl text-indigo-400"></i>
                    <div class="text-left">
                        <dd
                            class="order-first text-4xl font-semibold tracking-tight text-white sm:text-5xl"
                            data-target="{{ $stats['sites'] }}"
                        >
                            0
                        </dd>
                        <dt class="mt-1 text-base leading-7 text-gray-400">
                            Sites Created
                        </dt>
                    </div>
                </div>
            </div>
            <!-- Pages Stat -->
            <div class="zoom-in" style="--delay: 400ms">
                <div
                    class="flex items-center gap-x-6 rounded-xl bg-gray-800/40 p-8 transition-transform duration-300 hover:-translate-y-2"
                >
                    <i class="bi bi-file-earmark-code-fill text-5xl text-indigo-400"></i>
                    <div class="text-left">
                        <dd
                            class="order-first text-4xl font-semibold tracking-tight text-white sm:text-5xl"
                            data-target="{{ $stats['pages'] }}"
                        >
                            0
                        </dd>
                        <dt class="mt-1 text-base leading-7 text-gray-400">
                            Pages Published
                        </dt>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>