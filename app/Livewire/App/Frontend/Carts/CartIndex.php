<?php

namespace App\Livewire\App\Frontend\Carts;

use Livewire\Component;
use App\Models\PaymentMethod;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Collection;

#[Layout('layouts.frontend-app')]
#[Title('Keranjang')]

class CartIndex extends Component
{
    public Collection $paymentMethods;

    public function mount()
    {
        $this->paymentMethods = PaymentMethod::get(['id', 'photo']);
    }

    public function render()
    {
        return view('livewire.app.frontend.carts.cart-index');
    }
}
