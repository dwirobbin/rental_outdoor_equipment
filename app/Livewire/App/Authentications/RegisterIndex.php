<?php

namespace App\Livewire\App\Authentications;

use Livewire\Component;
use Livewire\Attributes\{Layout, Title};
use App\Livewire\Forms\UserForm;

#[Layout('layouts.auth-app')]
#[Title('Daftar')]

class RegisterIndex extends Component
{
    public UserForm $form;

    public function render()
    {
        return view('livewire.app.authentications.register-index');
    }

    public function save()
    {
        $response = $this->form->store('register');

        if ($response['type'] === 'success') {
            session()->flash('message', ['text' => 'Berhasil mendaftar, Silahkan masuk!', 'type' => $response['type']]);

            $this->redirectRoute('auth.login');
        } else {
            session()->flash('message', ['text' => $response['message'], 'type' => $response['type']]);
        }

        $this->resetValidation();
        $this->dispatch('remove-alert');
    }
}
