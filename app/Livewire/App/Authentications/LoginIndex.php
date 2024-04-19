<?php

namespace App\Livewire\App\Authentications;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\{Layout, Title};
use Illuminate\Support\Facades\Validator;

#[Layout('layouts.auth-app')]
#[Title('Masuk')]

class LoginIndex extends Component
{
    public ?string $loginId = NULL;
    public ?string $password = NULL;

    public ?string $returnUrl = NULL;

    public function mount(): void
    {
        $this->returnUrl = request()->get('return-url');
    }

    public function render()
    {
        return view('livewire.app.authentications.login-index');
    }

    public function loginHandler()
    {
        $fieldType = filter_var($this->loginId, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (empty($this->loginId)) {
            $rules = ['login_id'   => 'required', 'password'  => 'required'];
            $messages = [
                'required'  => ':attribute wajib diisi.',
                'exists'    => ':attribute belum terdaftar.',
            ];
            $attrs = ['login_id'   => 'Alamat Email atau Username', 'password'  => 'Kata Sandi'];
        } else if ($fieldType === 'email') {
            $rules = [
                'login_id'   => 'required|email|exists:users,email',
                'password'  => 'required',
            ];
            $messages = [
                'required'  => ':attribute wajib diisi.',
                'email'     => ':attribute tidak valid.',
                'exists'    => ':attribute belum terdaftar.',
            ];
            $attrs = ['login_id'   => 'Alamat Email', 'password'  => 'Kata Sandi'];
        } else if ($fieldType === 'username') {
            $rules = [
                'login_id'   => 'required|exists:users,username',
                'password'  => 'required',
            ];
            $messages = [
                'required'  => ':attribute wajib diisi.',
                'exists'    => ':attribute belum terdaftar.',
            ];
            $attrs = ['login_id'   => 'Username', 'password'  => 'Kata Sandi'];
        }

        $validatedData = Validator::make(
            [
                'login_id' => $this->loginId,
                'password' => $this->password,
            ],
            $rules,
            $messages,
            $attrs,
        )->validate();

        $credential = [
            $fieldType => $validatedData['login_id'],
            'password' => $validatedData['password'],
        ];

        if (auth()->attempt($credential)) {

            $user = User::where($fieldType, '=', $validatedData['login_id'])->first();

            if ($user->is_active) {
                if (!is_null($this->returnUrl)) {
                    return $this->redirect($this->returnUrl);
                }

                $route = $user->role->name == 'admin'
                    ? 'admin_area.dashboard'
                    : 'home';


                return $this->redirectRoute($route);
            }

            auth()->logout();
            session()->flash('message', [
                'text' => 'Akun anda telah dinonaktifkan!!',
                'type' => 'danger'
            ]);
        } else {
            session()->flash('message', [
                'text' => 'Gagal Masuk!!',
                'type' => 'danger'
            ]);
        }

        $this->reset();
        $this->resetValidation();
        $this->dispatch('remove-alert');
    }
}
