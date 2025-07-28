<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PageController extends Controller
{
	public function create(Site $site): View
	{
	    $this->authorize('update', $site);
	    return view('pages.create', ['site' => $site]);
	}

    public function store(Request $request, Site $site): RedirectResponse
    {
        $this->authorize('update', $site);

        $validated = $request->validate([
            'slug' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('pages')->where('site_id', $site->id),
            ],
            'is_homepage' => ['sometimes', 'boolean'],
        ]);

        // Ensure only one homepage exists
        if ($request->boolean('is_homepage')) {
            $site->pages()->update(['is_homepage' => false]);
        }

        $page = $site->pages()->create($validated);

        return redirect()->route('pages.edit', $page);
    }

    public function edit(Page $page): View
    {
        $this->authorize('update', $page->site);
        return view('pages.edit', ['page' => $page]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorize('update', $page->site);

        $validated = $request->validate([
            'slug' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('pages')
                    ->where('site_id', $page->site_id)
                    ->ignore($page->id),
            ],
            'is_homepage' => ['sometimes', 'boolean'],
            'html' => ['nullable', 'string'],
            'css' => ['nullable', 'string'],
            'js' => ['nullable', 'string'],
        ]);

        // Ensure only one homepage exists
        if ($request->boolean('is_homepage')) {
            $page->site->pages()->where('id', '!=', $page->id)->update(['is_homepage' => false]);
        }

        $page->update($validated);

        return back()->with('status', 'page-updated');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $this->authorize('delete', $page->site);
        $site = $page->site;
        $page->delete();

        return redirect()
            ->route('sites.edit', $site)
            ->with('status', 'page-deleted');
    }
}