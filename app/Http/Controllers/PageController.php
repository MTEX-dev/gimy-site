<?php

namespace App\Http\Controllers;

use App\Models\Site; // Import Site model
use App\Models\Page;
use Illuminate\Http\Request;
use Str;

class PageController extends Controller
{
    public function __construct()
    {
        // For 'store' (create) action, the Site model instance is available from the route model binding
        // For 'index', it's also available.
        // For 'show', 'edit', 'update', 'destroy', both Site and Page are available from route model binding.
        // The policy methods are designed to receive both.

        // The issue is with 'create' specifically, where Laravel's default authorization might not pass 'site'.
        // We'll adjust the policy definition to handle the potentially missing Site for 'create' if not using `authorizeResource`
        // or ensure `authorizeResource` is correctly configured for nested resources.

        // A more robust way to authorize for resource controllers with parent:
        // Instead of using authorizeResource in constructor, use authorize in each method
        // OR adjust the policy method signature for `create`
        // Given the current structure with `authorizeResource`, let's just make the policy's `create` method
        // aware that `site` might not always be there during initial checks,
        // but for nested resources, Laravel *should* pass it if configured correctly.

        // Let's re-evaluate the policy methods given the authorizeResource usage for nested resources.
        // When using Route::resource('sites.pages', PageController::class), Laravel's implicit model binding
        // will try to resolve {site} and {page} and pass them.

        // The problem comes from Gate::allows('create', Page::class) or @can('create', Page::class) in Blade
        // where only the model class is passed, not the parent instance.

        // The simplest fix for the policy is to make the $site argument nullable for the `create` method,
        // and then check for its presence.
        // However, the ideal way is to always ensure the site is available when creating a page for a specific site.

        // Let's go back to using explicit authorization in methods where the context is clear.
        // This makes it less reliant on how `authorizeResource` works with nested resources.
        // I will remove `authorizeResource` from the constructor and put `authorize` calls in methods.
    }

    public function index(Site $site)
    {
        $this->authorize('viewAny', [Page::class, $site]); // Policy will receive Page::class and Site $site
        $pages = $site->pages()->latest()->get();
        return view('pages.index', compact('site', 'pages'));
    }

    public function create(Site $site)
    {
        $this->authorize('create', [Page::class, $site]); // Policy will receive Page::class and Site $site
        return view('pages.create', compact('site'));
    }

    public function store(Request $request, Site $site)
    {
        $this->authorize('create', [Page::class, $site]); // Use 'create' for store as well

        $request->validate([
            'slug' => [
                'required',
                'string',
                'min:1',
                'max:100',
                'alpha_dash',
                'unique:pages,slug,NULL,id,site_id,' . $site->id,
            ],
            'title' => 'nullable|string|max:255',
            'html_content' => 'nullable|string',
            'is_homepage' => 'boolean',
        ]);

        if ($request->boolean('is_homepage')) {
            $site->pages()->update(['is_homepage' => false]);
        }

        $page = $site->pages()->create([
            'slug' => Str::slug($request->slug),
            'title' => $request->title,
            'html_content' => $request->html_content ?? '<body><div><h1>Hello, this is a new page!</h1></div></body>',
            'is_homepage' => $request->boolean('is_homepage'),
        ]);

        return redirect()->route('sites.pages.show', [$site, $page])->with('success', 'Page created successfully.');
    }

    public function show(Site $site, Page $page)
    {
        $this->authorize('view', $page); // Policy will receive User and Page. It will check $page->site_id.
        // No need to pass site explicitly here if PagePolicy::view properly checks $page->site_id
        // within the policy itself against user's sites.
        return view('pages.show', compact('site', 'page'));
    }

    public function edit(Site $site, Page $page)
    {
        $this->authorize('update', $page); // Policy will receive User and Page
        return view('pages.edit', compact('site', 'page'));
    }

    public function update(Request $request, Site $site, Page $page)
    {
        $this->authorize('update', $page); // Policy will receive User and Page

        $request->validate([
            'slug' => [
                'required',
                'string',
                'min:1',
                'max:100',
                'alpha_dash',
                'unique:pages,slug,' . $page->id . ',id,site_id,' . $site->id,
            ],
            'title' => 'nullable|string|max:255',
            'html_content' => 'nullable|string',
            'is_homepage' => 'boolean',
        ]);

        if ($request->boolean('is_homepage')) {
            $site->pages()->where('id', '!=', $page->id)->update(['is_homepage' => false]);
        }

        $page->update([
            'slug' => Str::slug($request->slug),
            'title' => $request->title,
            'html_content' => $request->html_content,
            'is_homepage' => $request->boolean('is_homepage'),
        ]);

        return redirect()->route('sites.pages.show', [$site, $page])->with('success', 'Page updated successfully.');
    }

    public function destroy(Site $site, Page $page)
    {
        $this->authorize('delete', $page); // Policy will receive User and Page

        if ($page->is_homepage && $site->pages()->count() > 1) {
            return back()->with('error', 'Cannot delete the homepage if other pages exist. Assign another page as homepage first.');
        }

        $page->delete();
        return redirect()->route('sites.pages.index', $site)->with('success', 'Page deleted successfully.');
    }
}