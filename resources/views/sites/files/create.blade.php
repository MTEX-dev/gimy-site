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
    <h2 class="text-2xl font-bold text-white mb-6">Add New Files to <span class="text-indigo-400">{{ $site->name }}</span></h2>
    
    <div class="mb-8 border-b border-gray-700 pb-8"> {{-- Added border-b for visual separation --}}
        <h3 class="text-xl font-semibold text-white mb-4">Upload Multiple Files</h3>
        <form action="{{ route('sites.files.store', $site) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="files" class="block text-gray-400 text-sm font-bold mb-2">Select Files</label>
                <input
                    type="file"
                    name="files[]" {{-- Changed name to files[] for multiple uploads --}}
                    id="files"
                    multiple {{-- Added multiple attribute --}}
                    class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:shadow-outline file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-500 file:text-white hover:file:bg-indigo-600" {{-- Tailwind file input styling --}}
                >
                @error('files')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
                @error('files.*') {{-- Error for individual files in the array --}}
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-end">
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    <i class="bi bi-cloud-upload mr-2"></i> Upload Files
                </button>
            </div>
        </form>
        <p class="text-gray-500 text-sm mt-4">Max file size: 10MB per file. Only safe file types are allowed.</p>
    </div>

    <div class="text-center my-8"> {{-- Increased margin for OR separator --}}
        <span class="text-gray-500 text-lg font-semibold">OR</span>
    </div>

    <div>
        <h3 class="text-xl font-semibold text-white mb-4">Create a Single File Manually</h3> {{-- Clarified this is for single file --}}
        <form action="{{ route('sites.files.store', $site) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="path" class="block text-gray-400 text-sm font-bold mb-2">File Path</label>
                <input type="text" name="path" id="path" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:shadow-outline" placeholder="e.g., index.html or css/style.css" required>
                @error('path')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="content" class="block text-gray-400 text-sm font-bold mb-2">File Content</label>
                <textarea name="content" id="content" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:shadow-outline font-mono" rows="20"></textarea>
                @error('content')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-end">
                <a href="{{ route('sites.show', $site) }}" class="text-gray-400 hover:text-white mr-4">Cancel</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200"> {{-- Changed to indigo-600 for contrast --}}
                    <i class="bi bi-file-earmark-plus mr-2"></i> Create File
                </button>
            </div>
        </form>
    </div>
</div>
@endsection