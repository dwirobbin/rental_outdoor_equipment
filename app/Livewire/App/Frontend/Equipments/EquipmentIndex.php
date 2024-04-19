<?php

namespace App\Livewire\App\Frontend\Equipments;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Equipment;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.frontend-app')]
#[Title('Peralatan')]

class EquipmentIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 5;

    public string $sortColumn = 'name';
    public string $sortDirection = 'desc';

    public ?string $currentUrl = null;

    public function mount(): void
    {
        $this->currentUrl = url()->current();
    }

    public function render()
    {
        $data = Equipment::query()
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage)
            ->onEachSide(1);

        return view('livewire.app.frontend.equipments.equipment-index', [
            'equipments' => $data,
        ]);
    }

    public function addToCart(int $id)
    {
        if (!auth()->check()) {
            session()->flash('message', [
                'text' => 'Anda harus masuk terlebih dahulu!',
                'type' => 'danger'
            ]);

            return $this->redirectRoute('auth.login', [
                'return-url' => $this->currentUrl
            ]);
        }

        $data = [
            'user_id' => auth()->id(),
            'product_id' => $id,
        ];

        Cart::updateOrCreate($data);

        $this->dispatch('refresh-cart-count');

        session()->flash('message', [
            'text' => 'Produk ditambahkan ke keranjang!',
            'type' => 'success'
        ]);
    }
}
