<?php

namespace App\Livewire\App\Backend\Customer\UserManagements;

use App\Models\User;
use Livewire\Component;
use App\Exports\UserExport;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Excel as MaatwebsiteExcel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsite\Excel\Facades\Excel as MaatwebsiteFacadeExcel;

class UserManagementTable extends Component
{
    public string $sortDirection = 'desc';

    public bool $bulkSelectedDisabled = false, $bulkSelectAll = false;
    public array $bulkSelected = [];

    public function placeholder(): View
    {
        return view('components.spinner');
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

    #[On('refresh-users')]
    public function render()
    {
        abort_if(auth()->user()->can('viewAny', User::class), 403);

        $data = User::query()
            ->select(['users.*'])
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', auth()->id())
            ->orderBy('created_at', $this->sortDirection)
            ->first();

        $this->bulkSelectedDisabled = count($this->bulkSelected) < 1;

        return view('livewire.app.backend.customer.user-managements.user-management-table', [
            'userManagement' => $data,
        ]);
    }

    private function getDataOnCurrentPage(): array
    {
        return User::query()
            ->select(['users.*'])
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', auth()->id())
            ->orderBy('created_at', $this->sortDirection)
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
        abort_if(auth()->user()->can('viewAny', User::class), 403);

        $response = MaatwebsiteFacadeExcel::download(
            new UserExport($this->bulkSelected, $this->sortColumn, $this->sortDirection),
            'user.xlsx',
            MaatwebsiteExcel::XLSX
        );

        if ($response->isSuccessful()) {
            $this->clearSelected();
        }

        return $response;
    }
}
