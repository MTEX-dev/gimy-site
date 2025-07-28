@extends('layouts.app') @section('title', __('strings.dashboard_title'))
@section('content')
  <div class="container mx-auto px-4 py-10">
    <header class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold">
          {{ __('strings.dashboard_welcome', ['name' => Auth::user()->name]) }}
        </h1>
      </div>
      <div>
        <a
          href="{{ route('sites.create') }}"
          class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center"
        >
          <i class="bi bi-plus-lg mr-2"></i>
          <span>Create New Site</span>
        </a>
      </div>
    </header>

    @if (session('status') === 'site-created')
      <div class="bg-green-500/20 text-green-300 p-4 rounded-lg mb-6 text-sm">
        Site created successfully! You can start editing it now.
      </div>
    @endif

    <div class="bg-slate-800 rounded-xl shadow-lg p-8">
      @if ($sites->isEmpty())
        <div class="text-center py-12">
          <i class="bi bi-file-earmark-plus text-5xl text-slate-500 mb-4"></i>
          <h3 class="text-xl font-semibold mb-2">
            {{ __('strings.dashboard_no_sites') }}
          </h3>
          <p class="text-slate-400">
            Click the "Create New Site" button to get started.
          </p>
        </div>
      @else
        <div class="space-y-4">
          @foreach ($sites as $site)
            <div
              class="flex justify-between items-center bg-slate-700/50 p-4 rounded-lg"
            >
              <div>
                <a
                  href="#"
                  class="font-bold text-lg text-cyan-400 hover:underline"
                >
                  {{ $site->subdomain }}.gimy.site
                </a>
                <p class="text-sm text-slate-400">
                  Created: {{ $site->created_at->format('M d, Y') }}
                </p>
              </div>
              <div>
				<a href="{{ route('sites.edit', $site) }}" class="bg-slate-600 hover:bg-slate-500 text-white font-bold py-2 px-4 rounded-lg">Edit Site</a>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
@endsection