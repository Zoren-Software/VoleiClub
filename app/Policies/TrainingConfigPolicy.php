<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrainingConfigPolicy
{
    use HandlesAuthorization;

    /**
     * Edit a training config instance.
     */
    public function edit(User $user): bool
    {
        return $user->hasPermissionTo('edit-training-config');
    }

    /**
     * View a training config instance.
     */
    public function view(User $user): bool
    {
        return $user->hasPermissionTo('edit-training-config') || $user->hasPermissionTo('view-training-config');
    }
}
