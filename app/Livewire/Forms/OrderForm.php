<?php

namespace App\Livewire\Forms;

use App\Models\Equipment;
use Livewire\Form;
use App\Models\Order;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule as ValidationRule;

class OrderForm extends Form
{
    private ?string $event = NULL;

    public ?Order $order = NULL;

    public ?string $order_status = NULL;
    public object|string|null $photo = NULL, $new_photo = NULL;

    private ?array $response = NULL;
    private ?string $message = NULL;

    public function rules(): array
    {
        return [
            'order_status' => [
                ValidationRule::when($this->event === 'edit-order-status', [
                    'required', 'in:pending,cancelled,rented,passed,returned'
                ])
            ],
            'new_photo' => [
                ValidationRule::when($this->event === 'edit-order-image', [
                    'required', 'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:2048',
                    ValidationRule::unique('orders', 'image')->ignore($this->order?->id, 'id'),
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
            'order_status' => 'Status',
            'new_photo' => 'Bukti Bayar',
        ];
    }

    public function setData(int $id)
    {
        $this->order = Order::findOrFail($id);

        $this->order_status = $this->order->status;
        $this->photo = $this->order->image;
    }

    public function store(string $eventName): array
    {
        $this->event = $eventName;

        $validatedData = $this->validate();

        $pathImg = 'image/orders';

        try {

            // admin
            if ($eventName === 'edit-order-status') {

                $this->order->update([
                    'status' => $validatedData['order_status'],
                ]);

                if ($validatedData['order_status'] === 'cancelled' || $validatedData['order_status'] === 'returned') {
                    foreach ($this->order->orderDetails as $item) {
                        Equipment::whereId($item->equipment_id)->increment('stock', $item->amount);
                    }
                }

                $this->message = 'Status Berhasil Diperbaharui!.';
            }

            // customer
            if ($eventName === 'edit-order-image') {
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

                $this->order->update([
                    'status' => 'waiting',
                    'image' => $validatedData['new_photo'],
                ]);

                $this->message = 'Bukti pengembalian Berhasil Diperbaharui!.';
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
