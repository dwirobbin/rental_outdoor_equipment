<?php

namespace App\Livewire\App\Frontend\Carts;

use App\Models\Cart;
use Livewire\Component;
use Livewire\Attributes\On;

class CartDelete extends Component
{
    public function render()
    {
        return view('livewire.app.frontend.carts.cart-delete');
    }

    #[On('go-on-delete-cart-item')]
    public function delete(int $cartItemId)
    {
        try {
            $cart = Cart::findOrFail($cartItemId);
            $cart->delete();

            $this->dispatch('message', text: 'Produk berhasil dihapus dari keranjang!', type: 'success');
            $this->dispatch('refresh-cart-count');
            $this->dispatch('refresh-carts');
        } catch (\Exception $e) {
            $this->dispatch('message', text: 'Terjadi suatu kesalahan!', type: 'error');
        }
    }
}
