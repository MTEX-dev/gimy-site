<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ __('errors.' . $error . '.title') }} - gimy.site</title>
        <link
            href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
            rel="stylesheet"
        />
        <style>
            .fade-in-up {
                animation: fade-in-up 0.5s ease-out forwards;
                opacity: 0;
                transform: translateY(20px);
            }

            @keyframes fade-in-up {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .hero-glow {
                animation: rotate 10s linear infinite;
            }

            @keyframes rotate {
                from {
                    transform: rotate(0deg);
                }
                to {
                    transform: rotate(360deg);
                }
            }
        </style>
    </head>
    <body class="bg-gray-900 text-white">
        <header
            class="absolute inset-x-0 top-0 z-50 h-16 bg-gray-400 bg-opacity-20 backdrop-blur-sm backdrop-filter"
        >
            <nav
                class="flex h-full items-center justify-between px-4 lg:px-8"
                aria-label="Global"
            >
                <div class="flex lg:flex-1">
                    <a
                        href="{{ route('home') }}"
                        class="-m-1.5 p-1.5 text-xl font-bold text-white"
                        >gimy.site</a
                    >
                </div>
            </nav>
        </header>

        <div
            class="relative isolate overflow-hidden min-h-screen flex items-center justify-center p-4 pt-16"
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

            <!-- Content Split -->
            <div
                class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-7xl mx-auto py-12 lg:py-24 items-center"
            >
                <!-- Left Side: Error Details -->
                <div class="text-center lg:text-left fade-in-up">
                    <h1
                        class="text-7xl sm:text-8xl font-bold text-red-600 tracking-tight"
                    >
                        {{ $error }}
                    </h1>
                    <h2
                        class="mt-6 text-4xl sm:text-5xl font-semibold text-gray-100"
                    >
                        {{ __('errors.' . $error . '.title') }}
                    </h2>
                    <p class="mt-4 text-xl sm:text-2xl text-gray-300 max-w-xl">
                        {{ __('errors.' . $error . '.description') }}
                    </p>
                </div>

                <!-- Right Side: Call to Actions -->
                <div
                    class="text-center lg:text-left sm:px-6 lg:px-0 fade-in-up"
                    style="--delay: 200ms"
                >
                    <div
                        class="relative isolate overflow-hidden bg-indigo-500 px-6 py-12 shadow-2xl sm:rounded-3xl sm:px-16 lg:flex lg:gap-x-20 lg:px-24"
                    >
                        <div
                            class="mx-auto max-w-md text-center lg:mx-0 lg:flex-auto lg:text-left"
                        >
                            <h2
                                class="text-3xl font-bold tracking-tight text-white sm:text-4xl"
                            >
                                What would you like to do?
                            </h2>
                            <p class="mt-6 text-lg leading-8 text-indigo-100">
                                Choose an option below to navigate or seek
                                assistance.
                            </p>
                            <div
                                class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-x-6 gap-y-4 lg:justify-start"
                            >
                                <a
                                    href="{{ route('home') }}"
                                    class="rounded-md bg-white px-6 py-3 text-sm font-semibold text-indigo-600 shadow-sm transition-transform duration-200 hover:scale-105 hover:bg-indigo-50"
                                >
                                    Go Home
                                </a>
                                <a
                                    href="{{ url()->previous() }}"
                                    class="rounded-md bg-indigo-700 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-transform duration-200 hover:scale-105 hover:bg-indigo-600"
                                >
                                    Go Back
                                </a>
                                <a
                                    href="mailto:f.ternis@xpsystems.eu"
                                    class="text-sm font-semibold text-gray-200 hover:text-white"
                                >
                                    Contact Support <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>