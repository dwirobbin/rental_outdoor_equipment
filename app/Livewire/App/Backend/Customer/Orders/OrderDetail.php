<?php

namespace App\Livewire\App\Backend\Customer\Orders;

use Carbon\Carbon;
use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\Database\Eloquent\Builder;

#[Layout('layouts.backend-app')]
#[Title('Detail Pesanan Saya')]

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
        abort_if(auth()->user()->can('view', $this->order), 403);

        return view('livewire.app.backend.customer.orders.order-detail');
    }
}
