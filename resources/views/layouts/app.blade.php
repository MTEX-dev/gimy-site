<!doctype html>
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
        <script
            defer
            src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
        ></script>
        {{-- CodeMirror --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/theme/dracula.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/meta.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/edit/matchbrackets.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/edit/closebrackets.min.js"></script>
        {{-- Common CodeMirror Modes --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/xml/xml.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/javascript/javascript.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/css/css.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/htmlmixed/htmlmixed.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/clike/clike.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/php/php.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/markdown/markdown.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/vue/vue.min.js"></script>
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

            ::-webkit-scrollbar {
                display: none;
                width: 0;
                height: 0;
            }

            body {
                scrollbar-width: none;
            }

            body {
                -ms-overflow-style: none;
            }

            body,
            .overflow-y-auto,
            .overflow-x-auto {
                -webkit-overflow-scrolling: touch;
            }
        </style>
        <style>

            body::-webkit-scrollbar,
            .overflow-y-auto::-webkit-scrollbar,
            .overflow-x-auto::-webkit-scrollbar {
                display:block;
                width: 7px;
            }
        
            body::-webkit-scrollbar-track,
            .overflow-y-auto::-webkit-scrollbar-track,
            .overflow-x-auto::-webkit-scrollbar-track {
                background: #1f2937;
                border-radius: 2px;
                transition-duration: 1s;
            }
        
            body::-webkit-scrollbar-thumb,
            .overflow-y-auto::-webkit-scrollbar-thumb,
            .overflow-x-auto::-webkit-scrollbar-thumb {
                background-color: #6366f1;
                border-radius: 10px;
                border: 1px solid #1f2937;
                transition-duration: 1s;
            }
        
            body::-webkit-scrollbar-thumb:hover,
            .overflow-y-auto::-webkit-scrollbar-thumb:hover,
            .overflow-x-auto::-webkit-scrollbar-thumb:hover {
                background-color: #818cf8;
                border: 1px solid #384a63;
                transition-duration: 1s;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-900 text-gray-200">
        @yield('content')
        @stack('scripts')
    </body>
</html>