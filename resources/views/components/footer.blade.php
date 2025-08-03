<footer class="bg-gray-00 border-t border-gray-800 py-5">
    <div class="mx-auto max-w-7xl overflow-hidden">
        {{-- Copyright Line --}}
        <p class="text-center text-sm leading-6 text-gray-400">
            &copy; {{ date('Y') }} <span class="text-indigo-400 font-bold">gimy.site</span>. A developer-first project by
            <a
                href="https://mtex.dev"
                target="_blank"
                rel="noopener noreferrer"
                class="font-semibold text-indigo-400 hover:text-indigo-300"
                >mtex.dev</a
            >. All rights reserved.
        </p>

        <div class="mt-8 flex items-center justify-between flex-wrap gap-4 px-4 sm:px-0">
            <div class="flex-grow flex justify-center sm:justify-start">
                <a href="https://github.com/mtex-dev" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-gray-300 transition-colors duration-200">
                    <span class="sr-only">GitHub</span>
                    <i class="bi bi-github text-2xl h-6 w-6"></i>
                </a>
            </div>

            <div class="flex-grow flex justify-center sm:justify-end space-x-6 text-sm">
                <a
                    href="{{ route('legal', ['section' => 'imprint']) }}"
                    class="font-semibold text-gray-400 hover:text-white transition-colors duration-200"
                    >{{ __('legal.imprint.title') }}</a
                >
                <a
                    href="{{ route('legal', ['section' => 'privacy']) }}"
                    class="font-semibold text-gray-400 hover:text-white transition-colors duration-200"
                    >{{ __('legal.privacy.title') }}</a
                >
                <a
                    href="{{ route('legal', ['section' => 'terms']) }}"
                    class="font-semibold text-gray-400 hover:text-white transition-colors duration-200"
                    >{{ __('legal.terms.title') }}</a
                >
            </div>
        </div>
    </div>
</footer>