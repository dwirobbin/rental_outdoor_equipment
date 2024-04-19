<?php

namespace App\Livewire\App\Authentications\Passwords;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\{DB, Hash, Mail};
use Livewire\Component;
use Livewire\Attributes\{Layout, Title};

#[Layout('layouts.auth-app')]
#[Title('Atur Ulang Kata Sandi')]

class ResetIndex extends Component
{
    public ?string $token = null;
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(?string $token = null)
    {
        $this->token = $token;
    }

    public function render()
    {
        $checkToken = DB::table('password_reset_tokens')
            ->where('token', $this->token)
            ->first();

        if ($checkToken) {
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $checkToken->created_at)
                ->diffInMinutes(Carbon::now());

            if ($diffMins > 15) {
                session()->flash('message', [
                    'text' => 'Token kadaluarsa, kirim ulang tautan reset kata sandi!',
                    'type' => 'danger'
                ]);

                $this->redirectRoute('auth.password.forgot');

                return view('livewire.app.authentications.passwords.forgot-index');
            } else {
                return view('livewire.app.authentications.passwords.reset-index', [
                    'token' => $this->token,
                ]);
            }
        } else {
            session()->flash('message', [
                'text' => 'Token tidak valid, kirim ulang tautan reset kata sandi!',
                'type' => 'danger'
            ]);

            $this->redirectRoute('auth.password.forgot');

            return view('livewire.app.authentications.passwords.forgot-index');
        }
    }

    public function rules(): array
    {
        return [
            'password' => ['required', 'min:5', 'confirmed'],
            'password_confirmation' => ['required', 'min:5', 'exclude'],
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => ':attribute wajib diisi.',
            '*.string' => ':attribute harus berupa string.',
            '*.min' => ':attribute minimal harus berisi :min karakter.',
            '*.confirmed' => 'Password Konfirmasi tidak sama.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'password' => 'Kata Sandi',
            'password_confirmation' => 'Kata Sandi Konfirmasi ',
        ];
    }

    public function submitResetPasswordForm()
    {
        $validatedData = $this->validate();

        $token = DB::table('password_reset_tokens')
            ->where('token', $this->token)
            ->first();

        $user = User::whereEmail($token->email)->first();

        try {
            DB::transaction(function () use ($user, $validatedData) {
                User::whereEmail($user->email)->update([
                    'password' => Hash::make($validatedData['password']),
                ]);

                DB::table('password_reset_tokens')->where([
                    'email' => $user->email,
                    'token' => $this->token
                ])->delete();
            });

            Mail::send('livewire.app.authentications.passwords.email-templates.reset-password', [
                'email' => $user->email,
                'new_password' => $validatedData['password'],
            ], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Kata sandi diubah');
            });

            session()->flash('message', [
                'text' => 'Kata sandi berhasil diubah!',
                'type' => 'success'
            ]);

            $this->reset();
            $this->redirectRoute('auth.login');
        } catch (\Exception $ex) {
            $this->resetExcept('token');
            session()->flash('message', [
                'text' => 'Terjadi suatu kesalahan!!',
                'type' => 'danger'
            ]);
        }
    }
}
