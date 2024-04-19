<?php

namespace App\Livewire\App\Backend\Admin\Equipments;

use App\Models\Equipment;
use App\Exports\EquipmentExport;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{On, Url};
use Livewire\{Component, WithPagination};
use Maatwebsite\Excel\Excel as MaatwebsiteExcel;
use Maatwebsite\Excel\Facades\Excel as MaatwebsiteFacadeExcel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class EquipmentTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 3;

    #[Url]
    public string $search = '';

    public string $sortColumn = 'name', $sortDirection = 'desc';

    public bool $bulkSelectedDisabled = false, $bulkSelectAll = false;
    public array $bulkSelected = [];

    public function placeholder(): View
    {
        return view('components.spinner');
    }

    public function updatedPage(): void
    {
        $this->bulkSelectAll = $this->determineBulkSelectAll($this->getDataOnCurrentPage(), $this->bulkSelected);
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();

        $this->bulkSelectAll = $this->determineBulkSelectAll($this->getDataOnCurrentPage(), $this->bulkSelected);

        if ($this->determineBulkSelectAll($this->getDataOnCurrentPage(), $this->bulkSelected)) {
            $this->bulkSelected = array_keys(array_flip(array_merge($this->bulkSelected, $this->getDataOnCurrentPage())));
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedBulkSelectAll(): void
    {
        $this->bulkSelected = $this->determineBulkSelectAll($this->getDataOnCurrentPage(), $this->bulkSelected)
            ? array_keys(array_flip(array_diff($this->bulkSelected, $this->getDataOnCurrentPage())))
            : array_keys(array_flip(array_merge($this->bulkSelected, $this->getDataOnCurrentPage())));
    }

    public function updatedBulkSelected(): void
    {
        $this->bulkSelectAll = $this->determineBulkSelectAll($this->getDataOnCurrentPage(), $this->bulkSelected);
    }

    public function paginationView(): string
    {
        return 'paginations.custom-pagination-links';
    }

    #[On('refresh-equipments')]
    public function render()
    {
        $this->authorize('viewAny', Equipment::class);

        $data = Equipment::query()
            ->search(trim($this->search))
            ->orderBy('created_at', $this->sortDirection)
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage)
            ->onEachSide(1);

        $this->bulkSelectedDisabled = count($this->bulkSelected) < 2;

        $paginator = Equipment::paginate($this->perPage);

        ($paginator->currentPage() <= $paginator->lastPage())
            ? $this->setPage($paginator->currentPage())
            : $this->setPage($paginator->lastPage());

        return view('livewire.app.backend.admin.equipments.equipment-table', [
            'equipments' => $data,
        ]);
    }

    private function getDataOnCurrentPage(): array
    {
        return Equipment::query()
            ->orderBy('created_at', $this->sortDirection)
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage)
            ->pluck('id')
            ->toArray();
    }

    private function determineBulkSelectAll(array $dataOnCurrentPage, array $bulkSelected): bool
    {
        return empty(array_diff($dataOnCurrentPage, $bulkSelected));
    }

    #[On('clear-selected-equipment')]
    public function clearSelected(): void
    {
        $this->bulkSelected = [];
        $this->bulkSelectAll = false;
    }

    #[On('confirm-delete-selected-equipment')]
    public function deleteSelected(): void
    {
        $this->dispatch('swal-confirm-delete-selected-equipment', selectedIds: $this->bulkSelected);
    }

    #[On('go-on-export-to-excel-selected')]
    public function exportToExcel(): BinaryFileResponse
    {
        $this->authorize('viewAny', Equipment::class);

        $response = MaatwebsiteFacadeExcel::download(
            new EquipmentExport($this->bulkSelected, $this->sortColumn, $this->sortDirection),
            'list-peralatan.xlsx',
            MaatwebsiteExcel::XLSX
        );

        if ($response->isSuccessful()) {
            $this->clearSelected();
            $this->resetPage();
        }

        return $response;
    }

    #[On('sort')]
    public function sort(string $columnName): void
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'desc' ? 'asc' : 'desc';

        $this->bulkSelectAll = $this->determineBulkSelectAll($this->getDataOnCurrentPage(), $this->bulkSelected);
    }
}
