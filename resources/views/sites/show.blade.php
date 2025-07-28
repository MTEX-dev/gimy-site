{{-- resources/views/sites/show.blade.php --}}
@extends('layouts.dashboard')

@section('title', $site->subdomain . '.gimy.site')

@section('breadcrumbs')
    <a href="{{ route('sites.index') }}" class="text-gray-400 hover:text-white">My Sites</a>
    <span class="text-gray-500">/</span>
    <span class="text-gray-500">{{ $site->subdomain }}</span>
@endsection

@section('dashboard-content')
    <input type="hidden" id="current_site_id" value="{{ $site->id }}"> {{-- Hidden input for JS --}}

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-white">
            Site: <a href="{{ $site->baseUrl }}" target="_blank" class="text-cyan-400 hover:underline">{{ $site->subdomain }}.gimy.site <i class="bi bi-box-arrow-up-right text-base ml-1"></i></a>
        </h2>
        <div class="flex gap-2">
            <a href="{{ route('sites.edit', $site) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg">
                <i class="bi bi-pencil mr-2"></i> Edit Site
            </a>
            <form action="{{ route('sites.destroy', $site) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this site and all its content? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
                    <i class="bi bi-trash mr-2"></i> Delete Site
                </button>
            </form>
        </div>
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

    {{-- Tabs for Pages, Files, Settings (Alpine.js required) --}}
    <div x-data="{ activeTab: 'pages' }" class="mb-8">
        <div class="border-b border-gray-700">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button @click="activeTab = 'pages'" :class="{'border-cyan-500 text-cyan-400': activeTab === 'pages', 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-500': activeTab !== 'pages'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Pages
                </button>
                <button @click="activeTab = 'files'" :class="{'border-cyan-500 text-cyan-400': activeTab === 'files', 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-500': activeTab !== 'files'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Files & Assets
                </button>
                <button @click="activeTab = 'settings'" :class="{'border-cyan-500 text-cyan-400': activeTab === 'settings', 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-500': activeTab !== 'settings'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Settings
                </button>
            </nav>
        </div>

        {{-- Pages Tab Content (no change, but ensure it's still correct) --}}
        <div x-show="activeTab === 'pages'" class="mt-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-white">Site Pages</h3>
                <a href="{{ route('sites.pages.create', $site) }}" class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                    <i class="bi bi-plus-circle mr-2"></i> Create New Page
                </a>
            </div>

            @if ($pages->isEmpty())
                <div class="bg-gray-800 p-8 rounded-lg text-center shadow-lg">
                    <p class="text-xl text-gray-400 mb-4">No pages created yet for this site.</p>
                    <a href="{{ route('sites.pages.create', $site) }}" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 px-6 rounded-lg text-lg">
                        Add Your First Page
                    </a>
                </div>
            @else
                <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-lg">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Slug
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Homepage
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($pages as $page)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                        {{ $page->slug }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        {{ $page->title ?: 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($page->is_homepage)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-700 text-green-100">
                                                Yes
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-700 text-red-100">
                                                No
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('sites.pages.show', [$site, $page]) }}" class="text-indigo-400 hover:text-indigo-300">View Content</a>
                                            <a href="{{ route('sites.pages.edit', [$site, $page]) }}" class="text-yellow-400 hover:text-yellow-300">Edit</a>
                                            <form action="{{ route('sites.pages.destroy', [$site, $page]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this page?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Files & Assets Tab Content --}}
        <div x-show="activeTab === 'files'" class="mt-8">
            <h3 class="text-2xl font-bold text-white mb-6">Site Files & Assets</h3>
            <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
                <p class="text-gray-400 mb-6">
                    Upload your site's files here. You can drag and drop files/folders directly into the area below, or click to browse.
                    Supported files include HTML, CSS, JavaScript, images, and more.
                </p>

                {{-- File Upload Area --}}
                <div id="file-upload-area" class="border-2 border-dashed border-gray-600 rounded-lg p-10 text-center cursor-pointer hover:border-cyan-500 transition duration-200">
                    <input type="file" id="file-input" multiple webkitdirectory directory class="hidden" />
                    <i class="bi bi-cloud-arrow-up text-5xl text-gray-500 mb-4"></i>
                    <p class="text-gray-400 text-lg">Drag & Drop your files here or <span class="text-cyan-400 font-semibold">Click to Browse</span></p>
                    <p class="text-sm text-gray-500 mt-2">Folders and multiple files are supported. Max file size: 20MB.</p>
                </div>
                <div id="upload-status" class="mt-4 p-3 hidden rounded text-white"></div>


                <div class="mt-8">
                    <h4 class="text-xl font-bold mb-4">Uploaded Files</h4>
                    @if ($assets->isEmpty())
                        <p class="text-gray-400">No files uploaded yet.</p>
                    @else
                        <div class="bg-gray-700 rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-600">
                                <thead class="bg-gray-600">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">File Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Path</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Size</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">URL</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-600">
                                    @foreach ($assets as $asset)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $asset->name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-300 break-words max-w-[200px]">{{ $asset->path }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $asset->mime_type }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ number_format($asset->size / 1024, 2) }} KB</td>
                                            <td class="px-6 py-4 text-sm text-cyan-400 hover:underline">
                                                <a href="{{ $asset->url }}" target="_blank" class="block truncate max-w-[200px]">
                                                    {{ $asset->url }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <form action="{{ route('sites.files.destroy', [$site, $asset]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file? This cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Settings Tab Content (Placeholder) --}}
        <div x-show="activeTab === 'settings'" class="mt-8">
            <h3 class="text-2xl font-bold text-white mb-6">Site Settings</h3>
            <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
                <p class="text-gray-400">Site settings will go here (e.g., custom domains, redirects, etc.).</p>
            </div>
        </div>
    </div>
    <script>
      // resources/js/app.js
// Ensure Alpine.js is installed and loaded for the tabs functionality.
// npm install alpinejs --save-dev
// in app.js: import Alpine from 'alpinejs'; Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    const fileUploadArea = document.getElementById('file-upload-area');
    const fileInput = document.getElementById('file-input'); // Hidden input for click-to-browse
    const uploadStatusDiv = document.getElementById('upload-status');
    const currentSiteId = document.getElementById('current_site_id')?.value;

    if (!fileUploadArea || !fileInput || !uploadStatusDiv || !currentSiteId) return;

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, preventDefaults, false);
        // Do NOT add to document.body, as it can interfere with other browser functions.
        // Let the default browser behavior handle drops outside our area.
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        fileUploadArea.classList.add('border-cyan-500');
    }

    function unhighlight() {
        fileUploadArea.classList.remove('border-cyan-500');
    }

    // Handle dropped files (including folders)
    fileUploadArea.addEventListener('drop', handleDrop, false);

    async function handleDrop(e) {
        const items = e.dataTransfer.items; // Use items for directory handling
        const filesToUpload = [];

        // Recursive function to process dropped items
        const processDroppedItem = async (item, path = '') => {
            if (item.kind === 'file') {
                const entry = item.webkitGetAsEntry(); // Get directory entry
                if (entry) { // Check if webkitGetAsEntry is supported
                    await readEntry(entry, path, filesToUpload);
                } else {
                    // Fallback for direct file drops without webkitGetAsEntry
                    const file = item.getAsFile();
                    if (file) {
                        filesToUpload.push({ file: file, path: path + file.name });
                    }
                }
            }
        };

        const readEntry = async (entry, path, filesArray) => {
            if (entry.isFile) {
                return new Promise(resolve => {
                    entry.file(file => {
                        filesArray.push({ file: file, path: path + entry.name });
                        resolve();
                    });
                });
            } else if (entry.isDirectory) {
                const directoryReader = entry.createReader();
                const entries = await new Promise(resolve => directoryReader.readEntries(resolve));
                for (const subEntry of entries) {
                    await readEntry(subEntry, path + entry.name + '/', filesArray);
                }
            }
        };

        for (let i = 0; i < items.length; i++) {
            await processDroppedItem(items[i]);
        }

        if (filesToUpload.length > 0) {
            uploadFiles(filesToUpload);
        } else {
            displayStatus('No valid files or folders to upload.', 'error');
        }
    }

    // Handle files from the input element (supports webkitdirectory)
    fileUploadArea.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', (e) => {
        const files = e.target.files;
        const filesToUpload = [];

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const relativePath = file.webkitRelativePath || file.name; // Use webkitRelativePath for folders
            filesToUpload.push({ file: file, path: relativePath });
        }
        if (filesToUpload.length > 0) {
            uploadFiles(filesToUpload);
        } else {
            displayStatus('No files selected.', 'error');
        }
    });

    async function uploadFiles(filesToUpload) {
        uploadStatusDiv.classList.remove('hidden', 'bg-green-600', 'bg-red-600');
        uploadStatusDiv.classList.add('bg-blue-700');
        uploadStatusDiv.textContent = 'Uploading files... Please wait.';

        const formData = new FormData();
        filesToUpload.forEach(fp => {
            formData.append('files[]', fp.file);
            formData.append('paths[]', fp.path);
        });

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch(`/sites/${currentSiteId}/files/upload`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData,
            });

            const data = await response.json();

            if (response.ok) {
                displayStatus(data.success, 'success');
            } else {
                displayStatus(data.error || 'Upload failed.', 'error');
                if (data.details) {
                    console.error('Upload details:', data.details);
                }
            }
        } catch (error) {
            console.error('Network or server error during upload:', error);
            displayStatus('An error occurred during upload. Check console for details.', 'error');
        } finally {
            // Reload page after a short delay to see updated file list
            setTimeout(() => {
                location.reload();
            }, 2000);
        }
    }

    function displayStatus(message, type) {
        uploadStatusDiv.classList.remove('hidden', 'bg-blue-700', 'bg-green-600', 'bg-red-600');
        uploadStatusDiv.textContent = message;
        if (type === 'success') {
            uploadStatusDiv.classList.add('bg-green-600');
        } else if (type === 'error') {
            uploadStatusDiv.classList.add('bg-red-600');
        }
    }
});
    </script>
@endsection