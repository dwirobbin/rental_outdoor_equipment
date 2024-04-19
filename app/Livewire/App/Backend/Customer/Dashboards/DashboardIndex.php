<?php

namespace App\Livewire\App\Backend\Customer\Dashboards;

use App\Models\Order;
use App\Models\Billing;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Database\Eloquent\Builder;

#[Layout('layouts.backend-app')]
#[Title('Dashboard')]

class DashboardIndex extends Component
{
    public string $billStatus = 'unpaid';
    public string $orderStatus = 'pending';

    public function render()
    {
        abort_if(Gate::denies('isCustomer'), 403);

        $countData['bill'] = Billing::with([
            'order' => fn (Builder $query) => $query->with('orderedBy')
        ])
            ->whereHas(
                'order',
                fn (Builder $query) => $query->whereHas(
                    'orderedBy',
                    fn (Builder $query) => $query->where('id', '=', auth()->id())
                )
            )
            ->whereStatus($this->billStatus)
            ->count();

        $countData['order'] = Order::with(['orderedBy'])
            ->whereStatus($this->orderStatus)
            ->whereHas('orderedBy', fn (Builder $query) => $query->where('id', '=', auth()->id()))
            ->count();

        return view('livewire.app.backend.customer.dashboards.dashboard-index', [
            'count_data' => $countData
        ]);
    }
}
