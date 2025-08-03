@extends('layouts.main')

@section('main-content')
    <style>
        .legal-content {
            max-width: 65ch;
            margin-left: auto;
            margin-right: auto;
            color: #d1d5db;
        }

        .legal-content h1,
        .legal-content h2,
        .legal-content h3,
        .legal-content h4,
        .legal-content h5,
        .legal-content h6 {
            color: #f9fafb;
            font-weight: 700;
            margin-top: 1.5em;
            margin-bottom: 0.75em;
            line-height: 1.25;
        }

        .legal-content h1 {
            font-size: 2.25rem;
        }
        .legal-content h2 {
            font-size: 1.875rem;
        }
        .legal-content h3 {
            font-size: 1.5rem;
        }
        .legal-content h4 {
            font-size: 1.25rem;
        }

        .legal-content p {
            margin-bottom: 1em;
            line-height: 1.75;
        }

        .legal-content ul,
        .legal-content ol {
            margin-bottom: 1em;
            padding-left: 1.5em;
        }
        .legal-content ul li {
            list-style-type: disc;
            margin-bottom: 0.5em;
        }
        .legal-content ol li {
            list-style-type: decimal;
            margin-bottom: 0.5em;
        }

        .legal-content hr {
            border-top: 1px solid #686b8a;
            margin: 2em 0;
        }

        .legal-content strong {
            font-weight: 700;
            color: #f9fafb;
        }

        .legal-content em {
            font-style: italic;
        }

        .legal-content a {
            color: #6366f1;
            text-decoration: underline;
        }
        .legal-content a:hover {
            color: #818cf8;
        }

        .legal-content blockquote {
            border-left: 0.25rem solid #6366f1;
            padding-left: 1em;
            margin-left: 0;
            font-style: italic;
            color: #9ca3af;
        }

        .legal-content pre {
            background-color: #1f2937;
            color: #d1d5db;
            padding: 1em;
            border-radius: 0.375rem;
            overflow-x: auto;
            margin-bottom: 1em;
        }

        .legal-content code {
            background-color: #374151;
            color: #e5e7eb;
            padding: 0.2em 0.4em;
            border-radius: 0.25rem;
            font-family: monospace;
            font-size: 0.875em;
        }

        .legal-content-scrollable-area {
            max-height: calc(100vh - 12rem);
            scrollbar-width: thin;
            scrollbar-color: #6366f1 #1f2937;
        }
        
        .legal-content-scrollable-area::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .legal-content-scrollable-area::-webkit-scrollbar-track {
            background: #1f2937;
            border-radius: 10px;
        }

        .legal-content-scrollable-area::-webkit-scrollbar-thumb {
            background-color: #6366f1;
            border-radius: 10px;
            border: 2px solid #1f2937;
        }

        .legal-content-scrollable-area::-webkit-scrollbar-thumb:hover {
            background-color: #818cf8;
        }

        @media (min-width: 768px) {
            .md\:h-full-minus-header {
                min-height: calc(100vh - 4rem - 3rem);
            }
        }
    </style>
    
    <div
        class="flex flex-col md:flex-row gap-8 py-8 px-4 max-w-7xl mx-auto mt-12"
        style="min-height: calc(100vh - 4rem - 3rem);"
    >
        <nav class="flex-none w-full md:w-64">
            <ul class="space-y-2 sticky top-20">
                @foreach($sections as $this_section)
                    <li>
                        <a
                            href="{{ route('legal', ['section' => $this_section]) }}"
                            class="block p-3 rounded-md transition duration-200
                                {{ $this_section === $section ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}"
                        >
                            {{ __('legal.' . $this_section . '.title') }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="flex-grow bg-gray-800 p-6 rounded-lg shadow-lg relative">
            <div class="overflow-y-auto h-full legal-content-scrollable-area">
                <h1 class="text-3xl font-bold text-white mb-4">
                    {{ __('legal.' . $section . '.title') }}
                </h1>
                <div class="legal-content text-gray-300">
                    {!! (new Parsedown())->text(__('legal.' . $section . '.content')) !!}
                </div>
            </div>
        </div>
    </div>
@endsection