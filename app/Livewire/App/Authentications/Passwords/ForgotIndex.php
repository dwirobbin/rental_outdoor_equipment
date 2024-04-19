<?php

namespace App\Livewire\App\Authentications\Passwords;

use Livewire\Component;
use Livewire\Attributes\{Title, Layout};
use Illuminate\Support\Facades\{DB, Mail};
use Illuminate\Support\Str;
use Carbon\Carbon;

#[Layout('layouts.auth-app')]
#[Title('Lupa Kata Sandi')]

class ForgotIndex extends Component
{
    public ?string $email = null;

    public function render()
    {
        return view('livewire.app.authentications.passwords.forgot-index');
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'exists:users,email', 'min:5'],
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => ':attribute wajib diisi.',
            '*.string' => ':attribute harus berupa string.',
            '*.email' => ':attribute tidak vallid.',
            '*.min' => ':attribute minimal harus berisi :min karakter.',
            '*.exists' => ':attribute tidak ditemukan.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'email' => 'Email',
        ];
    }

    public function submitForgetPasswordForm()
    {
        $validatedData = $this->validate();

        $token = base64_encode(Str::random(64));

        DB::table('password_reset_tokens')->upsert([
            [
                'email' => $validatedData['email'],
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        ], ['email'], ['token', 'created_at']);

        Mail::send('livewire.app.authentications.passwords.email-templates.forgot-password', [
            'token' => $token,
            'email' => $validatedData['email'],
        ], function ($message) use ($validatedData) {
            $message->to($validatedData['email']);
            $message->subject('Atur Ulang Kata Sandi');
        });

        $this->reset();

        $this->redirectRoute('auth.password.confirm', ['email' => $validatedData['email']], navigate: true);
    }
}
