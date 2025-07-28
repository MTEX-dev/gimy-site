<?php

namespace App\Policies;

use App\Models\Site;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SitePolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Any authenticated user can view their sites list
    }

    public function view(User $user, Site $site): bool
    {
        return $user->id === $site->user_id;
    }

    public function create(User $user): bool
    {
        return $user->sites()->count() < 25; // Limit to 25 sites per user
    }

    public function update(User $user, Site $site): bool
    {
        return $user->id === $site->user_id;
    }

    public function delete(User $user, Site $site): bool
    {
        return $user->id === $site->user_id;
    }
}