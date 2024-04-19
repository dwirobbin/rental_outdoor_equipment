<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\PaymentMethod;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule as ValidationRule;

class PaymentMethodForm extends Form
{
    public ?PaymentMethod $paymentMethod = NULL;

    public ?string $name = NULL;
    public ?string $number = NULL;
    public object|string|null $photo = NULL;
    public object|string|null $new_photo = NULL;

    private ?array $response = NULL;
    private ?string $message = NULL;

    public function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'min:3',
                ValidationRule::when(is_null($this->paymentMethod), [
                    ValidationRule::unique('payment_methods', 'name')
                ]),
                ValidationRule::when(!is_null($this->paymentMethod), [
                    ValidationRule::unique('payment_methods', 'name')->ignore($this->paymentMethod?->id, 'id')
                ]),
            ],
            'number' => [
                'required',
                ValidationRule::when(is_null($this->paymentMethod), [
                    ValidationRule::unique('payment_methods', 'number')
                ]),
                ValidationRule::when(!is_null($this->paymentMethod), [
                    ValidationRule::unique('payment_methods', 'number')->ignore($this->paymentMethod?->id, 'id')
                ]),
            ],
            'photo' => [
                ValidationRule::requiredIf(is_null($this->paymentMethod)),
                ValidationRule::when(is_null($this->paymentMethod), [
                    'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:2048',
                    ValidationRule::unique('payment_methods', 'photo')
                ]),
            ],
            'new_photo' => [
                ValidationRule::requiredIf(!is_null($this->paymentMethod) && !is_null($this->new_photo)),
                ValidationRule::when(!is_null($this->paymentMethod) && !is_null($this->new_photo), [
                    'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:2048',
                    ValidationRule::unique('payment_methods', 'photo')->ignore($this->paymentMethod?->id, 'id')
                ]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => ':attribute wajib diisi.',
            '*.string' => ':attribute harus berupa string.',
            '*.min' => ':attribute minimal harus berisi :min karakter.',
            '*.max' => 'Maksimal ukuran :attribute 2 MB..',
            '*.unique' => ':attribute sudah digunakan.',
            '*.image' => ':attribute harus berupa gambar.',
            '*.mimes' => ':attribute harus berformat :values.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'name' => 'Nama',
            'number' => 'Nomor',
            'photo' => 'Foto',
            'new_photo' => 'Foto',
        ];
    }

    public function setData(int $id)
    {
        $this->paymentMethod = PaymentMethod::findOrFail($id);

        $this->name = $this->paymentMethod->name;
        $this->number = $this->paymentMethod->number;
        $this->photo = $this->paymentMethod->photo;
    }

    public function store(): array
    {
        $validatedData = $this->validate();

        $pathImg = 'image/payment-methods';

        try {

            if (is_null($this->paymentMethod)) {

                if (!is_null($validatedData['photo'])) {
                    $imageName = $this->photo->store($pathImg, 'public');
                    $validatedData['photo'] = str_replace("$pathImg/", '', $imageName);
                }

                PaymentMethod::create([
                    'name' => str($validatedData['name'])->title(),
                    'number' => $validatedData['number'],
                    'photo' => $validatedData['photo'],
                ]);

                $this->message = 'Metode Pembayaran Berhasil Ditambahkan!.';
            }

            if (!is_null($this->paymentMethod)) {

                if (!is_null($this->new_photo)) {
                    $dest = public_path("storage/$pathImg/");

                    if (File::exists($dest . $this->photo)) {
                        File::delete($dest . $this->photo);
                    }

                    $newImg = $this->new_photo->store($pathImg, 'public');
                    $validatedData['new_photo'] = str_replace("$pathImg/", '', $newImg);
                } else {
                    $validatedData['new_photo'] = $this->photo ?: NULL;
                }

                $this->paymentMethod->update([
                    'name' => str($validatedData['name'])->title(),
                    'number' => $validatedData['number'],
                    'photo' => $validatedData['new_photo'],
                ]);

                $this->message = 'Data Metode Pembayaran Berhasil Diperbaharui!.';
            }

            $this->cleanUpOldTempImages();

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

    public function cleanUpOldTempImages()
    {
        $oldFiles = Storage::files('livewire-tmp');

        foreach ($oldFiles as $file) {
            Storage::delete($file);
        }
    }

    public function resetForm()
    {
        $this->reset();
    }
}
