<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Page;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('pages')->where('site_id', $site->id),
            ],
            'is_homepage' => ['sometimes', 'boolean'],
            'html_content' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($request, $site, $validated) {
            if ($request->boolean('is_homepage')) {
                $site->pages()->update(['is_homepage' => false]);
            }

            $page = $site->pages()->create([
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'is_homepage' => $validated['is_homepage'] ?? false,
            ]);

            $htmlFileName = $validated['slug'] === '/' || $validated['slug'] === '' ? 'index.html' : $validated['slug'] . '.html';
            $htmlPath = '/' . $htmlFileName;

            Storage::disk('sites')->put("{$site->id}/{$htmlPath}", $validated['html_content'] ?? '');

            $asset = $site->assets()->create([
                'file_name' => $htmlFileName,
                'path' => $htmlPath,
                'mime_type' => 'text/html',
                'type' => 'html',
                'file_size' => Storage::disk('sites')->size("{$site->id}/{$htmlPath}"),
            ]);

            $page->assets()->attach($asset->id);
        });


        return redirect()->route('sites.edit', $site)->with('status', 'page-created');
    }

    public function edit(Page $page): View
    {
        $this->authorize('update', $page->site);

        $htmlAsset = $page->assets()->where('type', 'html')->first();
        $htmlContent = $htmlAsset ? Storage::disk('sites')->get("{$page->site->id}/{$htmlAsset->path}") : '';


        $cssAssets = $page->assets()->where('type', 'css')->get();
        $jsAssets = $page->assets()->where('type', 'js')->get();

        return view('pages.edit', [
            'page' => $page,
            'htmlContent' => $htmlContent,
            'cssAssets' => $cssAssets,
            'jsAssets' => $jsAssets,
            'availableAssets' => $page->site->assets()->get(),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorize('update', $page->site);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('pages')
                    ->where('site_id', $page->site_id)
                    ->ignore($page->id),
            ],
            'is_homepage' => ['sometimes', 'boolean'],
            'html_content' => ['nullable', 'string'],
            'linked_css_assets' => ['nullable', 'array'],
            'linked_css_assets.*' => ['uuid', Rule::exists('assets', 'id')->where('site_id', $page->site_id)],
            'linked_js_assets' => ['nullable', 'array'],
            'linked_js_assets.*' => ['uuid', Rule::exists('assets', 'id')->where('site_id', $page->site_id)],
        ]);

        DB::transaction(function () use ($request, $page, $validated) {
            if ($request->boolean('is_homepage')) {
                $page->site->pages()->where('id', '!=', $page->id)->update(['is_homepage' => false]);
            }
            $page->update([
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'is_homepage' => $validated['is_homepage'] ?? false,
            ]);

            $htmlAsset = $page->assets()->where('type', 'html')->first();
            if ($htmlAsset) {
                $newHtmlFileName = $validated['slug'] === '/' || $validated['slug'] === '' ? 'index.html' : $validated['slug'] . '.html';
                $newHtmlPath = '/' . $newHtmlFileName;

                if ($htmlAsset->path !== $newHtmlPath) {
                    Storage::disk('sites')->move(
                        "{$page->site->id}/{$htmlAsset->path}",
                        "{$page->site->id}/{$newHtmlPath}"
                    );
                    $htmlAsset->update([
                        'file_name' => $newHtmlFileName,
                        'path' => $newHtmlPath,
                    ]);
                }

                Storage::disk('sites')->put("{$page->site->id}/{$htmlAsset->path}", $validated['html_content'] ?? '');
                $htmlAsset->update(['file_size' => Storage::disk('sites')->size("{$page->site->id}/{$htmlAsset->path}")]);
            } else {
                $htmlFileName = $validated['slug'] === '/' || $validated['slug'] === '' ? 'index.html' : $validated['slug'] . '.html';
                $htmlPath = '/' . $htmlFileName;
                Storage::disk('sites')->put("{$page->site->id}/{$htmlPath}", $validated['html_content'] ?? '');
                $asset = $page->site->assets()->create([
                    'file_name' => $htmlFileName,
                    'path' => $htmlPath,
                    'mime_type' => 'text/html',
                    'type' => 'html',
                    'file_size' => Storage::disk('sites')->size("{$page->site->id}/{$htmlPath}"),
                ]);
                $page->assets()->attach($asset->id);
            }

            $allLinkedAssetIds = array_merge(
                $validated['linked_css_assets'] ?? [],
                $validated['linked_js_assets'] ?? []
            );
            $page->assets()->sync($allLinkedAssetIds);
        });

        return back()->with('status', 'page-updated');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $this->authorize('delete', $page->site);
        $site = $page->site;

        DB::transaction(function () use ($page) {
            $page->assets()->detach();
            $page->delete();
        });

        return redirect()
            ->route('sites.edit', $site)
            ->with('status', 'page-deleted');
    }
}