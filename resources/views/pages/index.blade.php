{{-- resources/views/pages/index.blade.php (This might be redundant if `sites.show` covers it) --}}
{{-- I'm keeping it for completeness, but the pages tab in sites.show might be enough --}}
@extends('layouts.dashboard')

@section('title', $site->subdomain . ' Pages')

@section('breadcrumbs')
    <a href="{{ route('sites.index') }}" class="text-gray-400 hover:text-white">My Sites</a>
    <span class="text-gray-500">/</span>
    <a href="{{ route('sites.show', $site) }}" class="text-gray-400 hover:text-white">{{ $site->subdomain }}</a>
    <span class="text-gray-500">/</span>
    <span class="text-gray-500">Pages</span>
@endsection

@section('dashboard-content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Pages for {{ $site->subdomain }}</h2>
        <a href="{{ route('sites.pages.create', $site) }}" class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
            <i class="bi bi-plus-circle mr-2"></i> Create New Page
        </a>
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

    @if ($pages->isEmpty())
        <div class="bg-gray-800 p-8 rounded-lg text-center shadow-lg">
            <p class="text-xl text-gray-400 mb-4">No pages created yet for this site.</p>
            <a href="{{ route('sites.pages.create', $site) }}" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 px-6 rounded-lg text-lg">
                Add Your First Page
            </a>
        </div>
    @else
        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-lg">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Slug
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Homepage
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach ($pages as $page)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                {{ $page->slug }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $page->title ?: 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($page->is_homepage)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-700 text-green-100">
                                        Yes
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-700 text-red-100">
                                        No
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('sites.pages.show', [$site, $page]) }}" class="text-indigo-400 hover:text-indigo-300">View Content</a>
                                    <a href="{{ route('sites.pages.edit', [$site, $page]) }}" class="text-yellow-400 hover:text-yellow-300">Edit</a>
                                    <form action="{{ route('sites.pages.destroy', [$site, $page]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this page?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection