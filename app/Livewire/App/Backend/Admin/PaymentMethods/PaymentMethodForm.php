<?php

namespace App\Livewire\App\Backend\Admin\PaymentMethods;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PaymentMethod;
use Livewire\WithFileUploads;
use App\Livewire\Forms\PaymentMethodForm as FormsPaymentMethodForm;

class PaymentMethodForm extends Component
{
    use WithFileUploads;

    public bool $isUpdate = false;

    public FormsPaymentMethodForm $form;

    public function render()
    {
        return view('livewire.app.backend.admin.payment-methods.payment-method-form');
    }

    public function store()
    {
        $this->authorize('create', PaymentMethod::class);

        $response = $this->form->store();

        $this->dispatch('flash-msg', text: $response['message'], type: $response['type']);

        $this->dispatch('refresh-paymentMethods');
    }

    #[On('set-paymentMethod-data')]
    public function edit(int $id)
    {
        $this->form->setData($id);

        $this->isUpdate = true;
    }

    public function update()
    {
        $this->authorize('update', $this->form->paymentMethod);

        $response = $this->form->store();

        $this->isUpdate = false;

        $this->dispatch('flash-msg', text: $response['message'], type: $response['type']);

        $this->dispatch('refresh-paymentMethods');
    }

    public function resetForm()
    {
        $this->form->resetForm();

        $this->isUpdate = false;

        $this->dispatch('refresh-paymentMethods');

        $this->resetValidation();
    }
}
