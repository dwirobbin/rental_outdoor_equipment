<?php

namespace App\Livewire\App\Backend\Admin\UserManagements;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\File;

class UserManagementBulkDelete extends Component
{
    public function render()
    {
        return view('livewire.app.backend.admin.user-managements.user-management-bulk-delete');
    }

    #[On('swal-confirm-delete-selected-user')]
    public function deleteConfirm(array $selectedIds)
    {
        $this->dispatch('show-confirm-delete-selected-user', selectedIds: $selectedIds, totalIds: count($selectedIds));
    }

    #[On('go-on-delete-selected-user')]
    public function deleteSelected(array $selectedIds)
    {
        $this->authorize('delete', User::class);

        $users = User::whereIn('id', $selectedIds);

        $images = [];
        foreach ($users->get() as $user) {
            if (!is_null($user->photo)) {
                $images[] = $user->photo;
            }
        }

        $isSuccess = false;

        try {
            $users->delete();

            $isSuccess = true;

            $this->dispatch('flash-msg', text: 'Akun User yang dipilih Berhasil Dihapus!', type: 'success');
        } catch (\Exception $exception) {
            $this->dispatch('flash-msg', text: 'Beberapa akun mempunyai data tagihan dan pesanan, hapus terlebih dahulu!!', type: 'error');
        }

        if ($isSuccess) {
            foreach ($images as $item) {
                $destination = public_path('storage/image/users/');

                if (File::exists($destination . $item)) {
                    File::delete($destination . $item);
                }
            }
        }

        $this->dispatch('clear-selected-user');
        $this->dispatch('refresh-users');
    }
}
