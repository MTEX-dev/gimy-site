<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\SiteView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index(Site $site)
    {
        $this->authorize('view', $site);

        $recentViews = $site
            ->siteViews()
            ->with('device')
            ->latest('viewed_at')
            ->take(10)
            ->get();

        $viewsOverTime = $site
            ->siteViews()
            ->select(DB::raw('DATE(viewed_at) as date'), DB::raw('count(*) as views'))
            ->where('viewed_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chartData = [
            'labels' => $viewsOverTime->pluck('date'),
            'data' => $viewsOverTime->pluck('views'),
        ];

        return view('sites.stats', compact('site', 'recentViews', 'chartData'));
    }
}