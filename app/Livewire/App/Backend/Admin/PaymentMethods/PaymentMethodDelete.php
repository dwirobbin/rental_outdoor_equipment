<?php

namespace App\Livewire\App\Backend\Admin\PaymentMethods;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PaymentMethod;

class PaymentMethodDelete extends Component
{
    public function render()
    {
        return view('livewire.app.backend.admin.payment-methods.payment-method-delete');
    }

    #[On('go-on-delete-paymentMethod')]
    public function delete(int $paymentMethodId)
    {
        $this->authorize('delete', PaymentMethod::class);

        try {
            PaymentMethod::findOrFail($paymentMethodId)->delete();

            $this->dispatch('flash-msg', text: 'Metode Pembayaran Berhasil Dihapus!', type: 'success');
        } catch (\Exception $exception) {
            $this->dispatch('flash-msg', text: 'Terjadi Suatu Kesalahan!!', type: 'error');
        }

        $this->dispatch('refresh-paymentMethods');
    }
}
