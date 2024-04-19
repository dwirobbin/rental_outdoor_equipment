<?php

namespace App\Livewire\App\Backend\Admin\Billings;

use App\Models\Billing;
use Livewire\Component;
use App\Models\Equipment;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BillingDelete extends Component
{
    public function render()
    {
        return view('livewire.app.backend.admin.billings.billing-delete');
    }

    #[On('go-on-delete-bill')]
    public function delete(int $billingId)
    {
        $this->authorize('delete', Billing::class);

        try {
            $bill = Billing::findOrFail($billingId);

            if (!is_null($bill->image)) {
                $destination = public_path('storage/image/billings/');

                if (File::exists($destination . $bill->image)) {
                    File::delete($destination . $bill->image);
                }
            }

            DB::beginTransaction();

            $bill->order->orderDetails->each->delete();
            $bill->order->messages->each->delete();

            $order = $bill->order;

            if (!is_null($order->image)) {
                $destination = public_path('storage/image/orders/');

                if (File::exists($destination . $order->image)) {
                    File::delete($destination . $order->image);
                }
            }

            foreach ($bill->order->orderDetails as $item) {
                Equipment::whereId($item->equipment_id)->increment('stock', $item->amount);
            }

            $bill->delete();
            $order->delete();

            DB::commit();

            $this->dispatch('flash-msg', text: 'Data Tagihan Berhasil Dihapus!', type: 'success');
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->dispatch('flash-msg', text: 'Terjadi suatu kesalahan!!', type: 'danger');
        }

        $this->dispatch('refresh-billings');
    }
}
