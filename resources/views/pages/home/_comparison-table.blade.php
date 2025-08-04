{{-- resources/views/pages/home/_comparison-table.blade.php --}}
<div class="py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
            <h2 class="text-base font-semibold leading-7 text-indigo-400 fade-in-up">{{ __('home.comparison.section_title') }}</h2>
            <p class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-4xl fade-in-up" style="--delay: 100ms">{{ __('home.comparison.title') }}</p>
            <p class="mt-6 text-lg leading-8 text-gray-300 fade-in-up" style="--delay: 200ms">{{ __('home.comparison.subtitle') }}</p>
        </div>
        <div class="mx-auto mt-16 max-w-5xl">
            <div class="overflow-x-auto rounded-lg bg-gray-800/40 ring-1 ring-white/10 fade-in-up" style="--delay: 300ms">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-800/60">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">{{ __('home.comparison.feature') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-white">{{ __('home.comparison.gimy') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-white">{{ __('home.comparison.github_pages') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-white">{{ __('home.comparison.netlify') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach (__('home.comparison.features') as $feature)
                        <tr>
                            <td class="py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-6">{{ $feature['name'] }}</td>
                            <td class="px-3 py-4 text-center text-sm text-gray-300">
                                @if ($feature['gimy'] === 'true')
                                    <i class="bi bi-check-circle-fill text-green-400 text-lg"></i>
                                @elseif ($feature['gimy'] === 'false')
                                    <i class="bi bi-x-circle-fill text-red-400 text-lg"></i>
                                @else
                                    {{ $feature['gimy'] }}
                                @endif
                            </td>
                            <td class="px-3 py-4 text-center text-sm text-gray-300">
                                @if ($feature['github'] === 'true')
                                    <i class="bi bi-check-circle-fill text-green-400 text-lg"></i>
                                @elseif ($feature['github'] === 'false')
                                    <i class="bi bi-x-circle-fill text-red-400 text-lg"></i>
                                @else
                                    {{ $feature['github'] }}
                                @endif
                            </td>
                            <td class="px-3 py-4 text-center text-sm text-gray-300">
                                @if ($feature['netlify'] === 'true')
                                    <i class="bi bi-check-circle-fill text-green-400 text-lg"></i>
                                @elseif ($feature['netlify'] === 'false')
                                    <i class="bi bi-x-circle-fill text-red-400 text-lg"></i>
                                @else
                                    {{ $feature['netlify'] }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
