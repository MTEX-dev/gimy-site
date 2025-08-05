@extends('layouts.dashboard')

@section('title', $site->name . ' ' . __('Statistics'))


@section('breadcrumbs')
    <a href="{{ route('sites.index') }}" class="text-gray-400 hover:text-white">My Sites</a>
    <span class="text-gray-500">/</span>
    <a href="{{ route('sites.show', $site) }}" class="text-gray-400 hover:text-white">{{ $site->name }}</a>
    <span class="text-gray-500">/</span>
    <span>{{ __('Statistics') }}</span>
@endsection

@section('dashboard-content')
    <div class="container mx-auto px-4 py-10">
        <header class="mb-8">
            <h1 class="text-3xl font-bold">Site Statistics for {{ $site->name }}</h1>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-slate-800 rounded-xl shadow-lg p-8">
                <h2 class="text-xl font-bold mb-4">Views Over Time</h2>
                <canvas id="viewsChart"></canvas>
            </div>
            <div class="bg-slate-800 rounded-xl shadow-lg p-8">
                <h2 class="text-xl font-bold mb-4">Recent Views</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-700">
                        <thead>
                            <tr>
                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-6">IP Address</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold">Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @foreach ($recentViews as $view)
                                <tr>
                                    <td class="py-4 pl-4 pr-3 text-sm font-medium sm:pl-6">
                                        {{ $view->device->ip_address }}</td>
                                    <td class="px-3 py-4 text-sm">{{ $view->viewed_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('viewsChart').getContext('2d');
            const viewsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Site Views',
                        data: @json($chartData['data']),
                        backgroundColor: 'rgba(79, 70, 229, 0.2)',
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 1,
                        tension: 0.4,
                        fill: true,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush