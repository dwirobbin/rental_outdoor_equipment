<?php

namespace App\Livewire\App\Backend\Admin\Orders;

use Carbon\Carbon;
use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Exports\OrderExport;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Excel as MaatwebsiteExcel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsite\Excel\Facades\Excel as MaatwebsiteFacadeExcel;

class OrderTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 5;

    #[Url]
    public string $search = '';

    public string $sortColumn = 'order_code', $sortDirection = 'desc';

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

    #[On('refresh-orders')]
    public function render()
    {
        $this->authorize('viewAny', Order::class);

        $data = Order::query()
            ->with('messages')
            ->selectRaw("
                orders.*, SUM(order_details.amount) AS amount
            ")
            ->join('users', 'orders.ordered_by', '=', 'users.id')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->search(trim($this->search))
            ->groupBy('order_details.order_id')
            ->orderBy('created_at', $this->sortDirection)
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage)
            ->onEachSide(1);

        foreach ($data as $item) {
            if ($item?->end_date->isToday() && $item->status === 'paid') {
                Order::whereId($item->id)->update(['status' => 'passed']);
            }

            if ($item?->end_date->lt(Carbon::now()->format('Y-m-d')) && $item?->billing?->due_date->lt(Carbon::now()->format('Y-m-d'))) {
                Order::whereId($item->id)->update([
                    'penalty' => $item->billing->total *= $item->end_date->diffInDays(now()),
                    'status' => 'cancelled',
                ]);
            }
        }

        $this->bulkSelectedDisabled = count($this->bulkSelected) < 2;

        $paginator = Order::paginate($this->perPage);

        ($paginator->currentPage() <= $paginator->lastPage())
            ? $this->setPage($paginator->currentPage())
            : $this->setPage($paginator->lastPage());

        return view('livewire.app.backend.admin.orders.order-table', [
            'orders' => $data,
        ]);
    }

    private function getDataOnCurrentPage(): array
    {
        return Order::query()
            ->selectRaw("
                orders.*, SUM(order_details.amount) AS amount
            ")
            ->join('users', 'orders.ordered_by', '=', 'users.id')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->groupBy('order_details.order_id')
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

    #[On('clear-selected-order')]
    public function clearSelected(): void
    {
        $this->bulkSelected = [];
        $this->bulkSelectAll = false;
    }

    #[On('confirm-delete-selected-order')]
    public function deleteSelected(): void
    {
        $this->dispatch('swal-confirm-delete-selected-order', selectedIds: $this->bulkSelected);
    }

    #[On('go-on-export-to-excel-selected')]
    public function exportToExcel(): BinaryFileResponse
    {
        $this->authorize('viewAny', Order::class);

        $response = MaatwebsiteFacadeExcel::download(
            new OrderExport($this->bulkSelected, $this->sortColumn, $this->sortDirection),
            'list-pesanan.xlsx',
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
