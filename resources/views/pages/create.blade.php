{{-- resources/views/pages/create.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Create New Page for ' . $site->subdomain)

@section('breadcrumbs')
    <a href="{{ route('sites.index') }}" class="text-gray-400 hover:text-white">My Sites</a>
    <span class="text-gray-500">/</span>
    <a href="{{ route('sites.show', $site) }}" class="text-gray-400 hover:text-white">{{ $site->subdomain }}</a>
    <span class="text-gray-500">/</span>
    <a href="{{ route('sites.pages.index', $site) }}" class="text-gray-400 hover:text-white">Pages</a>
    <span class="text-gray-500">/</span>
    <span class="text-gray-500">Create</span>
@endsection

@section('dashboard-content')
    <div class="max-w-3xl mx-auto bg-gray-800 rounded-xl shadow-lg p-8">
        <header class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-white">Create New Page for "{{ $site->subdomain }}"</h1>
            <p class="text-gray-400">Define the slug, title, and initial HTML content for your new page.</p>
        </header>

        <form method="POST" action="{{ route('sites.pages.store', $site) }}">
            @csrf
            <div class="mb-6">
                <label for="slug" class="block mb-2 text-sm font-medium text-white">Page Slug <span class="text-gray-500">(e.g., about-us, contact)</span></label>
                <div class="flex items-center bg-gray-700 border border-gray-600 rounded-lg focus-within:ring-2 focus-within:ring-cyan-500 focus-within:border-cyan-500">
                    <span class="text-gray-400 pl-3">/</span>
                    <input
                        type="text"
                        id="slug"
                        name="slug"
                        class="w-full bg-transparent p-2.5 outline-none placeholder-gray-400 text-white"
                        placeholder="your-page-slug"
                        value="{{ old('slug') }}"
                        required
                    />
                </div>
                @error('slug')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="title" class="block mb-2 text-sm font-medium text-white">Page Title <span class="text-gray-500">(For browser tab)</span></label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="block w-full p-2.5 bg-gray-700 border border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 placeholder-gray-400 text-white"
                    placeholder="My Awesome Page"
                    value="{{ old('title') }}"
                />
                @error('title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="html_content" class="block mb-2 text-sm font-medium text-white">HTML Content</label>
                <textarea
                    id="html_content"
                    name="html_content"
                    rows="15"
                    class="block w-full p-2.5 bg-gray-700 border border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 placeholder-gray-400 text-white font-mono"
                    placeholder="<!-- Your HTML content here -->"
                >{{ old('html_content', '<div><h1>Hello, this is a new page!</h1></div>') }}</textarea>
                @error('html_content')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 flex items-center">
                <input
                    type="checkbox"
                    id="is_homepage"
                    name="is_homepage"
                    value="1"
                    {{ old('is_homepage') ? 'checked' : '' }}
                    class="w-4 h-4 text-cyan-600 bg-gray-700 border-gray-600 rounded focus:ring-cyan-500"
                />
                <label for="is_homepage" class="ml-2 text-sm font-medium text-white">Set as Homepage for this Site</label>
                <p class="ml-4 text-xs text-gray-500">Only one page per site can be the homepage (slug: `/`). If checked, other homepages will be unset.</p>
            </div>

            <div class="flex justify-end mt-8">
                <button
                    type="submit"
                    class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2.5 px-6 rounded-lg text-lg transition duration-200"
                >
                    Create Page
                </button>
            </div>
        </form>
    </div>
@endsection