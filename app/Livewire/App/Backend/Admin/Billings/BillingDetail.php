<?php

namespace App\Livewire\App\Backend\Admin\Billings;

use Carbon\Carbon;
use App\Models\Billing;
use Livewire\Component;
use App\Models\PaymentMethod;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\Database\Eloquent\Builder;

#[Layout('layouts.backend-app')]
#[Title('Detail Tagihan')]

class BillingDetail extends Component
{
    public $billing;
    public $payTime;
    public $numberOfDays;
    public $paymentMethods;

    public function mount($orderCode)
    {
        $this->billing = Billing::with([
            'order' => fn (Builder $query) => $query->with([
                'orderDetails' => fn (Builder $query) => $query->with(['equipment']),
                'orderedBy'
            ])
        ])
            ->whereHas('order', function (Builder $query) use ($orderCode) {
                $query->where('order_code', '=', $orderCode);
            })->first();

        $this->payTime = Carbon::parse($this->billing->created_date)->yesterday()
            ->diffInDays(Carbon::parse($this->billing->due_date));

        $this->numberOfDays = Carbon::parse($this->billing->order->start_date)->yesterday()
            ->diffInDays(Carbon::parse($this->billing->order->end_date));

        $this->paymentMethods = PaymentMethod::all();
    }

    public function render()
    {
        $this->authorize('view', $this->billing);

        return view('livewire.app.backend.admin.billings.billing-detail');
    }
}
