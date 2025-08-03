<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $sitesCount = $user->sites()->count();
        $filesCount = $user->siteFiles()->count();
        $sites = auth()->user()->sites()->latest()->get();
        return view('dashboard', compact([
            'sites',
            'sitesCount',
            'filesCount',
        ]));
    }
}