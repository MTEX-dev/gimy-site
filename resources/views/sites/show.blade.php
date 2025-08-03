@extends('layouts.dashboard')

@section('title', $site->name)

@section('breadcrumbs')
    <a href="{{ route('sites.index') }}" class="text-gray-400 hover:text-white">My Sites</a>
    <span class="text-gray-500">/</span>
    <span>{{ $site->name }}</span>
@endsection

@section('dashboard-content')
    @if (session('status'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Site Details --}}
        <div class="lg:col-span-2">
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-3xl font-bold text-white">{{ $site->name }}</h2>
                        <p class="text-gray-400 mt-1">{{ $site->description }}</p>
                    </div>
                    <a href="{{ route('sites.edit', $site) }}" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                        <i class="bi bi-pencil-square mr-2"></i> Edit
                    </a>
                </div>
                <div class="mt-6 border-t border-gray-700 pt-4">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div class="flex flex-col">
                            <dt class="text-sm font-medium text-gray-400">Domain</dt>
                            <dd class="mt-1 text-sm text-white">
                                @if($site->domain)
                                    <a href="http://{{ $site->domain }}" target="_blank" class="text-cyan-400 hover:text-cyan-300">{{ $site->domain }}</a>
                                @else
                                    <span class="text-gray-500">Not set</span>
                                @endif
                            </dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="text-sm font-medium text-gray-400">GitHub Repository</dt>
                            <dd class="mt-1 text-sm text-white">
                                @if($site->github_url)
                                    <a href="{{ $site->github_url }}" target="_blank" class="text-cyan-400 hover:text-cyan-300">View on GitHub</a>
                                @else
                                    <span class="text-gray-500">Not linked</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-6 border-t border-gray-700 pt-6">
                <h3 class="text-xl font-bold text-white mb-4">Actions</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('sites.explorer', $site) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                        <i class="bi bi-folder-symlink mr-2"></i> File Explorer
                    </a>
                    <!--a href="{{ route('sites.deployments.create', $site) }}" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                        <i class="bi bi-cloud-arrow-up mr-2"></i> New Deployment
                    </a-->
                    @if($site->github_url)
                    <form action="{{ route('sites.pull', $site) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                            <i class="bi bi-github mr-2"></i> Pull from GitHub
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('sites.backups.index', $site) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                        <i class="bi bi-archive mr-2"></i> View Backups
                    </a>
                </div>
            </div>
        </div>

        {{-- Files --}}
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-white">Site Files</h3>
                <a href="{{ route('sites.files.create', $site) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    <i class="bi bi-file-earmark-plus mr-2"></i> Add File
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <tbody>
                        @forelse ($site->siteFiles as $file)
                            <tr class="border-b border-gray-700 hover:bg-gray-700">
                                <td class="py-3 px-4 text-white">
                                    @php
                                        $extension = pathinfo($file->path, PATHINFO_EXTENSION);
                                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                                    @endphp
                                    @if(in_array($extension, $imageExtensions))
                                        <img src="{{ Storage::disk('sites')->url($site->id . '/' . $file->path) }}" alt="{{ $file->path }}" class="w-16 h-16 object-cover inline-block mr-3">
                                    @else
                                        <i class="bi bi-file-earmark-text mr-3"></i>
                                    @endif
                                    {{ $file->path }}
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('files.edit', $file) }}" class="text-blue-400 hover:text-blue-300 mr-4">Edit</a>
                                    <form action="{{ route('files.destroy', $file) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-6 text-gray-500">No files uploaded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Deployments --}}
    <!--div class="lg:col-span-1 mt-6">
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-white">Deployments</h3>
                <a href="{{ route('sites.deployments.create', $site) }}" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    <i class="bi bi-cloud-arrow-up mr-2"></i> New Deployment
                </a>
            </div>
            <ul>
                @forelse ($site->siteDeployments as $deployment)
                    <li class="border-b border-gray-700 py-3">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-white">{{ $deployment->status }}</span>
                            <span class="text-sm text-gray-400">{{ $deployment->created_at->diffForHumans() }}</span>
                        </div>
                        @if($deployment->commit_hash)
                            <p class="text-sm text-gray-500 mt-1">Commit: {{ substr($deployment->commit_hash, 0, 7) }}</p>
                        @endif
                    </li>
                @empty
                    <li class="text-center py-6 text-gray-500">No deployments yet.</li>
                @endforelse
            </ul>
        </div>
    </div-->
@endsection