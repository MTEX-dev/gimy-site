@extends('layouts.dashboard')

@section('title', 'Edit File')

@section('breadcrumbs')
    <a href="{{ route('sites.index') }}" class="text-gray-400 hover:text-white">My Sites</a>
    <span class="text-gray-500">/</span>
    <a href="{{ route('sites.show', $file->site) }}" class="text-gray-400 hover:text-white">{{ $file->site->name }}</a>
    <span class="text-gray-500">/</span>
    <span>Edit: {{ $file->path }}</span>
@endsection

@section('dashboard-content')
<div class="max-w-4xl mx-auto bg-gray-800 rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold text-white mb-6">Editing <span class="text-cyan-400">{{ $file->path }}</span></h2>
    <form action="{{ route('files.update', $file) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-6">
            <label for="content" class="block text-gray-400 text-sm font-bold mb-2">File Content</label>
            <textarea name="content" id="content" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:shadow-outline font-mono" rows="20">{{ $file->content }}</textarea>
        </div>
        <div class="flex items-center justify-end">
            <a href="{{ route('sites.show', $file->site) }}" class="text-gray-400 hover:text-white mr-4">Cancel</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
