<?php

namespace App\Livewire\App\Backend\Admin\Billings;

use App\Models\Billing;
use Livewire\Component;
use App\Models\Equipment;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BillingBulkDelete extends Component
{
    public function render()
    {
        return view('livewire.app.backend.admin.billings.billing-bulk-delete');
    }

    #[On('swal-confirm-delete-selected-billing')]
    public function deleteConfirm(array $selectedIds)
    {
        $this->dispatch('show-confirm-delete-selected-billing', selectedIds: $selectedIds, totalIds: count($selectedIds));
    }

    #[On('go-on-delete-selected-billing')]
    public function deleteSelected(array $selectedIds)
    {
        $this->authorize('delete', Billing::class);

        try {
            $billings = Billing::whereIn('id', $selectedIds);

            foreach ($billings->get() as $billing) {

                if (!is_null($billing->image)) {
                    $destPathBill = public_path('storage/image/billings/');

                    if (File::exists($destPathBill . $billing->image)) {
                        File::delete($destPathBill . $billing->image);
                    }
                }

                if (!is_null($billing->order->image)) {
                    $destPathOrder = public_path('storage/image/orders/');

                    if (File::exists($destPathOrder . $billing->order->image)) {
                        File::delete($destPathOrder . $billing->order->image);
                    }
                }

                DB::beginTransaction();

                foreach ($billing->order->orderDetails as $item) {
                    Equipment::whereId($item->equipment_id)->increment('stock', $item->amount);
                }

                $billing->order->orderDetails->each->delete();
                $billing->order->messages->each->delete();
                $billing->delete();
                $billing->order->delete();

                DB::commit();
            }

            $this->dispatch('flash-msg', text: 'Tagihan yang dipilih Berhasil Dihapus!', type: 'success');
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->dispatch('flash-msg', text: 'Terjadi suatu kesalahan!!', type: 'error');
        }

        $this->dispatch('clear-selected-billing');
        $this->dispatch('refresh-billings');
    }
}
