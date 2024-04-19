<?php

namespace App\Livewire\App\Backend\Customer\Orders;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Livewire\Forms\OrderForm;

class OrderEdit extends Component
{
    use WithFileUploads;

    public string $title = 'Unggah Bukti Pengembalian';
    public string $event = 'edit-order-image';

    public OrderForm $form;

    public function render()
    {
        return view('livewire.app.backend.customer.orders.order-edit');
    }

    #[On('set-order-data-customer')]
    public function setData(int $id)
    {
        $this->resetValidation();

        $this->form->setData($id);
    }

    #[On('edit-order-image')]
    public function update()
    {
        abort_if(auth()->user()->can('update', $this->form->order), 403);

        $response = $this->form->store($this->event);

        $this->dispatch('flash-msg', text: $response['message'], type: $response['type']);

        $this->dispatch('refresh-orders', eventName: $this->event);
    }

    #[On('edit-order-image-close')]
    public function closeModal()
    {
        $this->form->resetForm();

        $this->dispatch('refresh-orders', eventName: $this->event);

        $this->resetValidation();
    }
}
