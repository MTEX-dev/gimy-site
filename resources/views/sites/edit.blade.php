@extends('layouts.app') @section('title', 'Manage Site') @section('content')
  <div class="container mx-auto px-4 py-10">
    <header class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold">
          Manage Site:
          <span class="text-cyan-400">{{ $site->subdomain }}.gimy.site</span>
        </h1>
        <p class="text-slate-400">
          Add, edit, or delete pages for this site.
        </p>
      </div>
      <div>
		<a
		  href="{{ route('sites.pages.create', $site) }}"
		  class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center"
		>
		  <i class="bi bi-plus-lg mr-2"></i>
		  <span>Create New Page</span>
		</a>
      </div>
    </header>

    @if (session('status'))
      <div class="bg-green-500/20 text-green-300 p-3 rounded-lg mb-6 text-sm">
        @if (session('status') === 'page-deleted')
          Page deleted successfully.
        @elseif (session('status') === 'site-updated')
          Site settings updated successfully.
        @endif
      </div>
    @endif

    <!-- Page List -->
    <div class="bg-slate-800 rounded-xl shadow-lg p-8 mb-8">
      <h2 class="text-xl font-bold mb-4">Pages</h2>
      @if ($pages->isEmpty())
        <p class="text-slate-400 text-center py-8">
          This site has no pages yet. Click "Create New Page" to begin.
        </p>
      @else
        <div class="space-y-3">
          @foreach ($pages as $page)
            <div
              class="flex justify-between items-center bg-slate-700/50 p-4 rounded-lg"
            >
              <div class="flex items-center">
                @if ($page->is_homepage)
                  <i
                    class="bi bi-house-fill text-cyan-400 mr-3"
                    title="Homepage"
                  ></i>
                @else
                  <i class="bi bi-file-earmark-text mr-3 text-slate-500"></i>
                @endif
                <a
                  href="{{ route('pages.edit', $page) }}"
                  class="font-semibold text-lg hover:text-cyan-400"
                >
                  /{{ $page->slug }}
                </a>
              </div>
              <div class="flex items-center space-x-4">
                <a
                  href="{{ route('pages.edit', $page) }}"
                  class="bg-slate-600 hover:bg-slate-500 text-white font-bold py-2 px-4 rounded-lg"
                >
                  Edit
                </a>
                <form
                  method="POST"
                  action="{{ route('pages.destroy', $page) }}"
                  onsubmit="return confirm('Are you sure you want to delete this page?');"
                >
                  @csrf @method('DELETE')
                  <button
                    type="submit"
                    class="text-red-400 hover:text-red-300"
                  >
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>

    <!-- Site Settings & Danger Zone -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div class="bg-slate-800 rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-bold mb-4">Site Settings</h3>
        <form method="POST" action="{{ route('sites.update', $site) }}">
          @csrf @method('PATCH')
          <label for="subdomain" class="block mb-2 text-sm font-medium">
            Subdomain
          </label>
          <div
            class="flex items-center bg-slate-700 border border-slate-600 rounded-lg"
          >
            <input
              type="text"
              id="subdomain"
              name="subdomain"
              class="w-full bg-transparent p-2.5 outline-none"
              value="{{ old('subdomain', $site->subdomain) }}"
              required
            />
            <span class="text-slate-400 pr-3">.gimy.site</span>
          </div>
          @error('subdomain')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
          @enderror
          <div class="flex justify-end mt-4">
            <button
              type="submit"
              class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded-lg"
            >
              Save Site Settings
            </button>
          </div>
        </form>
      </div>

      <div
        class="bg-slate-800 border border-red-500/50 rounded-xl shadow-lg p-6"
      >
        <h3 class="text-lg font-bold text-red-400 mb-2">Delete Entire Site</h3>
        <p class="text-slate-400 text-sm mb-4">
          This will permanently delete the site and all its pages.
        </p>
        <form
          method="POST"
          action="{{ route('sites.destroy', $site) }}"
          onsubmit="return confirm('Are you sure you want to permanently delete this entire site?');"
        >
          @csrf @method('DELETE')
          <button
            type="submit"
            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg"
          >
            Delete this Site
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection