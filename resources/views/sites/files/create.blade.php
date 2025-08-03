@extends('layouts.dashboard')

@section('title', 'Add New File')

@section('breadcrumbs')
    <a href="{{ route('sites.index') }}" class="text-gray-400 hover:text-white">My Sites</a>
    <span class="text-gray-500">/</span>
    <a href="{{ route('sites.show', $site) }}" class="text-gray-400 hover:text-white">{{ $site->name }}</a>
    <span class="text-gray-500">/</span>
    <span>Add File</span>
@endsection

@section('dashboard-content')
<div class="max-w-4xl mx-auto bg-gray-800 rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold text-white mb-6">Add a New File to <span class="text-cyan-400">{{ $site->name }}</span></h2>
    
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-white mb-4">Upload a File</h3>
        <form action="{{ route('sites.files.store', $site) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="file" class="block text-gray-400 text-sm font-bold mb-2">Select File</label>
                <input type="file" name="file" id="file" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    <i class="bi bi-cloud-upload mr-2"></i> Upload File
                </button>
            </div>
        </form>
    </div>

    <div class="text-center my-4">
        <span class="text-gray-500">OR</span>
    </div>

    <div>
        <h3 class="text-xl font-semibold text-white mb-4">Create a File Manually</h3>
        <form action="{{ route('sites.files.store', $site) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="path" class="block text-gray-400 text-sm font-bold mb-2">File Path</label>
                <input type="text" name="path" id="path" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:shadow-outline" placeholder="e.g., index.html or css/style.css" required>
            </div>
            <div class="mb-6">
                <label for="content" class="block text-gray-400 text-sm font-bold mb-2">File Content</label>
                <textarea name="content" id="content" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:shadow-outline font-mono" rows="20"></textarea>
            </div>
            <div class="flex items-center justify-end">
                <a href="{{ route('sites.show', $site) }}" class="text-gray-400 hover:text-white mr-4">Cancel</a>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    <i class="bi bi-file-earmark-plus mr-2"></i> Add File
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
