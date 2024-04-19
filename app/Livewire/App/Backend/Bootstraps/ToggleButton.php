<?php

namespace App\Livewire\App\Backend\Bootstraps;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class ToggleButton extends Component
{
    public Model $model;
    public string $field;

    public bool $isActive;

    public function mount()
    {
        $this->isActive = (bool) $this->model->getAttribute($this->field);
    }

    public function render()
    {
        return view('livewire.app.backend.bootstraps.toggle-button');
    }

    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field, $value)->save();

        $this->dispatch('flash-msg', text: !$this->isActive ? 'Aktif' : 'Tidak Aktif', type: 'success');
    }
}
