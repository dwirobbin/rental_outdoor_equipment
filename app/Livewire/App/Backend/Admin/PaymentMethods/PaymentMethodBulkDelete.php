<?php

namespace App\Livewire\App\Backend\Admin\PaymentMethods;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PaymentMethod;

class PaymentMethodBulkDelete extends Component
{
    public function render()
    {
        return view('livewire.app.backend.admin.payment-methods.payment-method-bulk-delete');
    }

    #[On('swal-confirm-delete-selected-paymentMethod')]
    public function deleteConfirm(array $selectedIds)
    {
        $this->dispatch('show-confirm-delete-selected-paymentMethod', selectedIds: $selectedIds, totalIds: count($selectedIds));
    }

    #[On('go-on-delete-selected-paymentMethod')]
    public function deleteSelected(array $selectedIds)
    {
        $this->authorize('delete', PaymentMethod::class);

        try {
            PaymentMethod::whereIn('id', $selectedIds)->delete();

            $this->dispatch('flash-msg', text: 'Metode Pembayaran yang dipilih Berhasil Dihapus!', type: 'success');
        } catch (\Exception $exception) {
            $this->dispatch('flash-msg', text: 'Terjadi Suatu Kesalahan!!', type: 'error');
        }

        $this->dispatch('clear-selected-paymentMethod');
        $this->dispatch('refresh-paymentMethods');
    }
}
