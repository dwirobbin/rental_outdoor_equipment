<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Billing;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule as ValidationRule;

class BillingForm extends Form
{
    private ?string $event = NULL;

    public ?Billing $billing = NULL;

    public ?string $bill_status = NULL;
    public object|string|null $photo = NULL, $new_photo = NULL;

    private ?array $response = NULL;
    private ?string $message = NULL;

    public function rules(): array
    {
        return [
            'bill_status' => [
                ValidationRule::when($this->event === 'edit-billing-status', [
                    'required', 'in:unpaid,passed,paid,cancelled'
                ])
            ],
            'new_photo' => [
                ValidationRule::when($this->event === 'edit-billing-image', [
                    'required', 'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:2048',
                    ValidationRule::unique('billings', 'image')->ignore($this->billing?->id, 'id'),
                ])
            ]
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => ':attribute wajib diisi.',
            '*.in' => ':attribute harus berupa salah satu dari tipe berikut: :values.',
            '*.max' => 'Maksimal ukuran :attribute 2 MB..',
            '*.unique' => ':attribute sudah digunakan.',
            '*.image' => ':attribute harus berupa gambar.',
            '*.mimes' => ':attribute harus berformat :values.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'bill_status' => 'Status',
            'new_photo' => 'Bukti Bayar',
        ];
    }

    public function setData(int $id)
    {
        $this->billing = Billing::findOrFail($id);

        $this->bill_status = $this->billing->status;
        $this->photo = $this->billing->image;
    }

    public function store(string $eventName): array
    {
        $this->event = $eventName;

        $validatedData = $this->validate();

        $pathImg = 'image/billings';

        try {

            // admin
            if ($eventName === 'edit-billing-status') {
                $this->billing->update([
                    'status' => $validatedData['bill_status'],
                ]);

                if ($validatedData['bill_status'] === 'paid') {
                    $this->billing->order()->update(['status' => 'rented']);
                }

                if ($validatedData['bill_status'] === 'cancelled') {
                    $this->billing->order()->update(['status' => 'cancelled']);
                }

                $this->message = 'Status Berhasil Diperbaharui!.';
            }

            // customer
            if ($eventName === 'edit-billing-image') {
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

                $this->billing->update([
                    'status' => 'waiting',
                    'image' => $validatedData['new_photo'],
                ]);

                $this->message = 'Bukti bayar Berhasil Diperbaharui!.';
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
