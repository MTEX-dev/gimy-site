<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Auth::user()->sites;
        return view('sites.index', compact('sites'));
    }

    public function create()
    {
        return view('sites.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'domain' => 'nullable|string|max:255|unique:sites',
            'github_url' => 'nullable|string|max:255',
        ]);

        $site = Auth::user()->sites()->create($request->all());

        Storage::disk('sites')->makeDirectory($site->id);

        return redirect()->route('sites.show', $site);
    }

    public function show(Site $site)
    {
        $this->authorize('view', $site);
        return view('sites.show', compact('site'));
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'domain' => 'nullable|string|max:255|unique:sites,domain,' . $site->id,
            'github_url' => 'nullable|string|max:255',
        ]);

        $site->update($request->all());

        return redirect()->route('sites.show', $site);
    }

    public function destroy(Site $site)
    {
        $this->authorize('delete', $site);
        Storage::disk('sites')->deleteDirectory($site->id);
        $site->delete();
        return redirect()->route('sites.index');
    }
}
