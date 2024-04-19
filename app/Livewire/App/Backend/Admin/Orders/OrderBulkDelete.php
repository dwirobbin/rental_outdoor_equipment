<?php

namespace App\Livewire\App\Backend\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Models\Equipment;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class OrderBulkDelete extends Component
{
    public function render()
    {
        return view('livewire.app.backend.admin.orders.order-bulk-delete');
    }

    #[On('swal-confirm-delete-selected-order')]
    public function deleteConfirm(array $selectedIds)
    {
        $this->dispatch('show-confirm-delete-selected-order', selectedIds: $selectedIds, totalIds: count($selectedIds));
    }

    #[On('go-on-delete-selected-order')]
    public function deleteSelected(array $selectedIds)
    {
        $this->authorize('delete', Order::class);

        try {
            $orders = Order::whereIn('id', $selectedIds);

            foreach ($orders->get() as $order) {

                if (!is_null($order->image)) {
                    $destPathOrder = public_path('storage/image/orders/');

                    if (File::exists($destPathOrder . $order->image)) {
                        File::delete($destPathOrder . $order->image);
                    }
                }

                if (!is_null($order->billing->image)) {
                    $destPathOrder = public_path('storage/image/billings/');

                    if (File::exists($destPathOrder . $order->billing->image)) {
                        File::delete($destPathOrder . $order->billing->image);
                    }
                }

                DB::beginTransaction();

                foreach ($order->orderDetails as $item) {
                    Equipment::whereId($item->equipment_id)->increment('stock', $item->amount);
                }

                $order->orderDetails->each->delete();
                $order->messages->each->delete();
                $order->billing->delete();
                $order->delete();

                DB::commit();
            }

            $this->dispatch('flash-msg', text: 'Pesanan yang dipilih Berhasil Dihapus!', type: 'success');
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->dispatch('flash-msg', text: 'Terjadi suatu kesalahan!!', type: 'error');
        }

        $this->dispatch('clear-selected-order');
        $this->dispatch('refresh-orders');
    }
}
