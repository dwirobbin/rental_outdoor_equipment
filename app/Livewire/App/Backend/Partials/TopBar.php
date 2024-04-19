<?php

namespace App\Livewire\App\Backend\Partials;

use Livewire\Component;

class TopBar extends Component
{
    public function render()
    {
        return view('livewire.app.backend.partials.top-bar');
    }

    public function logoutHandler()
    {
        auth()->logout();

        return $this->redirectRoute('home');
    }
}
