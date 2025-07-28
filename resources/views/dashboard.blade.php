
@extends('layouts.dashboard')

@section('title', 'Your Dashboard')

@section('dashboard-content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-cyan-500 text-white mr-4">
                    <i class="bi bi-browser-chrome text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-400">Total Sites</p>
                    <h3 class="text-3xl font-bold">{{ $sitesCount }} / 25</h3>
                </div>
            </div>
            <a href="{{ route('sites.index') }}" class="mt-4 inline-block text-cyan-400 hover:text-cyan-300">
                View My Sites <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        {{-- Add more dashboard widgets here --}}
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-500 text-white mr-4">
                    <i class="bi bi-file-earmark-code text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-400">Total Pages</p>
                    <h3 class="text-3xl font-bold">...</h3> {{-- You'll need to calculate this --}}
                </div>
            </div>
            <a href="#" class="mt-4 inline-block text-indigo-400 hover:text-indigo-300">
                Manage Pages <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="mt-10">
        <h3 class="text-2xl font-bold mb-5">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('sites.create') }}" class="block p-5 bg-gray-800 rounded-lg shadow-lg hover:bg-gray-700 transition duration-200 text-center">
                <i class="bi bi-plus-circle text-4xl text-green-500 mb-2"></i>
                <p class="text-xl font-semibold">Create New Site</p>
            </a>
            <a href="{{ route('sites.index') }}" class="block p-5 bg-gray-800 rounded-lg shadow-lg hover:bg-gray-700 transition duration-200 text-center">
                <i class="bi bi-list-nested text-4xl text-blue-500 mb-2"></i>
                <p class="text-xl font-semibold">Manage Existing Sites</p>
            </a>
            {{-- More quick actions --}}
        </div>
    </div>
@endsection