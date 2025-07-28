<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SiteController extends Controller
{
	public function show($subdomain, $slug = null)
	{
	    $site = Site::where('subdomain', $subdomain)->firstOrFail();
	
	    if ($slug === null) {
	        // Find the designated homepage
	        $page = $site->pages()->where('is_homepage', true)->firstOrFail();
	    } else {
	        // Find the page by its slug
	        $page = $site->pages()->where('slug', $slug)->firstOrFail();
	    }
	
	    return view('sites.show', ['page' => $page]);
	}
	
    public function create(): View
    {
        return view('sites.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subdomain' => [
                'required',
                'string',
                'max:63',
                'alpha_dash',
                'unique:sites',
            ],
        ]);

        $site = $request->user()->sites()->create($validated);

        return redirect()->route('sites.edit', $site);
    }

	public function edit(Site $site): View
	{
	    $this->authorize('update', $site);
		
	    return view('sites.edit', [
	        'site' => $site,
	        'pages' => $site->pages()->orderBy('slug')->get(),
	    ]);
	}
	
	public function update(Request $request, Site $site): RedirectResponse
	{
	    $this->authorize('update', $site);
	
	    $validated = $request->validate([
	        'subdomain' => [
	            'required',
	            'string',
	            'max:63',
	            'alpha_dash',
	            Rule::unique('sites')->ignore($site->id),
	        ],
	    ]);
	
	    $site->update($validated);
	
	    return back()->with('status', 'site-updated');
	}
	
    public function destroy(Site $site): RedirectResponse
    {
        $this->authorize('delete', $site);
        $site->delete();

        return redirect()
            ->route('dashboard')
            ->with('status', 'site-deleted');
    }
}