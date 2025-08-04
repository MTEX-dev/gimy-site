<div class="py-24 sm:py-32">
    <div class="mx-auto max-w-4xl px-6 lg:px-8">
        <h2 class="text-center text-3xl font-bold tracking-tight text-white sm:text-4xl fade-in-up">
            {{ __('home.faq.title') }}
        </h2>
        <div class="mt-12 space-y-4" id="faq-accordion">
            @foreach (__('home.faq.questions') as $faq)
                <details class="group rounded-lg bg-gray-800/40 p-6 [&_summary::-webkit-details-marker]:hidden fade-in-up" style="--delay: {{ $loop->index * 100 + 200 }}ms">
                    <summary class="flex cursor-pointer items-center justify-between gap-1.5">
                        <h3 class="text-lg font-medium text-white">
                            {{ $faq['q'] }}
                        </h3>
                        <span class="relative h-5 w-5">
                            <i class="bi bi-plus-lg absolute transition-opacity group-open:opacity-0"></i>
                            <i class="bi bi-dash-lg absolute opacity-0 transition-opacity group-open:opacity-100"></i>
                        </span>
                    </summary>
                    <p class="mt-4 leading-relaxed text-gray-400">
                        {{ $faq['a'] }}
                    </p>
                </details>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const accordion = document.getElementById('faq-accordion');
        if (accordion) {
            const details = accordion.querySelectorAll('details');
            details.forEach(detail => {
                detail.addEventListener('toggle', function (event) {
                    if (this.open) {
                        details.forEach(otherDetail => {
                            if (otherDetail !== this) {
                                otherDetail.removeAttribute('open');
                            }
                        });
                    }
                });
            });
        }
    });
</script>
@endpush
