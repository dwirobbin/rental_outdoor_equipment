<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserManagementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role_id == 1 && auth()->check(); // admin
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role_id == 1 && auth()->check(); // admin
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?User $model = null): bool
    {
        return in_array($user->role_id, [1]) && auth()->check(); // admin
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ?User $model = null): bool
    {
        return $user->role_id == 1 && auth()->check(); // admin
    }
}
