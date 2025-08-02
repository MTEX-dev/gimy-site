@extends('layouts.dashboard')

@section('title', 'My Sites')

@section('dashboard-content')
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-white">My Sites</h2>
        <a href="{{ route('sites.create') }}" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
            <i class="bi bi-plus-circle mr-2"></i> Create New Site
        </a>
    </div>

    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-900 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Name
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-900 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Domain
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-900 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Last Updated
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-900"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sites as $site)
                    <tr class="hover:bg-gray-700">
                        <td class="px-5 py-5 border-b border-gray-700 text-sm">
                            <p class="text-white whitespace-no-wrap">{{ $site->name }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 text-sm">
                            @if($site->domain)
                                <a href="http://{{ $site->domain }}" target="_blank" class="text-cyan-400 hover:text-cyan-300">{{ $site->domain }}</a>
                            @else
                                <span class="text-gray-500">No domain</span>
                            @endif
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 text-sm">
                            <p class="text-gray-400 whitespace-no-wrap">{{ $site->updated_at->format('M d, Y') }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 text-sm text-right">
                            <a href="{{ route('sites.show', $site) }}" class="text-blue-400 hover:text-blue-300 mr-3">Manage</a>
                            <a href="{{ route('sites.edit', $site) }}" class="text-green-400 hover:text-green-300 mr-3">Settings</a>
                            <form action="{{ route('sites.destroy', $site) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400" onclick="return confirm('Are you sure you want to delete this site? This action cannot be undone.')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-10 text-gray-500">
                            <i class="bi bi-exclamation-circle-fill text-4xl mb-3"></i>
                            <p class="text-xl">No sites found.</p>
                            <p>Get started by creating a new site.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
