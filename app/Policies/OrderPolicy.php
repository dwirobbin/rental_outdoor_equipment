<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
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
    public function view(?User $user = null, ?Order $order = null): bool
    {
        return $user?->role_id == 1 || (auth()->check() && $order?->ordered_by == 1); // admin
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
    public function update(?User $user = null, ?Order $order = null): bool
    {
        return $user?->role_id == 1 || (auth()->check() && $order?->ordered_by == 1); // admin
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user = null, ?Order $order = null): bool
    {
        return $user?->role_id == 1 || (auth()->check() && $order?->ordered_by == 1); // admin
    }
}
