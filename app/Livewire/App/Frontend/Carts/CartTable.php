<?php

namespace App\Livewire\App\Frontend\Carts;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Billing;
use Livewire\Component;
use App\Models\Equipment;
use App\Models\OrderDetail;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class CartTable extends Component
{
    public $cartItems;

    public int $total = 0;

    public ?string $start_date = NULL;
    public ?string $end_date = NULL;

    #[On('refresh-carts')]
    public function render()
    {
        $this->cartItems = Cart::with('product')->where('user_id', '=', auth()->id())->get();

        $total = 0;

        foreach ($this->cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }

        $this->total = $total;

        $this->calculateTotal($this->start_date, $this->end_date);

        return view('livewire.app.frontend.carts.cart-table');
    }

    public function incrementQty(int $id)
    {
        $cart = Cart::with('product:id,name')
            ->whereId($id)
            ->first();

        $product = Equipment::select('id', 'stock')
            ->whereId($cart->product_id)
            ->first();

        if ($product->stock > $cart->quantity) {
            $cart->quantity += 1;
            $cart->save();

            session()->flash('message', [
                'text' => 'Berhasil ditambah!',
                'type' => 'success'
            ]);
        }

        session()->flash('message', [
            'text' => 'Stok alat: ' . $cart->product->name . ' Tersisa ' . $product->stock,
            'type' => 'danger'
        ]);
    }

    public function decrementQty(int $id)
    {
        $cart = Cart::whereId($id)->first();

        if ($cart->quantity > 1) {
            $cart->quantity -= 1;
            $cart->save();

            session()->flash('message', [
                'text' => 'Berhasil dikurangi!',
                'type' => 'success'
            ]);
        }

        session()->flash('message', [
            'text' => 'Tidak boleh lebih kecil dari 1',
            'type' => 'danger'
        ]);
    }

    public function rules()
    {
        return [
            'start_date' => 'required|date_format:d/m/Y|after_or_equal:today',
            'end_date' => 'nullable|date_format:d/m/Y|after_or_equal:start_date',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => ':attribute wajib diisi.',
            '*.date_format' => ':attribute harus sesuai dengan format :format.',
            '*.before_or_equal' => ':attribute harus berupa tanggal sebelum atau sama dengan :date.',
            '*.after_or_equal' => ':attribute harus berupa tanggal sesudah atau sama dengan :date.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'start_date' => 'Tanggal mulai',
            'end_date' => 'Tanggal berakhir',
        ];
    }

    public function checkout()
    {
        $validatedData = $this->validate();

        $startDate = Carbon::createFromFormat('d/m/Y', $validatedData['start_date'])->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $validatedData['end_date'] ?? $validatedData['start_date'])->format('Y-m-d');

        try {
            DB::beginTransaction();

            $order = Order::create([
                'order_code' => $this->generateUniqueCode(),
                'ordered_by' => auth()->id(),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'image' => NULL,
                'status' => 'pending',
            ]);

            if ($order->wasRecentlyCreated) {
                foreach ($this->cartItems as $item) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'equipment_id' => $item->product_id,
                        'amount' => $item->quantity,
                    ]);

                    Equipment::whereId($item->product_id)->decrement('stock', $item->quantity);
                }

                $dueDate = Carbon::createFromFormat('d/m/Y', $validatedData['start_date'])->addDays(7)->format('Y-m-d');

                if ($endDate === $startDate || $endDate <= $dueDate) {
                    $dueDate = $endDate;
                }

                Billing::create([
                    'order_id' => $order->id,
                    'created_date' => $startDate,
                    'due_date' => $dueDate,
                    'total' => $this->total,
                    'image' => NULL,
                    'status' => 'unpaid',
                ]);

                Cart::whereUserId(auth()->id())->delete();
            }

            DB::commit();

            session()->flash('message', [
                'text' => 'Berhasil disimpan!',
                'type' => 'success'
            ]);

            $this->reset();
            $this->resetValidation();

            return $this->redirectRoute('customer_area.billing.index');
        } catch (\Exception $ex) {
            DB::rollback();

            session()->flash('message', [
                'text' => $ex->getMessage(),
                'type' => 'danger'
            ]);
        }
    }

    private function generateUniqueCode()
    {
        do {
            $code = random_int(100000, 999999);
        } while (Order::whereOrderCode($code)->first());

        return $code;
    }

    public function calculateTotal(?string $startDate = null, ?string $endDate = null)
    {
        if (!empty($endDate) && $startDate == $endDate) {
            return $this->total;
        } else if (!empty($endDate) && $startDate != $endDate) {
            return $this->total *= Carbon::createFromFormat('d/m/Y', $startDate)->yesterday()
                ->diffInDays(Carbon::createFromFormat('d/m/Y', $endDate));
        }

        return null;
    }
}
