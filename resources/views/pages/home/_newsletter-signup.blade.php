{{-- resources/views/pages/home/_newsletter-signup.blade.php --}}
<div class="bg-gray-900 py-16 sm:py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="relative isolate overflow-hidden bg-gray-800/40 px-6 py-24 text-center shadow-2xl sm:rounded-3xl sm:px-16 zoom-in">
            <h2 class="mx-auto max-w-2xl text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ __('home.newsletter.title') }}</h2>
            <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-300">{{ __('home.newsletter.subtitle') }}</p>
            
            @if (session('newsletter_success'))
                 <div class="mt-8 mx-auto max-w-xl">
                    <div class="rounded-md bg-green-500/10 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-check-circle-fill text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-300">{{ session('newsletter_success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="mx-auto mt-10 flex max-w-md gap-x-4">
                    @csrf
                    <label for="newsletter-email" class="sr-only">{{ __('home.newsletter.email_label') }}</label>
                    <input id="newsletter-email" name="email" type="email" autocomplete="email" required class="min-w-0 flex-auto rounded-md border-0 bg-white/5 px-3.5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" placeholder="{{ __('home.newsletter.email_placeholder') }}">
                    <button type="submit" class="flex-none rounded-md bg-indigo-500 py-2.5 px-3.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">{{ __('home.newsletter.submit_btn') }}</button>
                </form>
            @endif
        </div>
    </div>
</div>
