<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Site;

class PageController extends Controller
{
    public function home()
    {
        $stats = [
            'users' => User::count(),
            'sites' => Site::count(),
        ];

        return view('pages.home', ['stats' => $stats]);
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