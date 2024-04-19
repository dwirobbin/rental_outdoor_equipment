<?php

namespace App\Livewire\App\Frontend\Homes;

use Livewire\Component;
use App\Models\Equipment;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.frontend-app')]
#[Title('Beranda Utama')]

class HomeIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 5;

    public string $sortColumn = 'name';
    public string $sortDirection = 'desc';

    public function render()
    {
        $data = Equipment::query()
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage)
            ->onEachSide(1);

        return view('livewire.app.frontend.homes.home-index', [
            'equipments' => $data,
        ]);
    }
}
