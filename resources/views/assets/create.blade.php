@extends('layouts.main')

@section('title', 'Upload Asset for ' . $site->subdomain)

@section('page-heading', 'Upload Asset for ' . $site->subdomain)

@php
    $currentSite = $site;
@endphp

@section('main-content')
    <div class="max-w-2xl mx-auto p-8 bg-slate-800 rounded-xl shadow-lg">
        <form method="POST" action="{{ route('sites.assets.store', $site) }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="file" class="block mb-2 text-sm font-medium">Choose File</label>
                <input
                    type="file"
                    id="file"
                    name="file"
                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-full file:border-0
                           file:text-sm file:font-semibold
                           file:bg-cyan-50 file:text-cyan-700
                           hover:file:bg-cyan-100 dark:file:bg-cyan-900 dark:file:text-cyan-300 dark:hover:file:bg-cyan-800"
                    required
                />
                @error('file')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="folder" class="block mb-2 text-sm font-medium">Folder (Optional)</label>
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
                        value="{{ old('folder') }}"
                    />
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    e.g., `css`, `js`, `images`. Leave empty for root.
                </p>
                @error('folder')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-5 rounded-lg"
                >
                    Upload Asset
                </button>
            </div>
        </form>
    </div>
@endsection