<?php

namespace App\Livewire\App\Backend\Customer\Billings;

use Carbon\Carbon;
use App\Models\Billing;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Exports\BillingExport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Excel as MaatwebsiteExcel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsite\Excel\Facades\Excel as MaatwebsiteFacadeExcel;

class BillingTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 5;

    #[Url]
    public string $search = '';

    public string $sortColumn = 'orders.order_code', $sortDirection = 'desc';

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

    #[On('refresh-billings')]
    public function render()
    {
        abort_if(auth()->user()->can('viewAny', Billing::class), 403);

        $data = Billing::query()
            ->select(['billings.*'])
            ->join('orders', 'billings.order_id', '=', 'orders.id')
            ->join('users', 'orders.ordered_by', '=', 'users.id')
            ->where('orders.ordered_by', '=', auth()->id())
            ->search(trim($this->search))
            ->orderBy('created_at', $this->sortDirection)
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage)
            ->onEachSide(1);

        foreach ($data as $item) {
            if ($item?->due_date->isToday() && $item->status === 'unpaid') {
                Billing::whereId($item->id)->update(['status' => 'passed']);
            }

            if ($item?->due_date->lt(Carbon::now()->format('Y-m-d'))) {
                Billing::whereId($item->id)->update(['status' => 'cancelled']);
            }
        }

        $this->bulkSelectedDisabled = count($this->bulkSelected) < 2;

        $paginator = Billing::paginate($this->perPage);

        ($paginator->currentPage() <= $paginator->lastPage())
            ? $this->setPage($paginator->currentPage())
            : $this->setPage($paginator->lastPage());

        return view('livewire.app.backend.customer.billings.billing-table', [
            'billings' => $data,
        ]);
    }

    private function getDataOnCurrentPage(): array
    {
        return Billing::query()
            ->select(['billings.*'])
            ->join('orders', 'billings.order_id', '=', 'orders.id')
            ->join('users', 'orders.ordered_by', '=', 'users.id')
            ->where('orders.ordered_by', '=', auth()->id())
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

    private function clearSelected(): void
    {
        $this->bulkSelected = [];
        $this->bulkSelectAll = false;
    }

    #[On('go-on-export-to-excel-selected')]
    public function exportToExcel(): BinaryFileResponse
    {
        abort_if(auth()->user()->can('viewAny', Billing::class), 403);

        $response = MaatwebsiteFacadeExcel::download(
            new BillingExport($this->bulkSelected, $this->sortColumn, $this->sortDirection),
            'list-tagihan.xlsx',
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
