<?php

namespace App\Livewire\App\Backend\Admin\Equipments;

use Livewire\Component;
use App\Models\Equipment;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\File;

class EquipmentDelete extends Component
{
    public function render()
    {
        return view('livewire.app.backend.admin.equipments.equipment-delete');
    }

    #[On('go-on-delete-equipment')]
    public function delete(int $equipmentId)
    {
        $this->authorize('delete', Equipment::class);

        $isSuccess = false;

        try {
            $equipment = Equipment::findOrFail($equipmentId);

            $image = $equipment->photo ?? '';

            $isSuccess = true;

            $equipment->delete();

            $this->dispatch('flash-msg', text: 'Peralatan Berhasil Dihapus!', type: 'success');
        } catch (\Exception $exception) {
            $this->dispatch('flash-msg', text: 'Produk masih terikat dengan data pesanan, hapus terlebih dahulu!!', type: 'error');
        }

        if ($isSuccess) {
            $dest = public_path('storage/image/equipments/');

            if (File::exists($dest . $image)) {
                File::delete($dest . $image);
            }
        }

        $this->dispatch('refresh-equipments');
    }
}
