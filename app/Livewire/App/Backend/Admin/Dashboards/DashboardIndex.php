<?php

namespace App\Livewire\App\Backend\Admin\Dashboards;

use App\Models\User;
use App\Models\Order;
use App\Models\Billing;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Gate;

#[Layout('layouts.backend-app')]
#[Title('Dashboard')]

class DashboardIndex extends Component
{
    public string $billStatus = 'unpaid';
    public string $orderStatus = 'pending';

    public function render()
    {
        abort_if(Gate::denies('isAdmin'), 403);

        $countData['bill'] = Billing::whereStatus($this->billStatus)->count();

        $countData['order'] = Order::whereStatus($this->orderStatus)->count();

        $countData['user'] = User::count();

        return view('livewire.app.backend.admin.dashboards.dashboard-index', [
            'count_data' => $countData
        ]);
    }
}
