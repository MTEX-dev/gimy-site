<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Site;
use App\Models\SiteFile;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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

    public function handleFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'message_type' => 'required|string|in:feedback,suggestion,bug',
            'message' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        
        return Redirect::back()->with('feedback_success', __('home.feedback.success_message'));
    }

    public function handleNewsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        return Redirect::back()->with('newsletter_success', __('home.newsletter.success_message'));
    }
}
