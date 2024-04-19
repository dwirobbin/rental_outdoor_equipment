<?php

namespace App\Policies;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EquipmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role_id == 1 && auth()->check(); // admin
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user = null, ?Equipment $equipment = null): bool
    {
        return $user?->role_id == 1 && auth()->check(); // admin
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
    public function update(?User $user = null, ?Equipment $equipment = null): bool
    {
        return $user?->role_id == 1 && auth()->check(); // admin
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user = null, ?Equipment $equipment = null): bool
    {
        return $user?->role_id == 1 && auth()->check(); // admin
    }
}
