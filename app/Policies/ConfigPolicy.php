<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConfigPolicy
{
    use HandlesAuthorization;

    /**
     * Edit a config instance.
     */
    public function edit(User $user): bool
    {
        return $user->hasPermissionTo('edit-config');
    }

    /**
     * View a config instance.
     */
    public function view(User $user): bool
    {
        return $user->hasPermissionTo('edit-config') || $user->hasPermissionTo('view-config');
    }
}
