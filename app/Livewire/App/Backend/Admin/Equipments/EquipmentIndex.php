<?php

namespace App\Livewire\App\Backend\Admin\Equipments;

use App\Models\Equipment;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.backend-app')]
#[Title('Peralatan')]

class EquipmentIndex extends Component
{
    public function render()
    {
        $this->authorize('viewAny', Equipment::class);

        return view('livewire.app.backend.admin.equipments.equipment-index');
    }
}
