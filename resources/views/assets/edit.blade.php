@extends('layouts.main')

@section('title', 'Edit Asset: ' . $asset->file_name)

@section('page-heading', 'Edit Asset: ' . $asset->file_name)

@php
    $currentSite = $site;
    $currentAsset = $asset; // For breadcrumbs
@endphp

@section('main-content')
    <div class="max-w-2xl mx-auto p-8 bg-slate-800 rounded-xl shadow-lg">
        <form
            method="POST"
            action="{{ route('sites.assets.update', [$site, $asset]) }}"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="file_name" class="block mb-2 text-sm font-medium">File Name</label>
                <input
                    type="text"
                    id="file_name"
                    name="file_name"
                    class="w-full bg-slate-700 border border-slate-600 rounded-lg p-2.5 focus:ring-cyan-500 focus:border-cyan-500 outline-none"
                    value="{{ old('file_name', $asset->file_name) }}"
                    required
                    autofocus
                />
                @error('file_name')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="folder" class="block mb-2 text-sm font-medium">Folder</label>
                <div class="flex items-center">
                    <span class="text-slate-400 mr-2"
                        >{{ $site->subdomain }}.{{ config('app.url_base_domain') }}/</span
                    >
                    <input
                        type="text"
                        id="folder"
                        name="folder"
                        class="w-full bg-slate-700 border border-slate-600 rounded-lg p-2.5 focus:ring-cyan-500 focus:border-cyan-500 outline-none"
                        placeholder="css"
                        value="{{ old('folder', dirname(ltrim($asset->path, '/')) === '.' ? '' : dirname(ltrim($asset->path, '/'))) }}"
                    />
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    e.g., `css`, `js`, `images`. Leave empty for root.
                </p>
                @error('folder')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="new_file" class="block mb-2 text-sm font-medium"
                    >Replace File (Optional)</label
                >
                <input
                    type="file"
                    id="new_file"
                    name="new_file"
                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-full file:border-0
                           file:text-sm file:font-semibold
                           file:bg-cyan-50 file:text-cyan-700
                           hover:file:bg-cyan-100 dark:file:bg-cyan-900 dark:file:text-cyan-300 dark:hover:file:bg-cyan-800"
                />
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Current file:
                    <a
                        href="{{ $asset->url }}"
                        target="_blank"
                        class="text-cyan-400 hover:underline"
                        >{{ $asset->file_name }}</a
                    >
                    ({{ round($asset->file_size / 1024, 2) }} KB, {{ $asset->mime_type }})
                </p>
                @error('new_file')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-5 rounded-lg"
                >
                    Update Asset
                </button>
            </div>
        </form>
    </div>
@endsection