@extends('layouts.dashboard')

@section('title', 'Create New Site')

@section('breadcrumbs')
    <a href="{{ route('sites.index') }}" class="text-gray-400 hover:text-white">My Sites</a>
    <span class="text-gray-500">/</span>
    <span>Create</span>
@endsection

@section('dashboard-content')
<div class="max-w-2xl mx-auto bg-gray-800 rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold text-white mb-6">Create a New Site</h2>
    <form action="{{ route('sites.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-400 text-sm font-bold mb-2">Site Name</label>
            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-400 text-sm font-bold mb-2">Description (Optional)</label>
            <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:shadow-outline" rows="3"></textarea>
        </div>
        <div class="mb-6">
            <label for="domain" class="block text-gray-400 text-sm font-bold mb-2">Custom Domain (Optional)</label>
            <input type="text" name="domain" id="domain" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:shadow-outline" placeholder="e.g., my-awesome-site.com">
        </div>
        <div class="mb-6">
            <label for="github_url" class="block text-gray-400 text-sm font-bold mb-2">GitHub Repository (Optional)</label>
            <input type="text" name="github_url" id="github_url" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:shadow-outline" placeholder="e.g., https://github.com/user/repo">
        </div>
        <div class="flex items-center justify-end">
            <a href="{{ route('sites.index') }}" class="text-gray-400 hover:text-white mr-4">Cancel</a>
            <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                Create Site
            </button>
        </div>
    </form>
</div>
@endsection
