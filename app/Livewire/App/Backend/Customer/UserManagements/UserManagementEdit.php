<?php

namespace App\Livewire\App\Backend\Customer\UserManagements;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Livewire\Forms\UserForm;

class UserManagementEdit extends Component
{
    use WithFileUploads;

    public string $title = 'Edit Akun';
    public string $event = 'edit-account';

    public UserForm $form;

    public function render()
    {
        abort_if(auth()->user()->can('update', User::class), 403);

        return view('livewire.app.backend.customer.user-managements.user-management-edit');
    }

    #[On('set-account-data')]
    public function setData(int $id)
    {
        abort_if(auth()->user()->can('update', User::class), 403);

        $this->resetValidation();

        $this->form->setData($id);
    }

    #[On('edit-account')]
    public function update()
    {
        abort_if(auth()->user()->can('update', User::class), 403);

        $response = $this->form->store($this->event);

        $this->dispatch('flash-msg', text: $response['message'], type: $response['type']);

        $this->dispatch('refresh-users', eventName: $this->event);
    }

    #[On('edit-account-close')]
    public function closeModal()
    {
        $this->form->resetForm();

        $this->dispatch('refresh-users', eventName: $this->event);

        $this->resetValidation();
    }
}
