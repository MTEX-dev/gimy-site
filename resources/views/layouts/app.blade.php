<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ config('app.name', 'gimy.site') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        />
        <style>
            .fade-in-up {
                opacity: 0;
                transform: translateY(30px);
                transition:
                    opacity 0.6s ease-out,
                    transform 0.6s ease-out;
                transition-delay: var(--delay, 0s);
            }
            .fade-in-up.visible {
                opacity: 1;
                transform: translateY(0);
            }
            .zoom-in {
                opacity: 0;
                transform: scale(0.9);
                transition:
                    opacity 0.6s ease-out,
                    transform 0.6s ease-out;
                transition-delay: var(--delay, 0s);
            }
            .zoom-in.visible {
                opacity: 1;
                transform: scale(1);
            }

            .pop-in {
                opacity: 0;
                transform: scale(0.8) translateY(50px);
                transition:
                    opacity 0.5s cubic-bezier(0.34, 1.56, 0.64, 1),
                    transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
                transition-delay: var(--delay, 0s);
            }
            .pop-in.visible {
                opacity: 1;
                transform: scale(1) translateY(0);
            }

            .hero-glow {
                animation: hero-glow-anim 5s ease-in-out infinite;
            }
            @keyframes hero-glow-anim {
                0%,
                100% {
                    transform: scale(1);
                    opacity: 0.3;
                }
                50% {
                    transform: scale(1.2);
                    opacity: 0.2;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-900 text-gray-200">
        @yield('content')
    </body>
</html>