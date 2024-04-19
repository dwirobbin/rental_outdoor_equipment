<?php

namespace App\Livewire\App\Backend\Admin\PaymentMethods;

use App\Models\PaymentMethod;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.backend-app')]
#[Title('Metode Pembayaran')]

class PaymentMethodIndex extends Component
{
    public function render()
    {
        $this->authorize('viewAny', PaymentMethod::class);

        return view('livewire.app.backend.admin.payment-methods.payment-method-index');
    }
}
