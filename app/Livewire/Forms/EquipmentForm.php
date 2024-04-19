<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Equipment;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule as ValidationRule;

class EquipmentForm extends Form
{
    public ?Equipment $equipment = NULL;

    public ?string $name = NULL, $price = NULL;
    public ?int $stock = NULL;
    public object|string|null $photo = NULL, $new_photo = NULL;

    private ?array $response = NULL;
    private ?string $message = NULL;

    public function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'min:3',
                ValidationRule::when(is_null($this->equipment), [
                    ValidationRule::unique('equipments', 'name')
                ]),
                ValidationRule::when(!is_null($this->equipment), [
                    ValidationRule::unique('equipments', 'name')->ignore($this->equipment?->id, 'id')
                ]),
            ],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'numeric', 'integer'],
            'photo' => [
                'nullable',
                ValidationRule::when(is_null($this->equipment), [
                    'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:2048', 'unique:equipments,photo'
                ]),
            ],
            'new_photo' => [
                'nullable',
                ValidationRule::when(!is_null($this->equipment) && !is_null($this->new_photo), [
                    'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:2048',
                    ValidationRule::unique('payment_methods', 'photo')->ignore($this->equipment?->id, 'id')
                ]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => ':attribute wajib diisi.',
            '*.string' => ':attribute harus berupa string.',
            '*.numeric' => ':attribute harus berupa angka.',
            '*.integer' => ':attribute harus berupa integer.',
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
            'price' => 'Harga',
            'stock' => 'Stok',
            'photo' => 'Foto',
            'new_photo' => 'Foto',
        ];
    }

    public function setData(int $id)
    {
        $this->equipment = Equipment::findOrFail($id);

        $this->name = $this->equipment->name;
        $this->price = number_format($this->equipment->price, 0, '', '.');
        $this->stock = $this->equipment->stock;
        $this->photo = $this->equipment->photo;
    }

    public function store(): array
    {
        $validatedData = $this->validate();

        $validatedData['price'] = str_replace('.', '', $validatedData['price']);

        $pathImg = 'image/equipments';

        try {

            if (is_null($this->equipment)) {
                if (!is_null($validatedData['photo'])) {
                    $imageName = $this->photo->store($pathImg, 'public');
                    $validatedData['photo'] = str_replace("$pathImg/", '', $imageName);
                }

                Equipment::create([
                    'name' => str($validatedData['name'])->title(),
                    'price' => $validatedData['price'],
                    'stock' => $validatedData['stock'],
                    'photo' => $validatedData['photo'] ?? null,
                ]);

                $this->message = 'Peralatan Baru Berhasil Ditambahkan!.';
            }

            if (!is_null($this->equipment)) {
                if (!is_null($this->new_photo)) {
                    $destinationPath = public_path("storage/$pathImg/");

                    if (File::exists($destinationPath . $this->photo)) {
                        File::delete($destinationPath . $this->photo);
                    }

                    $newImg = $this->new_photo->store($pathImg, 'public');

                    $validatedData['new_photo'] = str_replace("$pathImg/", '', $newImg);
                } else {
                    $validatedData['new_photo'] = $this->photo ?: NULL;
                }

                $this->equipment->update([
                    'name' => str($validatedData['name'])->title(),
                    'price' => $validatedData['price'],
                    'stock' => $validatedData['stock'],
                    'photo' => $validatedData['new_photo'],
                ]);

                $this->message = 'Data Peralatan Berhasil Diperbaharui!.';
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
