<?php

namespace App\Livewire\App\Frontend\Partials;

use Livewire\Component;

class NavBar extends Component
{
    public function render()
    {
        return view('livewire.app.frontend.partials.nav-bar');
    }

    public function logoutHandler()
    {
        auth()->logout();

        return $this->redirectRoute('home');
    }
}
