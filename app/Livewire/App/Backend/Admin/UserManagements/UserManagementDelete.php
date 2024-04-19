<?php

namespace App\Livewire\App\Backend\Admin\UserManagements;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\File;

class UserManagementDelete extends Component
{
    public function render()
    {
        return view('livewire.app.backend.admin.user-managements.user-management-delete');
    }

    #[On('go-on-delete-user')]
    public function delete(int $userId)
    {
        $this->authorize('delete', User::class);

        $isSuccess = false;

        try {
            $user = User::findOrFail($userId);

            $image = $user->photo ?? '';

            $user->delete();

            $isSuccess = true;

            $this->dispatch('flash-msg', text: 'Akun User Berhasil Dihapus!', type: 'success');
        } catch (\Exception $exception) {
            $this->dispatch('flash-msg', text: 'Akun mempunyai data tagihan dan pesanan, Hapus terlebih dahulu!', type: 'error');
        }

        if ($isSuccess) {
            $destination = public_path('storage/image/users/');

            if (File::exists($destination . $image)) {
                File::delete($destination . $image);
            }
        }

        $this->dispatch('refresh-users');
    }
}
