@extends('layouts.dashboard')

@section('title', 'File Explorer')

@section('breadcrumbs')
    <a href="{{ route('sites.index') }}" class="text-gray-400 hover:text-white">My Sites</a>
    <span class="text-gray-500">/</span>
    <a href="{{ route('sites.show', $site) }}" class="text-gray-400 hover:text-white">{{ $site->name }}</a>
    <span class="text-gray-500">/</span>
    <span>File Explorer</span>
@endsection

@section('dashboard-content')
<div class="bg-gray-800 rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-white">File Explorer</h3>
        <a href="{{ route('sites.files.create', ['site' => $site, 'path' => $path]) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
            <i class="bi bi-file-earmark-plus mr-2"></i> Add File
        </a>
    </div>

    {{-- Breadcrumbs --}}
    <div class="mb-4 text-gray-400">
        <a href="{{ route('sites.explorer', $site) }}" class="hover:text-white">/</a>
        @foreach ($breadcrumbs as $i => $crumb)
            <a href="{{ route('sites.explorer', ['site' => $site, 'path' => $breadcrumbs->slice(0, $i + 1)->implode('/')]) }}" class="hover:text-white">{{ $crumb }}</a>
            @if (!$loop->last)
                <span class="mx-1">/</span>
            @endif
        @endforeach
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <tbody>
                {{-- Parent Directory Link --}}
                @if ($path)
                    <tr class="border-b border-gray-700 hover:bg-gray-700">
                        <td colspan="2" class="py-3 px-4 text-white">
                            <a href="{{ route('sites.explorer', ['site' => $site, 'path' => dirname($path) == '.' ? '' : dirname($path)]) }}" class="flex items-center">
                                <i class="bi bi-arrow-left mr-3"></i>
                                ..
                            </a>
                        </td>
                    </tr>
                @endif

                {{-- Directories --}}
                @foreach ($directories as $dir)
                    <tr class="border-b border-gray-700 hover:bg-gray-700">
                        <td class="py-3 px-4 text-white">
                                    <a href="{{ route('sites.explorer', ['site' => $site, 'path' => str_replace($site->id . '/', '', $dir)]) }}" class="flex items-center">
                                        <i class="bi bi-folder-fill mr-3 text-yellow-500"></i>
                                        {{ basename($dir) }}
                                    </a>
                                </td>
                        <td class="py-3 px-4 text-right">
                            {{-- Directory actions can go here --}}
                        </td>
                    </tr>
                @endforeach

                {{-- Files --}}
                @foreach ($files as $file)
                    @php
                        $siteFile = $site->siteFiles()->where('path', str_replace($site->id . '/', '', $file))->first();
                    @endphp
                    <tr class="border-b border-gray-700 hover:bg-gray-700">
                        <td class="py-3 px-4 text-white">
                            @php
                                $extension = pathinfo($file, PATHINFO_EXTENSION);
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                            @endphp
                            @if(in_array($extension, $imageExtensions))
                                <img src="{{ Storage::disk('sites')->url($file) }}" alt="{{ basename($file) }}" class="w-16 h-16 object-cover inline-block mr-3">
                            @else
                                <i class="bi bi-file-earmark-text mr-3"></i>
                            @endif
                            {{ basename($file) }}
                        </td>
                        <td class="py-3 px-4 text-right">
                            @if ($siteFile)
                                <a href="{{ route('files.edit', $siteFile) }}" class="text-blue-400 hover:text-blue-300 mr-4">Edit</a>
                                <form action="{{ route('files.destroy', $siteFile) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-400" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach

                @if (empty($directories) && empty($files))
                    <tr>
                        <td colspan="2" class="text-center py-6 text-gray-500">This directory is empty.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
