<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Site;
use App\Models\SiteFile;

class PageController extends Controller
{
    public function home()
    {
        $stats = [
            'users' => User::count(),
            'sites' => Site::count(),
            'files' => SiteFile::count(),
        ];

        return view('pages.home', ['stats' => $stats]);
    }

    public function dashboard()
    {
        $user = auth()->user();
        $sitesCount = $user->sites()->count();
        $filesCount = $user->siteFiles()->count();
        $sites = auth()->user()->sites()->latest()->get();
        return view('pages.dashboard', compact([
            'sites',
            'sitesCount',
            'filesCount',
        ]));
    }

    public function legal(string $section)
    {
        $sections = ['imprint', 'terms', 'privacy'];

        if (!in_array($section, $sections)) {
            abort(404);
        }

        return view('pages.legal', compact('section', 'sections'));
    }
}