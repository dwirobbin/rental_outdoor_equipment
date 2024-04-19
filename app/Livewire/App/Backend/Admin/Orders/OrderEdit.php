<?php

namespace App\Livewire\App\Backend\Admin\Orders;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Forms\OrderForm;

class OrderEdit extends Component
{
    public string $title = 'Edit Status Pesanan';
    public string $event = 'edit-order-status';

    public OrderForm $form;

    public function render()
    {
        return view('livewire.app.backend.admin.orders.order-edit');
    }

    #[On('set-order-data')]
    public function setData(int $id)
    {
        $this->resetValidation();

        $this->form->setData($id);
    }

    #[On('edit-order-status')]
    public function update()
    {
        $this->authorize('update', $this->form->order);

        $response = $this->form->store($this->event);

        $this->dispatch('flash-msg', text: $response['message'], type: $response['type']);

        $this->dispatch('refresh-orders', eventName: $this->event);
    }

    #[On('edit-order-status-close')]
    public function closeModal()
    {
        $this->form->resetForm();

        $this->dispatch('refresh-orders', eventName: $this->event);

        $this->resetValidation();
    }
}
