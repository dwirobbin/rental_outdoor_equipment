<?php

namespace App\Livewire\App\Backend\Customer\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.backend-app')]
#[Title('Pesanan Saya')]

class OrderIndex extends Component
{
    public function render()
    {
        abort_if(auth()->user()->can('viewAny', Order::class), 403);

        return view('livewire.app.backend.customer.orders.order-index');
    }
}
