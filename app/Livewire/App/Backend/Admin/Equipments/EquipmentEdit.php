<?php

namespace App\Livewire\App\Backend\Admin\Equipments;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Livewire\Forms\EquipmentForm;

class EquipmentEdit extends Component
{
    use WithFileUploads;

    public string $title = 'Edit Peralatan';
    public string $event = 'edit-equipment';

    public EquipmentForm $form;

    public function render()
    {
        return view('livewire.app.backend.admin.equipments.equipment-edit');
    }

    #[On('set-equipment-data')]
    public function setData(int $id)
    {
        $this->resetValidation();

        $this->form->setData($id);
    }

    #[On('edit-equipment')]
    public function update()
    {
        $this->authorize('update', $this->form->equipment);

        $response = $this->form->store();

        $this->dispatch('flash-msg', text: $response['message'], type: $response['type']);

        $this->dispatch('refresh-equipments', eventName: $this->event);
    }

    #[On('edit-equipment-close')]
    public function closeModal()
    {
        $this->form->resetForm();

        $this->dispatch('refresh-equipments', eventName: $this->event);

        $this->resetValidation();
    }
}
