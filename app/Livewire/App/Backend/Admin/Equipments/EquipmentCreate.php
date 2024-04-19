<?php

namespace App\Livewire\App\Backend\Admin\Equipments;

use Livewire\Component;
use App\Models\Equipment;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Livewire\Forms\EquipmentForm;

class EquipmentCreate extends Component
{
    use WithFileUploads;

    public string $title = 'Tambah Peralatan';
    public string $event = 'create-equipment';

    public EquipmentForm $form;

    public function render()
    {
        return view('livewire.app.backend.admin.equipments.equipment-create');
    }

    #[On('create-equipment')]
    public function save()
    {
        $this->authorize('create', Equipment::class);

        $response = $this->form->store();

        $this->dispatch('flash-msg', text: $response['message'], type: $response['type']);

        $this->dispatch('refresh-equipments', eventName: $this->event);
    }

    #[On('create-equipment-close')]
    public function closeModal()
    {
        $this->form->resetForm();

        $this->dispatch('refresh-equipments', eventName: $this->event);

        $this->resetValidation();
    }
}
