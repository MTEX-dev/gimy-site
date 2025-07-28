@extends('layouts.app') @section('title', 'Create New Page') @section('content')
  <div class="container mx-auto px-4 py-10">
    <header class="mb-8">
      <h1 class="text-3xl font-bold">Create New Page</h1>
      <p class="text-slate-400">
        For site:
        <span class="font-semibold text-cyan-400">
          {{ $site->subdomain }}.gimy.site
        </span>
      </p>
    </header>

    <div class="max-w-2xl mx-auto bg-slate-800 rounded-xl shadow-lg p-8">
	  <form method="POST" action="{{ route('sites.pages.store', $site) }}">
        @csrf
        <div class="mb-4">
          <label for="slug" class="block mb-2 text-sm font-medium">
            Page Slug
          </label>
          <div
            class="flex items-center bg-slate-700 border border-slate-600 rounded-lg focus-within:ring-2 focus-within:ring-cyan-500 focus-within:border-cyan-500"
          >
            <span class="text-slate-400 pl-3">
              {{ $site->subdomain }}.gimy.site/
            </span>
            <input
              type="text"
              id="slug"
              name="slug"
              class="w-full bg-transparent p-2.5 outline-none"
              placeholder="about-us"
              value="{{ old('slug') }}"
              required
              autofocus
            />
          </div>
          <p class="text-xs text-slate-400 mt-1">
            Use lowercase letters, numbers, and dashes only (e.g.,
            'contact-info').
          </p>
          @error('slug')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-6">
          <div class="flex items-center">
            <input
              id="is_homepage"
              name="is_homepage"
              type="checkbox"
              value="1"
              class="w-4 h-4 rounded bg-slate-700 border-slate-600 focus:ring-cyan-600"
            />
            <label for="is_homepage" class="ml-2 text-sm font-medium">
              Make this the homepage for the site
            </label>
          </div>
        </div>

        <div class="flex justify-end space-x-4">
          <a
            href="{{ route('sites.edit', $site) }}"
            class="bg-slate-600 hover:bg-slate-500 text-white font-bold py-2 px-5 rounded-lg"
          >
            Cancel
          </a>
          <button
            type="submit"
            class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-5 rounded-lg"
          >
            Create and Edit Page
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection