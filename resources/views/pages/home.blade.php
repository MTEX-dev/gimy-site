@extends('layouts.main')

@section('main-content')
    @include('pages.home._hero')
    @include('pages.home._stats')
    @include('pages.home._how-it-works')
    @include('pages.home._who-is-it-for')
    @include('pages.home._live-example')
    @include('pages.home._features-cta')
    @include('pages.home._tech-stack')
    @include('pages.home._pricing')
    @include('pages.home._testimonials')
    @include('pages.home._faq')
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