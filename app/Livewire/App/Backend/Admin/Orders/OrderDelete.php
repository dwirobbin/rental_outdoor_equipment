<?php

namespace App\Livewire\App\Backend\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Models\Equipment;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class OrderDelete extends Component
{
    public function render()
    {
        return view('livewire.app.backend.admin.orders.order-delete');
    }

    #[On('go-on-delete-order')]
    public function delete(int $orderId)
    {
        $this->authorize('delete', Order::class);


        try {
            $order = Order::findOrFail($orderId);

            if (!is_null($order->image)) {
                $destOrderImg = public_path('storage/image/orders/');

                if (File::exists($destOrderImg . $order->image)) {
                    File::delete($destOrderImg . $order->image);
                }
            }

            $bill = $order->billing;

            if (!is_null($bill->image)) {
                $destBillingImg = public_path('storage/image/billings/');

                if (File::exists($destBillingImg . $bill->image)) {
                    File::delete($destBillingImg . $bill->image);
                }
            }

            DB::beginTransaction();

            foreach ($order->orderDetails as $item) {
                Equipment::whereId($item->equipment_id)->increment('stock', $item->amount);
            }

            $order->orderDetails->each->delete();
            $order->messages->each->delete();
            $bill->delete();
            $order->delete();

            DB::commit();

            $this->dispatch('flash-msg', text: 'Data Pesanan Berhasil Dihapus!', type: 'success');
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->dispatch('flash-msg', text: 'Terjadi suatu kesalahan!!', type: 'error');
        }

        $this->dispatch('refresh-orders');
    }
}
