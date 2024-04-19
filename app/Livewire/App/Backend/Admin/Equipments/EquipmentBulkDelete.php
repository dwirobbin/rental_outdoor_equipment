<?php

namespace App\Livewire\App\Backend\Admin\Equipments;

use Livewire\Component;
use App\Models\Equipment;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\File;

class EquipmentBulkDelete extends Component
{
    public function render()
    {
        return view('livewire.app.backend.admin.equipments.equipment-bulk-delete');
    }

    #[On('swal-confirm-delete-selected-equipment')]
    public function deleteConfirm(array $selectedIds)
    {
        $this->dispatch('show-confirm-delete-selected-equipment', selectedIds: $selectedIds, totalIds: count($selectedIds));
    }

    #[On('go-on-delete-selected-equipment')]
    public function deleteSelected(array $selectedIds)
    {
        $this->authorize('delete', Equipment::class);

        $equipments = Equipment::whereIn('id', $selectedIds);

        $images = [];
        foreach ($equipments->get() as $equipment) {
            if (!is_null($equipment->photo)) {
                $images[] = $equipment->photo;
            }
        }

        $isSuccess = false;

        try {
            $equipments->delete();

            $isSuccess = true;

            $this->dispatch('flash-msg', text: 'Peralatan yang dipilih Berhasil Dihapus!', type: 'success');
        } catch (\Exception $exception) {
            $this->dispatch('flash-msg', text: 'Beberapa alat terikat dengan data pesanan, hapus terlebih dahulu!!', type: 'error');
        }

        if ($isSuccess) {
            foreach ($images as $item) {
                $destination = public_path('storage/image/equipments/');

                if (File::exists($destination . $item)) {
                    File::delete($destination . $item);
                }
            }
        }

        $this->dispatch('clear-selected-equipment');
        $this->dispatch('refresh-equipments');
    }
}
