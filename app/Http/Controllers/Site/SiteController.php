<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    public function create(): View
    {
        return view('sites.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'subdomain' => [
                'required',
                'string',
                'max:63',
                'alpha_dash',
                'unique:sites',
            ],
        ]);

        $site = $request->user()->sites()->create([
            'name' => $validated['name'],
            'subdomain' => $validated['subdomain'],
            'status' => 'active',
            'locale' => $request->user()->default_locale,
        ]);

        Storage::disk('sites')->makeDirectory($site->id);

        return redirect()->route('sites.edit', $site);
    }

    public function edit(Site $site): View
    {
        $this->authorize('update', $site);

        return view('sites.edit', [
            'site' => $site,
            'pages' => $site->pages()->orderBy('slug')->get(),
            'assets' => $site->assets()->orderBy('path')->get(),
        ]);
    }

    public function update(Request $request, Site $site): RedirectResponse
    {
        $this->authorize('update', $site);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'subdomain' => [
                'required',
                'string',
                'max:63',
                'alpha_dash',
                Rule::unique('sites')->ignore($site->id),
            ],
            'locale' => ['required', 'string', 'max:5'],
            'status' => ['required', 'string', Rule::in(['active', 'suspended'])],
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