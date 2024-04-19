<?php

namespace App\Livewire\App\Backend\Admin\Billings;

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
        $this->authorize('viewAny', Billing::class);

        return view('livewire.app.backend.admin.billings.billing-index');
    }
}
