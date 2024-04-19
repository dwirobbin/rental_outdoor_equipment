<?php

namespace App\Livewire\App\Backend\Admin\Billings;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Forms\BillingForm;

class BillingEdit extends Component
{
    public string $title = 'Edit Status Tagihan';
    public string $event = 'edit-billing-status';

    public BillingForm $form;

    public function render()
    {
        return view('livewire.app.backend.admin.billings.billing-edit');
    }

    #[On('set-billing-data')]
    public function setData(int $id)
    {
        $this->resetValidation();

        $this->form->setData($id);
    }

    #[On('edit-billing-status')]
    public function update()
    {
        $this->authorize('update', $this->form->billing);

        $response = $this->form->store($this->event);

        $this->dispatch('flash-msg', text: $response['message'], type: $response['type']);

        $this->dispatch('refresh-billings', eventName: $this->event);
    }

    #[On('edit-billing-status-close')]
    public function closeModal()
    {
        $this->form->resetForm();

        $this->dispatch('refresh-billings', eventName: $this->event);

        $this->resetValidation();
    }
}
