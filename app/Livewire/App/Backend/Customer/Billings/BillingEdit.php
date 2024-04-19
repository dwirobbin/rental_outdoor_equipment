<?php

namespace App\Livewire\App\Backend\Customer\Billings;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Livewire\Forms\BillingForm;

class BillingEdit extends Component
{
    use WithFileUploads;

    public string $title = 'Unggah Bukti Bayar';
    public string $event = 'edit-billing-image';

    public BillingForm $form;

    public function render()
    {
        return view('livewire.app.backend.customer.billings.billing-edit');
    }

    #[On('set-billing-data-customer')]
    public function setData(int $id)
    {
        $this->resetValidation();

        $this->form->setData($id);
    }

    #[On('edit-billing-image')]
    public function update()
    {
        abort_if(auth()->user()->can('update', $this->form->billing), 403);

        $response = $this->form->store($this->event);

        $this->dispatch('flash-msg', text: $response['message'], type: $response['type']);

        $this->dispatch('refresh-billings', eventName: $this->event);
    }

    #[On('edit-billing-image-close')]
    public function closeModal()
    {
        $this->form->resetForm();

        $this->dispatch('refresh-billings', eventName: $this->event);

        $this->resetValidation();
    }
}
