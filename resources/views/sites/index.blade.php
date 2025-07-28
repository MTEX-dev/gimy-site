{{-- resources/views/sites/index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'My Sites')

@section('breadcrumbs')
    <span class="text-gray-500">My Sites</span>
@endsection

@section('dashboard-content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">My Sites</h2>
        @can('create', App\Models\Site::class)
            <a href="{{ route('sites.create') }}" class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <i class="bi bi-plus-circle mr-2"></i> Create New Site
            </a>
        @else
            <p class="text-red-400">You have reached the limit of 25 sites.</p>
        @endcan
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

    @if ($sites->isEmpty())
        <div class="bg-gray-800 p-8 rounded-lg text-center shadow-lg">
            <p class="text-xl text-gray-400 mb-4">You don't have any sites yet.</p>
            @can('create', App\Models\Site::class)
                <a href="{{ route('sites.create') }}" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 px-6 rounded-lg text-lg">
                    Get Started - Create Your First Site!
                </a>
            @endcan
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($sites as $site)
                <div class="bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-cyan-400 mb-2">
                            {{ $site->subdomain }}<span class="text-gray-400">.gimy.site</span>
                        </h3>
                        <p class="text-gray-400 text-sm mb-4">Created: {{ $site->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="flex flex-wrap gap-3 mt-4">
                        <a href="{{ route('sites.show', $site) }}" class="flex-1 min-w-[100px] text-center bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg text-sm">
                            <i class="bi bi-eye mr-1"></i> View & Manage
                        </a>
                        <a href="{{ $site->baseUrl }}" target="_blank" class="flex-1 min-w-[100px] text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm">
                            <i class="bi bi-box-arrow-up-right mr-1"></i> Open Site
                        </a>
                        <a href="{{ route('sites.edit', $site) }}" class="flex-1 min-w-[100px] text-center bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg text-sm">
                            <i class="bi bi-pencil mr-1"></i> Edit
                        </a>
                        <form action="{{ route('sites.destroy', $site) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this site and all its content? This action cannot be undone.');" class="flex-1 min-w-[100px]">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg text-sm">
                                <i class="bi bi-trash mr-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection