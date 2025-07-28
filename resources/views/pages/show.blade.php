{{-- resources/views/pages/show.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'View Page: ' . $page->slug)

@section('breadcrumbs')
    <a href="{{ route('sites.index') }}" class="text-gray-400 hover:text-white">My Sites</a>
    <span class="text-gray-500">/</span>
    <a href="{{ route('sites.show', $site) }}" class="text-gray-400 hover:text-white">{{ $site->subdomain }}</a>
    <span class="text-gray-500">/</span>
    <a href="{{ route('sites.pages.index', $site) }}" class="text-gray-400 hover:text-white">Pages</a>
    <span class="text-gray-500">/</span>
    <span class="text-gray-500">{{ $page->slug }}</span>
@endsection

@section('dashboard-content')
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-white">Page: {{ $page->slug }}</h2>
        <p class="text-gray-400">
            Preview and edit the content of this page.
            <a href="{{ $page->url }}" target="_blank" class="text-cyan-400 hover:underline">View live <i class="bi bi-box-arrow-up-right text-base ml-1"></i></a>
        </p>
    </div>

    @if (session('success'))
        <div class="bg-green-600 text-white p-4 rounded-lg mb-6 shadow-md" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-600 text-white p-4 rounded-lg mb-6 shadow-md" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold mb-4 text-white">HTML Content Editor</h3>
            <form method="POST" action="{{ route('sites.pages.update', [$site, $page]) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="editor_html_content" class="sr-only">HTML Content</label>
                    <textarea id="editor_html_content" name="html_content" rows="20" class="block w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 placeholder-gray-400 text-white font-mono text-sm" placeholder="Your HTML goes here...">{{ old('html_content', $page->html_content) }}</textarea>
                    @error('html_content')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4 flex items-center">
                    <input
                        type="checkbox"
                        id="editor_is_homepage"
                        name="is_homepage"
                        value="1"
                        {{ old('is_homepage', $page->is_homepage) ? 'checked' : '' }}
                        class="w-4 h-4 text-cyan-600 bg-gray-700 border-gray-600 rounded focus:ring-cyan-500"
                    />
                    <label for="editor_is_homepage" class="ml-2 text-sm font-medium text-white">Set as Homepage</label>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded-lg">
                        Update Page Content
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold mb-4 text-white">Live Preview</h3>
            <div class="w-full h-[500px] border border-gray-700 rounded-lg overflow-hidden bg-white dark:bg-gray-900">
                <iframe id="page-preview" srcdoc="{{ $page->html_content }}" class="w-full h-full border-0"></iframe>
            </div>
            <p class="text-xs text-gray-500 mt-2">Note: This preview does not load external CSS/JS or local assets. For full preview, click "View live".</p>
        </div>
    </div>
@endsection