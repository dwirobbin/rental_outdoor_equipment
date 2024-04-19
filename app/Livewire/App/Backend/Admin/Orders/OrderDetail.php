<?php

namespace App\Livewire\App\Backend\Admin\Orders;

use Carbon\Carbon;
use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\Database\Eloquent\Builder;

#[Layout('layouts.backend-app')]
#[Title('Detail Pesanan')]

class OrderDetail extends Component
{
    public $order;
    public $numberOfDays;

    public function mount($orderCode)
    {
        $this->order = Order::with([
            'orderDetails' => fn (Builder $query) => $query->with(['equipment']),
            'billing'
        ])
            ->whereOrderCode($orderCode)
            ->first();

        $this->numberOfDays = Carbon::parse($this->order->start_date)->yesterday()
            ->diffInDays(Carbon::parse($this->order->end_date));
    }

    public function render()
    {
        $this->authorize('view', $this->order);

        return view('livewire.app.backend.admin.orders.order-detail');
    }
}
