<div class="card-body">
    <div class="d-flex flex-wrap justify-content-center justify-content-sm-between mb-3 py-0">
        <div class="text-muted my-1 my-sm-0">
            <label>
                Lihat
                <select class="d-inline-block form-select w-auto" wire:model.live='perPage'>
                    <option value="3">3</option>
                    <option value="5">5</option>
                    <option value="15">15</option>
                    <option value="35">35</option>
                    <option value="50">50</option>
                    <option value="85">85</option>
                    <option value="100">100</option>
                    @if (count($payment_methods))
                        <option value="{{ $payment_methods->total() }}">Semua</option>
                    @endif
                </select>
            </label>
        </div>

        <div class="text-muted my-1 my-sm-0">
            <div class="dropdown-center btn-group">
                <button class="btn btn-info dropdown-toggle arrow-none" data-bs-toggle="dropdown" @disabled($bulkSelectedDisabled)
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire.target="confirm-delete-selected-paymentMethod">
                        Terpilih ({{ count($bulkSelected) }}) Data

                        <i class="mdi mdi-chevron-down"></i>
                    </span>

                    <span wire:loading wire.target="confirm-delete-selected-paymentMethod" class="spinner-border spinner-border-sm"></span>
                    <span wire:loading wire.target="confirm-delete-selected-paymentMethod" role="status">Loading..</span>
                </button>

                <ul class="dropdown-menu dropdown-menu-animated">
                    <li>
                        @can('delete', \App\Models\PaymentMethod::class)
                            <button x-on:click="$dispatch('confirm-delete-selected-paymentMethod')" class="dropdown-item">
                                Hapus
                            </button>
                        @endcan
                    </li>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">Export ke :</h6>
                    <li>
                        @can('viewAny', \App\Models\PaymentMethod::class)
                            <button x-on:click="$dispatch('go-on-export-to-excel-selected')" class="dropdown-item">
                                Excel
                            </button>
                        @endcan
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
        <table class="table table-centered w-100 dt-responsive table-nowrap table-sortable">
            <thead class="table-light">
                <tr>
                    <th class="all" style="width: 20px;">
                        <div class="form-check">
                            <input type="checkbox" wire:model.live='bulkSelectAll' class="form-check-input" id="customCheck1" role="button">
                        </div>
                    </th>
                    <th>No.</th>
                    <th class="all sort @if ($sortColumn == 'name') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'name' })">
                        Nama Metode
                    </th>
                    <th class="sort @if ($sortColumn == 'number') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'number' })">
                        Nomor
                    </th>
                    <th style="width: 10%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payment_methods as $key => $paymentMethod)
                    <tr class="align-middle" wire:key='{{ $paymentMethod->id }}'>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" wire:model.live='bulkSelected' class="form-check-input" id="customCheck2"
                                    value="{{ $paymentMethod->id }}" role="button">
                            </div>
                        </td>
                        <td>{{ $payment_methods->firstItem() + $key }}</td>
                        <td>
                            <img src="{{ !is_null($paymentMethod->photo) ? asset('storage/image/payment-methods/' . $paymentMethod->photo) : asset('src/backend/images/no_image.png') }}"
                                alt="paymentMethod-img" title="paymentMethod-img" class="rounded me-1" height="55" width="80">
                            <p class="m-0 d-inline-block align-middle font-15 text-body fw-semibold">
                                {{ $paymentMethod->name }}
                            </p>
                        </td>
                        <td class="font-15">{{ $paymentMethod->number }}</td>
                        <td class="table-action">
                            @can('update', $paymentMethod)
                                <a x-on:click="$dispatch('set-paymentMethod-data', { id: {{ $paymentMethod->id }} })" class="action-icon"
                                    role="button">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>
                            @endcan
                            @can('delete', $paymentMethod)
                                <a x-on:click="deleteConfirm({{ $paymentMethod->id }}, '{{ $paymentMethod->name }}')" class="action-icon"
                                    role="button">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center fw-semibold">
                            {{ $payment_methods->isEmpty() ? 'Data tidak tersedia!' : 'Tidak ditemukan data yang sesuai!' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if (count($payment_methods))
        {{ $payment_methods->links(data: ['scrollTo' => false]) }}
    @endif
</div>
