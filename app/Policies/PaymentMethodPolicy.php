<?php

namespace App\Policies;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PaymentMethodPolicy
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
    public function view(?User $user = null, ?PaymentMethod $paymentMethod = null): bool
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
    public function update(?User $user = null, ?PaymentMethod $paymentMethod = null): bool
    {
        return $user?->role_id == 1 && auth()->check(); // admin
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user = null, ?PaymentMethod $paymentMethod = null): bool
    {
        return $user?->role_id == 1 && auth()->check(); // admin
    }
}
