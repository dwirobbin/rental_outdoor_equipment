<section class="ftco-section">
    <div class="container">

        <x-alert />

        <div class="row d-flex justify-content-center mx-0 shadow-sm border ">
            <div class="col-md-12 py-5 rounded">

                <h2 class="display-5 mb-5 text-center">
                    Terdapat
                    <i class="text-info font-weight-bold" style="font-style: normal">{{ count($cartItems) }}</i>
                    Macam Barang di Keranjang
                </h2>

                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th scope="col" class="border-0 bg-light px-0 py-1">
                                    <div class="p-2 px-3 text-uppercase">Produk</div>
                                </th>
                                <th scope="col" class="border-0 bg-light px-0 py-1">
                                    <div class="py-2 text-uppercase">Harga Sewa</div>
                                </th>
                                <th scope="col" class="border-0 bg-light px-0 py-1">
                                    <div class="py-2 text-uppercase">Jumlah</div>
                                </th>
                                <th scope="col" class="border-0 bg-light px-0 py-1" style="width: 15%">
                                    <div class="py-2 text-uppercase">Total</div>
                                </th>
                                <th scope="col" class="border-0 bg-light px-0 py-1">
                                    <div class="py-2 text-uppercase">hapus</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cartItems as $item)
                                <tr class="align-middle" wire:key="item-{{ $item->id }}">
                                    <th scope="row" class="border-0">
                                        <div class="p-2">
                                            <img src="{{ !is_null($item->product->photo) ? asset('storage/image/equipments/' . $item->product->photo) : asset('src/backend/images/no_image.png') }}"
                                                alt="product-img" width="70" class="img-fluid rounded shadow-sm">
                                            <div class="ml-3 d-inline-block align-middle">
                                                <h5 class="mb-0">
                                                    <a href="#" class="text-dark d-inline-block align-middle">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h5>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="border-0">
                                        <strong>Rp. {{ number_format($item->product->price, 0, '', '.') }}</strong>/Hari
                                    </td>
                                    <td class="border-0">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-danger" data-type="minus"
                                                    wire:click='decrementQty({{ $item->id }})'>-
                                                </button>
                                            </span>
                                            <span class="mx-3">{{ $item->quantity }}</span>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-success" data-type="plus"
                                                    wire:click='incrementQty({{ $item->id }})'>+
                                                </button>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="border-0">
                                        <strong>Rp. {{ number_format($item->product->price * $item->quantity, 0, '', '.') }}</strong>
                                    </td>
                                    <td class="border-0">
                                        <button type="button"
                                            x-on:click="confirmDeleteCartItem('{{ $item->id }}', '{{ $item->product->name }}')"
                                            class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="align-middle">
                                    <td colspan="5" class="border-0 text-center">
                                        {{ empty($equipments) ? 'Data tidak tersedia!' : 'Tidak ditemukan data yang sesuai!' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-light rounded-pill px-4 py-3 mt-3 text-uppercase font-weight-bold">Order</div>
                <div class="px-4 pt-4">
                    <p class="font-bold mb-4">
                        Pengambilan barang di tempat.
                    </p>
                    <form wire:submit='checkout' method="post">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="startDate" class="form-label">Tanggal Sewa</label>
                                <input type="text" id="startDate" wire:model='start_date'
                                    class="form-control @error('start_date') is-invalid @enderror" autocomplete="off" placeholder='Tgl/Bln/Thn'
                                    data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy"
                                    data-date-today-highlight="true" data-date-start-date="0d"
                                    onchange="this.dispatchEvent(new InputEvent('input'))">
                                @error('start_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2 position-relative" id="datepicker2">
                                <label for="endDate" class="form-label">Akhir Sewa</label>
                                <input type="text" id="endDate" wire:model.live='end_date'
                                    class="form-control @error('end_date') is-invalid @enderror" autocomplete="off" placeholder='Tgl/Bln/Thn'
                                    data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy"
                                    data-date-today-highlight="true" data-date-start-date="0d"
                                    onchange="this.dispatchEvent(new InputEvent('input'))">
                                @error('end_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <ul class="list-unstyled">
                            <li class="d-flex justify-content-between py-3 border-bottom align-items-center">
                                <strong class="text-muted">Total</strong>
                                <h5 class="font-weight-bold">Rp. {{ number_format($total, 0, '', '.') }}</h5>
                            </li>
                            <div class="mt-4 d-flex flex-wrap justify-content-between align-items-center">
                                <a href="{{ route('equipment') }}" class="text-primary py-2 float-left text-left">Lanjutkan Belanja</a>
                                <button type="submit" class="btn btn-dark btn-lg py-2 float-right text-right" @disabled(auth()?->user()?->role->name === 'admin')>
                                    Checkout
                                </button>
                            </div>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
