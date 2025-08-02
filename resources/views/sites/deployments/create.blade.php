@extends('layouts.dashboard')

@section('title', 'New Deployment')

@section('breadcrumbs')
    <a href="{{ route('sites.index') }}" class="text-gray-400 hover:text-white">My Sites</a>
    <span class="text-gray-500">/</span>
    <a href="{{ route('sites.show', $site) }}" class="text-gray-400 hover:text-white">{{ $site->name }}</a>
    <span class="text-gray-500">/</span>
    <span>New Deployment</span>
@endsection

@section('dashboard-content')
<div class="max-w-lg mx-auto bg-gray-800 rounded-lg shadow-lg p-8 text-center">
    <i class="bi bi-cloud-arrow-up text-6xl text-cyan-400 mb-4"></i>
    <h2 class="text-2xl font-bold text-white mb-3">Deploy <span class="text-cyan-400">{{ $site->name }}</span></h2>
    <p class="text-gray-400 mb-6">You are about to create a new deployment for this site. This will make the current files live.</p>
    <form action="{{ route('sites.deployments.store', $site) }}" method="POST">
        @csrf
        <div class="flex items-center justify-center">
            <a href="{{ route('sites.show', $site) }}" class="text-gray-400 hover:text-white mr-4">Cancel</a>
            <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                Confirm and Deploy
            </button>
        </div>
    </form>
</div>
@endsection
