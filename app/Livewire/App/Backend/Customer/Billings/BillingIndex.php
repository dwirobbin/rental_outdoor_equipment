<?php

namespace App\Livewire\App\Backend\Customer\Billings;

use App\Models\Billing;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.backend-app')]
#[Title('Tagihan')]

class BillingIndex extends Component
{
    public function render()
    {
        abort_if(auth()->user()->can('viewAny', Billing::class), 403);

        return view('livewire.app.backend.customer.billings.billing-index');
    }
}
