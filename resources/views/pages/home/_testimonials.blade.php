<div class="py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-xl text-center">
            <h2
                class="text-lg font-semibold leading-8 tracking-tight text-indigo-400 fade-in-up"
            >
                {{ __('home.testimonials.section_title') }}
            </h2>
            <p
                class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-4xl fade-in-up"
                style="--delay: 100ms"
            >
                {{ __('home.testimonials.title') }}
            </p>
        </div>
        <div
            class="mx-auto mt-16 flow-root max-w-2xl sm:mt-20 lg:mx-0 lg:max-w-none"
        >
            <div
                class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:gap-6"
            >
                @foreach (__('home.testimonials.quotes') as $testimonial)
                    <div
                        class="flex flex-col justify-between rounded-lg bg-gray-800/40 p-8 shadow-sm zoom-in"
                        style="--delay: {{ $loop->index * 150 + 200 }}ms"
                    >
                        <blockquote class="text-gray-300">
                            <p>
                                “{{ $testimonial['quote'] }}”
                            </p>
                        </blockquote>
                        <figcaption class="mt-6 flex items-center gap-x-4">
                            <div
                                class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center"
                            >
                                <i class="bi bi-person-fill text-xl"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-white">
                                    {{ $testimonial['author'] }}
                                </div>
                                <div class="text-gray-400">
                                    {{ $testimonial['title'] }}
                                </div>
                            </div>
                        </figcaption>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
