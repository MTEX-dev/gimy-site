@extends('layouts.dashboard')

@section('title', 'Application Logs')

@section('dashboard-content')
<div class="bg-gray-800 rounded-lg shadow-lg p-6">
    <h3 class="text-xl font-bold text-white mb-4">Application Logs</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-400">Level</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-400">Message</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-400">Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr class="border-b border-gray-700 hover:bg-gray-700">
                        <td class="py-3 px-4 text-white">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $log->level === 'error' ? 'bg-red-500' : 'bg-gray-500' }}">
                                {{ $log->level }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-white">{{ $log->message }}</td>
                        <td class="py-3 px-4 text-gray-400">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-6 text-gray-500">No logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $logs->links() }}
    </div>
</div>
@endsection
