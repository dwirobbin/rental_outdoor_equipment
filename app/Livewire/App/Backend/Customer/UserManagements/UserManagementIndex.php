<?php

namespace App\Livewire\App\Backend\Customer\UserManagements;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.backend-app')]
#[Title('Manajemen User')]

class UserManagementIndex extends Component
{
    public function render()
    {
        abort_if(auth()->user()->can('viewAny', User::class), 403);

        return view('livewire.app.backend.customer.user-managements.user-management-index');
    }
}
