<?php

namespace App\Livewire\App\Backend\Admin\UserManagements;

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
        $this->authorize('viewAny', User::class);

        return view('livewire.app.backend.admin.user-managements.user-management-index');
    }
}
