<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\Site;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PagePolicy
{
    // ... other methods ...

    // Make $site nullable to avoid "Too few arguments" error when only User is passed,
    // though in our routes, $site will always be passed.
    // If you explicitly call Gate::authorize('create', Page::class) without a site,
    // this would prevent an error, but wouldn't properly authorize without site context.
    // The previous update to PageController in Solution 1 makes this less necessary.
    public function create(User $user, Site $site): bool
    {
        return $user->id === $site->user_id;
    }

    // Keep viewAny, view, update, delete as they were, because the site
    // is always available as the parent model for these actions via route model binding.
    public function viewAny(User $user, Site $site): bool
    {
        return $user->id === $site->user_id;
    }

    public function view(User $user, Page $page): bool
    {
        // When Laravel passes `Page $page` to the policy, the page object
        // already has its site_id. So we can directly check ownership via the page's site.
        return $user->id === $page->site->user_id;
    }

    public function update(User $user, Page $page): bool
    {
        return $user->id === $page->site->user_id;
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->id === $page->site->user_id;
    }
}