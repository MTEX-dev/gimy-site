<?php

namespace App\Policies;

use App\Models\Site;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SitePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Site $site)
    {
        return $user->id === $site->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Site $site)
    {
        return $user->id === $site->user_id;
    }

    public function delete(User $user, Site $site)
    {
        return $user->id === $site->user_id;
    }

    public function restore(User $user, Site $site)
    {
        return $user->id === $site->user_id;
    }

    public function forceDelete(User $user, Site $site)
    {
        return $user->id === $site->user_id;
    }
}
