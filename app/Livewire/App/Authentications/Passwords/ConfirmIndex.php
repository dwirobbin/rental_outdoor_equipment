<?php

namespace App\Livewire\App\Authentications\Passwords;

use Livewire\Component;
use Livewire\Attributes\{Title, Layout};

#[Layout('layouts.auth-app')]
#[Title('Konfirmasi Email')]

class ConfirmIndex extends Component
{
    public ?string $email = null;

    public function mount(?string $email = null)
    {
        $this->email = $email;
    }

    public function render()
    {
        return view('livewire.app.authentications.passwords.confirm-index');
    }
}
