@extends('layouts.main')

@section('main-content')

<style>
    body,
    .overflow-y-auto,
    .overflow-x-auto {
        scrollbar-width: thin;
        scrollbar-color: #6366f1 #1f2937;
        -webkit-overflow-scrolling: touch; 
    }

    ::-webkit-scrollbar,
    .overflow-y-auto::-webkit-scrollbar,
    .overflow-x-auto::-webkit-scrollbar {
        display:block;
        width: 3px;
    }

    ::-webkit-scrollbar-track,
    .overflow-y-auto::-webkit-scrollbar-track,
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #1f2937;
        border-radius: 2px;
        transition-duration: 1s;
    }

    ::-webkit-scrollbar-thumb,
    .overflow-y-auto::-webkit-scrollbar-thumb,
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background-color: #6366f1;
        border-radius: 10px;
        border: 1px solid #1f2937;
        transition-duration: 1s;
    }

    ::-webkit-scrollbar-thumb:hover,
    .overflow-y-auto::-webkit-scrollbar-thumb:hover,
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background-color: #818cf8;
        border: 1px solid #95c3ff;
        transition-duration: 1s;
    }
</style>
    @include('pages.home._hero')
    @include('pages.home._stats')
    @include('pages.home._how-it-works')
    @include('pages.home._who-is-it-for')
    @include('pages.home._live-example')
    @include('pages.home._features-detailed')
    @include('pages.home._syntax-highlight')
    @include('pages.home._features-cta')
    @include('pages.home._tech-stack')
    @include('pages.home._pricing')
    @include('pages.home._comparison-table')
    @include('pages.home._community-showcase')
    @include('pages.home._testimonials')
    @include('pages.home._faq')
    @include('pages.home._feedback-form')
    @include('pages.home._newsletter-signup')
    @include('pages.home._community-cta')
    @include('pages.home._creators')
    @include('pages.home._final-cta')

    <!-- JS for Animations & Scroll-to-Top -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Generic On-scroll Animations ---

            // ***** THE FIX IS ON THIS LINE *****
            const animatedElements = document.querySelectorAll(
                '.fade-in-up, .zoom-in, .pop-in'
            );

            const animationObserver = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                            animationObserver.unobserve(entry.target);
                        }
                    });
                },
                { threshold: 0.1 }
            );
            animatedElements.forEach((el) => animationObserver.observe(el));

            // --- Stats Counter Animation ---
            const statsSection = document.getElementById('stats-section');
            const animateValue = (el, start, end, duration) => {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min(
                        (timestamp - startTimestamp) / duration,
                        1
                    );
                    el.innerHTML = Math.floor(
                        progress * (end - start) + start
                    ).toLocaleString();
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            };

            const statsObserver = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            const counters =
                                statsSection.querySelectorAll('[data-target]');
                            counters.forEach((counter) => {
                                const target = +counter.dataset.target;
                                animateValue(counter, 0, target, 2000);
                            });
                            statsObserver.unobserve(statsSection);
                        }
                    });
                },
                { threshold: 0.5 }
            );

            if (statsSection) {
                statsObserver.observe(statsSection);
            }

            // --- Scroll-to-top button logic ---
            const scrollTopBtn = document.getElementById('scroll-to-top-btn');
            if (scrollTopBtn) {
                window.onscroll = function () {
                    if (
                        document.body.scrollTop > 200 ||
                        document.documentElement.scrollTop > 200
                    ) {
                        scrollTopBtn.classList.remove('hidden');
                    } else {
                        scrollTopBtn.classList.add('hidden');
                    }
                };
                scrollTopBtn.onclick = function () {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                };
            }
        });
    </script>
@endsection