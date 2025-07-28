@extends('layouts.app') @section('title', 'Edit Page') @section('content')
  <div
    class="container mx-auto px-4 py-10"
    x-data="{ tab: 'html' }"
    x-cloak
  >
    <form method="POST" action="{{ route('pages.update', $page) }}">
      @csrf @method('PATCH')
      <header class="flex justify-between items-center mb-6">
        <div>
          <h1 class="text-3xl font-bold">
            Editing Page:
            <span class="text-cyan-400">/{{ $page->slug }}</span>
          </h1>
          <a
            href="{{ route('sites.show', ['subdomain' => $page->site->subdomain, 'slug' => $page->slug]) }}"
            target="_blank"
            class="text-sm text-slate-400 hover:text-cyan-400"
          >
            View Live Page <i class="bi bi-box-arrow-up-right ml-1"></i>
          </a>
        </div>
        <div>
          <a
            href="{{ route('sites.edit', $page->site) }}"
            class="text-slate-300 hover:text-white mr-4"
          >
            &larr; Back to Pages
          </a>
          <button
            type="submit"
            class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-5 rounded-lg"
          >
            Save Changes
          </button>
        </div>
      </header>

      @if (session('status') === 'page-updated')
        <div class="bg-green-500/20 text-green-300 p-3 rounded-lg mb-4 text-sm">
          Page updated successfully.
        </div>
      @endif

      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <div class="lg:col-span-3 bg-slate-800 rounded-xl shadow-lg">
          <div class="border-b border-slate-700 px-4">
            <nav class="-mb-px flex space-x-4" aria-label="Tabs">
              <button
                @click.prevent="tab = 'html'"
                :class="tab === 'html' ? 'border-cyan-400 text-cyan-400' : 'border-transparent text-slate-400 hover:text-white'"
                class="whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm"
              >
                HTML
              </button>
              <!-- ... (CSS and JS tabs are the same) ... -->
            </nav>
          </div>
          <div class="p-1">
            <div x-show="tab === 'html'">
              <textarea
                name="html"
                class="w-full h-[60vh] bg-slate-900 text-slate-300 font-mono text-sm p-4 border-0 focus:ring-0"
                placeholder="<!-- Your HTML code here -->"
              >{{ old('html', $page->html) }}</textarea>
            </div>
            <!-- ... (CSS and JS textareas are the same, using $page->css and $page->js) ... -->
          </div>
        </div>

        <div class="space-y-8">
          <div class="bg-slate-800 rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold mb-4">Page Settings</h3>
            <div class="mb-4">
              <label for="slug" class="block mb-2 text-sm font-medium">
                Slug
              </label>
              <input
                type="text"
                id="slug"
                name="slug"
                class="w-full bg-slate-700 border border-slate-600 rounded-lg p-2.5"
                value="{{ old('slug', $page->slug) }}"
                required
              />
            </div>
            <div class="flex items-center">
              <input
                id="is_homepage"
                name="is_homepage"
                type="checkbox"
                value="1"
                @if (old('is_homepage', $page->is_homepage)) checked @endif
                class="w-4 h-4 rounded bg-slate-700 border-slate-600"
              />
              <label for="is_homepage" class="ml-2 text-sm font-medium">
                Set as Homepage
              </label>
            </div>
          </div>
        </div>
      </div>
    </form>
    <script src="//unpkg.com/alpinejs" defer></script>
  </div>
@endsection