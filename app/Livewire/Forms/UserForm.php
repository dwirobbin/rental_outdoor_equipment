<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Form;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule as ValidationRule;

class UserForm extends Form
{
    private ?string $mode = NULL;

    public ?User $user = NULL;

    public ?string $name = NULL;
    public ?string $username = NULL;
    public ?string $email = NULL;
    public ?string $current_password = NULL;
    public ?string $password = NULL;
    public ?string $password_confirmation = NULL;
    public object|string|null $photo = NULL, $new_photo = NULL;
    public ?string $role = NULL;
    public ?bool $is_active = false;

    private ?array $response = NULL;
    private ?string $message = NULL;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'username' => ['required', 'string', 'min:3'],
            'email' => [
                'required', 'email', 'min:5',
                ValidationRule::when(is_null($this->user), [ValidationRule::unique('users', 'email')]),
                ValidationRule::when(!is_null($this->user), [ValidationRule::unique('users', 'email')->ignore($this->user?->id, 'id')]),
            ],
            'current_password' => [
                'nullable',
                ValidationRule::when(!is_null($this->user), [
                    ValidationRule::requiredIf(!is_null($this->password)),
                    'min:5', function (string $attribute, mixed $value, Closure $fail) {
                        if (!Hash::check($value, User::find($this->user->id)->password)) {
                            $fail(__(':attribute tidak sesuai dengan kata sandi yang anda berikan.'));
                        }
                    },
                ])
            ],
            'password' => [
                ValidationRule::when($this->mode === 'create-user' || $this->mode === 'register', ['required', 'min:5', 'confirmed']),
                ValidationRule::when(!is_null($this->user), [
                    ValidationRule::requiredIf(!is_null($this->current_password)),
                    function (string $attribute, mixed $value, Closure $fail) {
                        if (!is_null($this->current_password) && strcmp($this->current_password, $value) == 0) {
                            $fail(__(':attribute tidak boleh sama dengan kata sandi lama.'));
                        }
                    }
                ]),
            ],
            'password_confirmation' => [
                ValidationRule::when(is_null($this->user) && ($this->mode === 'create-user' || $this->mode === 'register'), ['required', 'min:5', 'exclude'])
            ],
            'photo' => [
                'nullable',
                ValidationRule::when($this->mode === 'create-user', [
                    'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:2048',
                    ValidationRule::unique('users', 'photo')
                ]),
            ],
            'new_photo' => [
                'nullable',
                ValidationRule::when($this->mode === 'edit-user', [
                    'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:2048',
                    ValidationRule::unique('users', 'photo')->ignore($this->user?->id, 'id')
                ]),
            ],
            'role' => [
                'nullable',
                ValidationRule::when($this->mode === 'create-user' || $this->mode === 'edit-user', [
                    'required', 'in:admin,customer'
                ]),
            ],
            'is_active' => [
                'nullable',
                ValidationRule::when($this->mode === 'create-user' || $this->mode === 'edit-user', [
                    'required', 'boolean'
                ]),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => ':attribute wajib diisi.',
            '*.string' => ':attribute harus berupa string.',
            '*.min' => ':attribute minimal harus berisi :min karakter.',
            '*.max' => 'Maksimal ukuran :attribute 2 MB..',
            'email' => ':attribute tidak valid.',
            '*.unique' => ':attribute sudah digunakan.',
            'password.confirmed' => 'Password Konfirmasi tidak sama.',
            '*.image' => ':attribute harus berupa gambar.',
            '*.mimes' => ':attribute harus berformat :values.',
            '*.in' => ':attribute harus berupa salah satu dari tipe berikut: :values.'
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'name' => 'Nama',
            'username' => 'Username',
            'email' => 'Email',
            'current_password' => 'Kata Sandi Saat ini',
            'password' => 'Kata Sandi',
            'password_confirmation' => 'Kata Sandi Konfirmasi ',
            'photo' => 'Foto Profil',
            'new_photo' => 'Foto Profil',
            'role' => 'Peran',
            'is_active' => 'Status Akun',
        ];
    }

    public function setData(int $id)
    {
        $this->user = User::findOrFail($id);

        $this->name = $this->user->name;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->photo = $this->user->photo;
        $this->role = $this->user->role_id == 1 ? 'admin' : 'customer';
        $this->is_active = $this->user->is_active;
    }

    public function store(?string $modeName = NULL): array
    {
        $this->mode = $modeName;

        $validatedData = $this->validate();

        $pathImg = 'image/users';

        try {

            if (is_null($this->user)) {

                if (!is_null($validatedData['photo'])) {
                    $imgName = $this->photo->store($pathImg, 'public');
                    $validatedData['photo'] = str_replace("$pathImg/", '', $imgName);
                }

                User::create([
                    'name' => str($validatedData['name'])->title(),
                    'username' => $validatedData['username'],
                    'email' => $validatedData['email'],
                    'password' => Hash::make($validatedData['password']),
                    'photo' => $validatedData['photo'] ?? null,
                    'role_id' => $validatedData['role'] == 'admin' ? 1 : 2,
                    'is_active' => $this->mode === 'register' ? true : $validatedData['is_active'],
                ]);

                $this->message = 'User Baru Berhasil Ditambahkan!';
            }

            if (!is_null($this->user)) {

                if (!is_null($this->new_photo)) {
                    $destination = public_path("storage/$pathImg/");

                    if (File::exists($destination . $this->photo)) {
                        File::delete($destination . $this->photo);
                    }

                    $newImg = $this->new_photo->store($pathImg, 'public');
                    $validatedData['new_photo'] = str_replace("$pathImg/", '', $newImg);
                } else {
                    $validatedData['new_photo'] = $this->photo ?: NULL;
                }

                $this->user->update([
                    'name' => str($validatedData['name'])->title(),
                    'username' => $validatedData['username'],
                    'email' => $validatedData['email'],
                    'photo' => $validatedData['new_photo'],
                    'role_id' => $validatedData['role'] == 'admin' ? 1 : 2,
                    'is_active' => $validatedData['is_active'],
                ]);

                if (!is_null($this->current_password) && !is_null($this->password)) {
                    $this->user->update([
                        'password' => Hash::make($validatedData['password']),
                    ]);
                }

                $this->message = 'Data User Berhasil Diperbaharui!';
            }

            $this->response = [
                'type' => 'success',
                'message' => $this->message,
            ];
        } catch (\Exception $exception) {
            $this->response = [
                'type' => 'error',
                'message' => 'Terjadi suatu kesalahan!!',
            ];
        }

        $this->reset();

        return $this->response;
    }

    public function resetForm()
    {
        $this->reset();
    }
}
