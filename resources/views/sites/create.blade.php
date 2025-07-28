@extends('layouts.app') @section('title', 'Create New Site') @section('content')
  <div class="container mx-auto px-4 py-10">
    <header class="mb-8">
      <h1 class="text-3xl font-bold">Create a New Site</h1>
      <p class="text-slate-400">
        Choose a subdomain for your new project.
      </p>
    </header>

    <div class="max-w-2xl mx-auto bg-slate-800 rounded-xl shadow-lg p-8">
      <form method="POST" action="{{ route('sites.store') }}">
        @csrf
        <div>
          <label for="subdomain" class="block mb-2 text-sm font-medium">
            Site Address
          </label>
          <div
            class="flex items-center bg-slate-700 border border-slate-600 rounded-lg focus-within:ring-2 focus-within:ring-cyan-500 focus-within:border-cyan-500"
          >
            <input
              type="text"
              id="subdomain"
              name="subdomain"
              class="w-full bg-transparent p-2.5 outline-none"
              placeholder="my-awesome-project"
              value="{{ old('subdomain') }}"
              required
              autofocus
            />
            <span class="text-slate-400 pr-3">.gimy.site</span>
          </div>
          @error('subdomain')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex justify-end mt-6">
          <button
            type="submit"
            class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-5 rounded-lg"
          >
            Create Site
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection