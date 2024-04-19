<?php

namespace App\Livewire\App\Backend\Admin\Orders;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;

class OrderChat extends Component
{
    public string $title = 'Admin Chat Pesanan';
    public string $event = 'admin-chat-order';

    public $messages = [];

    public string $body = '';
    public ?int $id = NULL;

    public function render()
    {
        if (!is_null($this->id)) {
            $this->messages = Message::query()
                ->with(['order', 'user'])
                ->whereOrderId($this->id)
                ->get();
        }

        return view('livewire.app.backend.admin.orders.order-chat');
    }

    #[On('set-admin-chat-order-data')]
    public function setData($id)
    {
        $this->id = $id;

        $this->messages = Message::query()
            ->with(['order', 'user'])
            ->whereOrderId($id)
            ->get();
    }

    public function rules()
    {
        return [
            'body' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => ':attribute wajib diisi.',
            '*.string' => ':attribute harus sesuai berupa string.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'body' => 'Isi Pesan',
        ];
    }

    public function saveMessage()
    {
        $this->authorize('create', Order::class);

        $validatedData = $this->validate();

        $message = Message::create([
            'user_id' => auth()->id(),
            'order_id' => $this->id,
            'body' => $validatedData['body'],
            'seen' => true,
        ]);

        if ($message->wasRecentlyCreated) {
            $this->reset('body');
            $this->resetValidation();

            $this->dispatch('flash-msg', text: 'Pesan terkirim', type: 'success');
        } else {
            $this->dispatch('flash-msg', text: 'Terjadi suatu kesalahan!!', type: 'error');
        }

        $this->dispatch('scroll-down');
    }
}
