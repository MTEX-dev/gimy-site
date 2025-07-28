<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Str;

class SiteController extends Controller
{
    public function index()
    {
        $sites = auth()->user()->sites()->latest()->get();
        return view('sites.index', compact('sites'));
    }

    public function create()
    {
        return view('sites.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subdomain' => [
                'required',
                'string',
                'min:3',
                'max:60',
                'alpha_dash', // Only letters, numbers, dashes
                Rule::unique('sites', 'subdomain'),
            ],
        ]);

        $site = auth()->user()->sites()->create([
            'subdomain' => strtolower($request->subdomain),
        ]);

        // Create a default "index" page for the new site
        $site->pages()->create([
            'slug' => 'index',
            'title' => 'Welcome to ' . $site->subdomain,
            'html_content' => '<h1 class="text-4xl font-bold text-center">Welcome to your new site!</h1><p class="text-lg text-center mt-4">Start building amazing things here.</p>',
            'is_homepage' => true,
        ]);

        // Create the site's directory in storage
        Storage::disk('public')->makeDirectory("sites/{$site->id}");

        return redirect()->route('sites.show', $site)->with('success', 'Site created successfully!');
    }

    public function show(Site $site)
    {
        $this->authorize('view', $site); // Ensure user owns the site
        $pages = $site->pages()->latest()->get();
        $assets = $site->assets()->latest()->get(); // For displaying uploaded files
        return view('sites.show', compact('site', 'pages', 'assets'));
    }

    public function edit(Site $site)
    {
        $this->authorize('update', $site);
        return view('sites.edit', compact('site'));
    }

    public function update(Request $request, Site $site)
    {
        $this->authorize('update', $site);

        $request->validate([
            'subdomain' => [
                'required',
                'string',
                'min:3',
                'max:60',
                'alpha_dash',
                Rule::unique('sites', 'subdomain')->ignore($site->id),
            ],
        ]);

        $site->update([
            'subdomain' => strtolower($request->subdomain),
        ]);

        return redirect()->route('sites.show', $site)->with('success', 'Site updated successfully!');
    }

    public function destroy(Site $site)
    {
        $this->authorize('delete', $site);

        // Delete the site's directory from storage
        Storage::disk('public')->deleteDirectory("sites/{$site->id}");

        $site->delete();

        return redirect()->route('sites.index')->with('success', 'Site deleted successfully.');
    }

    // Public method to serve site content based on subdomain and slug
    public function showSiteContent(Request $request, $subdomain, $slug = 'index')
    {
        $site = Site::where('subdomain', $subdomain)->firstOrFail();

        // If no slug provided, try to find the homepage
        if ($slug === 'index' || $slug === '') {
            $page = $site->pages()->where('is_homepage', true)->first();
            if (!$page) {
                $page = $site->pages()->where('slug', 'index')->first();
            }
        } else {
            $page = $site->pages()->where('slug', $slug)->first();
        }

        if (!$page) {
            abort(404); // Or a custom 404 page for user sites
        }

        return view('site_renderer', compact('page'));
    }
}