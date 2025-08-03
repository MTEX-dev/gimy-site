@extends('layouts.dashboard')

@section('title', 'Backups for ' . $site->name)

@section('breadcrumbs')
    <a href="{{ route('sites.index') }}" class="text-gray-400 hover:text-white">My Sites</a>
    <span class="text-gray-500">/</span>
    <a href="{{ route('sites.show', $site) }}" class="text-gray-400 hover:text-white">{{ $site->name }}</a>
    <span class="text-gray-500">/</span>
    <span>Backups</span>
@endsection

@section('dashboard-content')
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-white">Backups</h2>
        <form action="{{ route('sites.backups.store', $site) }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="bi bi-archive mr-2"></i> Create New Backup
            </button>
        </form>
    </div>

    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-900 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Backup Date
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-900"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($backups as $backup)
                    <tr class="hover:bg-gray-700">
                        <td class="px-5 py-5 border-b border-gray-700 text-sm">
                            <p class="text-white whitespace-no-wrap">{{ $backup['created_at']->format('M d, Y, H:i:s') }}</p>
                            <p class="text-gray-500 whitespace-no-wrap">{{ $backup['name'] }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-700 text-sm text-right">
                            <form action="{{ route('sites.backups.restore', $site) }}" method="POST">
                                @csrf
                                <input type="hidden" name="backup_path" value="{{ $backup['path'] }}">
                                <button type="submit" class="text-green-400 hover:text-green-300" onclick="return confirm('Are you sure you want to restore this backup? This will overwrite the current site content.')">Restore</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center py-10 text-gray-500">
                            <i class="bi bi-exclamation-circle-fill text-4xl mb-3"></i>
                            <p class="text-xl">No backups found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
