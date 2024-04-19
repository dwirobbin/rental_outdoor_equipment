<div class="card-body">
    <div class="d-flex flex-wrap justify-content-center justify-content-sm-between mb-3 py-0">
        <div class="text-muted my-1 my-sm-0">
            <label>
                Lihat
                <select class="d-inline-block form-select w-auto" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="35">35</option>
                    <option value="50">50</option>
                    <option value="65">65</option>
                    <option value="85">85</option>
                    <option value="100">100</option>
                    @if (count($orders))
                        <option value="{{ $orders->total() }}">Semua</option>
                    @endif
                </select>
            </label>
        </div>

        <div class="text-muted my-1 my-sm-0">
            <div class="dropdown-center btn-group">
                <button class="btn btn-info dropdown-toggle arrow-none" data-bs-toggle="dropdown" @disabled($bulkSelectedDisabled)
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire.target="go-on-export-to-excel-selected">
                        Terpilih ({{ count($bulkSelected) }}) Data

                        <i class="mdi mdi-chevron-down"></i>
                    </span>

                    <span wire:loading wire.target="go-on-export-to-excel-selected" class="spinner-border spinner-border-sm"></span>
                    <span wire:loading wire.target="go-on-export-to-excel-selected" role="status">Loading..</span>
                </button>

                <ul class="dropdown-menu dropdown-menu-animated">
                    <h6 class="dropdown-header">Export ke :</h6>
                    <li>
                        @unless (auth()->user()->can('viewAny', \App\Models\Order::class))
                            <button x-on:click="$dispatch('go-on-export-to-excel-selected')" class="dropdown-item">
                                Excel
                            </button>
                        @endunless
                    </li>
                </ul>
            </div>
        </div>

        <div class="text-muted my-1 my-sm-0">
            <div class="app-search">
                <div class="input-group">
                    <input type="text" wire:model.live='search' class="form-control" placeholder="Cari sesuatu...">
                    <span class="mdi mdi-magnify search-icon"></span>
                    <span class="input-group-text bg-primary text-white rounded-right">
                        <span wire:loading.remove wire.target="search" role="status">Cari</span>

                        <span wire:loading wire.target="search" class="spinner-border spinner-border-sm" role="status"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-centered table-nowrap table-sortable">
            <thead class="table-light ">
                <tr>
                    <th class="all" style="width: 20px;">
                        <div class="form-check">
                            <input type="checkbox" wire:model.live='bulkSelectAll' class="form-check-input" id="customCheck1" role="button">
                            <label class="form-check-label" for="customCheck1">&nbsp;</label>
                        </div>
                    </th>
                    <th>No.</th>
                    <th class="all sort @if ($sortColumn == 'order_code') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'order_code' })">
                        ID Order#
                    </th>
                    <th class="sort @if ($sortColumn == 'start_date') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'start_date' })">
                        Tgl Sewa
                    </th>
                    <th class="sort @if ($sortColumn == 'end_date') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'end_date' })">
                        Tgl Berakhir
                    </th>
                    <th class="sort @if ($sortColumn == 'amount') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'amount' })">
                        Jmlh Yg Disewa
                    </th>
                    <th>
                        Bukti Pengembalian
                    </th>
                    <th>
                        Denda
                    </th>
                    <th class="sort @if ($sortColumn == 'status') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'status' })">
                        Status
                    </th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $key => $order)
                    <tr class="align-middle" wire:key='{{ $order->id }}'>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" wire:model.live='bulkSelected' class="form-check-input" id="customCheck2"
                                    value="{{ $order->id }}" role="button">
                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                            </div>
                        </td>
                        <td>{{ $orders->firstItem() + $key }}</td>
                        <td class="font-15 fw-semibold" style="min-width: 105px;">{{ $order->order_code }}</td>
                        <td class="font-15">
                            {{ $order->start_date->translatedFormat('d M Y') }}
                            {{-- , {{ $order->created_at->format('H:i') }} --}}
                        </td>
                        <td class="font-15">{{ $order->end_date->translatedFormat('d M Y') }}</td>
                        <td class="font-15" style="min-width: 140px;">{{ $order->amount }} Alat</td>
                        <td>
                            <a href="{{ !is_null($order->image) ? asset('storage/image/orders/' . $order->image) : asset('src/backend/images/no_image.png') }}"
                                target="_blank" rel="noopener noreferrer">
                                <img src="{{ !is_null($order->image) ? asset('storage/image/orders/' . $order->image) : asset('src/backend/images/no_image.png') }}"
                                    alt="order-img" title="order-img" class="rounded" height="55" width="80">
                            </a>
                        </td>
                        <td class="font-15">
                            Rp. {{ number_format($order->penalty, 0, '', '.') }}
                        </td>
                        <td class="font-14">
                            @if ($order->status === 'pending')
                                <span class="font-13 badge bg-warning">Pending</span>
                            @elseif ($order->status === 'waiting')
                                <span class="font-13 badge bg-info">Menunggu Konfirmasi</span>
                            @elseif ($order->status === 'rented')
                                <span class="font-13 badge bg-success">Sedang disewa</span>
                            @elseif ($order->status === 'passed')
                                <span class="font-13 badge bg-danger">Jatuh tempo</span>
                            @elseif ($order->status === 'returned')
                                <span class="font-13 badge bg-primary">Sudah dikembalikan</span>
                            @else
                                <span class="font-13 badge bg-secondary">Dibatalkan</span>
                            @endif
                        </td>
                        <td class="table-action">
                            @unless (auth()->user()->can('create', \App\Models\User::class))
                                <a x-on:click="$dispatch('set-customer-chat-order-data', { id: {{ $order->id }} })"
                                    class="action-icon position-relative" role="button" data-bs-toggle="modal"
                                    data-bs-target="#customer-chat-order">
                                    <i class="uil-comments-alt noti-icon"></i>
                                </a>
                            @endunless
                            @unless (auth()->user()->can('view', $order))
                                <a href="{{ route('customer_area.order.detail', ['orderCode' => $order->order_code]) }}" class="action-icon">
                                    <i class="mdi mdi-eye"></i>
                                </a>
                            @endunless
                            @unless (auth()->user()->can('update', $order))
                                @if ($order->status === 'rented' || (now()->format('d M Y') == $order->end_date->format('d M Y') && $order->billing?->status === 'paid'))
                                    <a x-on:click="$dispatch('set-order-data-customer', { id: {{ $order->id }} })" class="action-icon"
                                        role="button" data-bs-toggle="modal" data-bs-target="#edit-order-image">
                                        <i class="mdi mdi-square-edit-outline"></i>
                                    </a>
                                @endif
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center fw-semibold">
                            {{ $orders->isEmpty() ? 'Data tidak tersedia!' : 'Tidak ditemukan data yang sesuai!' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if (count($orders))
        {{ $orders->links(data: ['scrollTo' => false]) }}
    @endif
</div>
