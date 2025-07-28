{{-- resources/views/sites/edit.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Edit Site: ' . $site->subdomain)

@section('breadcrumbs')
    <a href="{{ route('sites.index') }}" class="text-gray-400 hover:text-white">My Sites</a>
    <span class="text-gray-500">/</span>
    <a href="{{ route('sites.show', $site) }}" class="text-gray-400 hover:text-white">{{ $site->subdomain }}</a>
    <span class="text-gray-500">/</span>
    <span class="text-gray-500">Edit</span>
@endsection

@section('dashboard-content')
    <div class="max-w-2xl mx-auto bg-gray-800 rounded-xl shadow-lg p-8">
        <header class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-white">Edit Site: {{ $site->subdomain }}</h1>
            <p class="text-gray-400">Update the subdomain for your project.</p>
        </header>

        <form method="POST" action="{{ route('sites.update', $site) }}">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="subdomain" class="block mb-2 text-sm font-medium text-white">
                    Site Address
                </label>
                <div class="flex items-center bg-gray-700 border border-gray-600 rounded-lg focus-within:ring-2 focus-within:ring-cyan-500 focus-within:border-cyan-500">
                    <input
                        type="text"
                        id="subdomain"
                        name="subdomain"
                        class="w-full bg-transparent p-2.5 outline-none placeholder-gray-400 text-white"
                        placeholder="my-awesome-project"
                        value="{{ old('subdomain', $site->subdomain) }}"
                        required
                        autofocus
                    />
                    <span class="text-gray-400 pr-3 text-lg">.gimy.site</span>
                </div>
                @error('subdomain')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end mt-8">
                <button
                    type="submit"
                    class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2.5 px-6 rounded-lg text-lg transition duration-200"
                >
                    Update Site
                </button>
            </div>
        </form>
    </div>
@endsection