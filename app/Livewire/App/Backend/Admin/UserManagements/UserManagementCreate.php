<?php

namespace App\Livewire\App\Backend\Admin\UserManagements;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Livewire\Forms\UserForm;

class UserManagementCreate extends Component
{
    use WithFileUploads;

    public string $title = 'Tambah User';
    public string $event = 'create-user';

    public UserForm $form;

    public function render()
    {
        return view('livewire.app.backend.admin.user-managements.user-management-create');
    }

    #[On('create-user')]
    public function save()
    {
        $this->authorize('create', User::class);

        $response = $this->form->store($this->event);

        $this->dispatch('flash-msg', text: $response['message'], type: $response['type']);

        $this->dispatch('refresh-users', eventName: $this->event);
    }

    #[On('create-user-close')]
    public function closeModal()
    {
        $this->form->resetForm();

        $this->dispatch('refresh-users', eventName: $this->event);

        $this->resetValidation();
    }
}
