<?php

namespace App\Livewire\App\Frontend\Carts;

use App\Models\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class CartCounter extends Component
{
    public int $totalItem = 0;

    public function render()
    {
        $this->getCartItemCount();

        return view('livewire.app.frontend.carts.cart-counter');
    }

    #[On('refresh-cart-count')]
    public function getCartItemCount()
    {
        $this->totalItem = Cart::whereUserId(auth()->id())->count();
    }
}
