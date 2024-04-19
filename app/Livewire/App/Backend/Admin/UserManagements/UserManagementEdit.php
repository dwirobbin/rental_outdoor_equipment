<?php

namespace App\Livewire\App\Backend\Admin\UserManagements;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Livewire\Forms\UserForm;

class UserManagementEdit extends Component
{
    use WithFileUploads;

    public string $title = 'Edit User';
    public string $event = 'edit-user';

    public UserForm $form;

    public function render()
    {
        return view('livewire.app.backend.admin.user-managements.user-management-edit');
    }

    #[On('set-user-data')]
    public function setData(int $id)
    {
        $this->resetValidation();

        $this->form->setData($id);
    }

    #[On('edit-user')]
    public function update()
    {
        $this->authorize('update', $this->form->user);

        $response = $this->form->store($this->event);

        $this->dispatch('flash-msg', text: $response['message'], type: $response['type']);

        $this->dispatch('refresh-users', eventName: $this->event);
    }

    #[On('edit-user-close')]
    public function closeModal()
    {
        $this->form->resetForm();

        $this->dispatch('refresh-users', eventName: $this->event);

        $this->resetValidation();
    }
}
