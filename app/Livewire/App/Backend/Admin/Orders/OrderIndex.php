<?php

namespace App\Livewire\App\Backend\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.backend-app')]
#[Title('Pesanan')]

class OrderIndex extends Component
{
    public function render()
    {
        $this->authorize('viewAny', Order::class);

        return view('livewire.app.backend.admin.orders.order-index');
    }
}
