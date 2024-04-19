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
                    @if (count($billings))
                        <option value="{{ $billings->total() }}">Semua</option>
                    @endif
                </select>
            </label>
        </div>

        <div class="text-muted my-1 my-sm-0">
            <div class="dropdown-center btn-group">
                <button class="btn btn-info dropdown-toggle arrow-none" data-bs-toggle="dropdown" @disabled($bulkSelectedDisabled)
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="confirm-delete-selected-billing">
                        Terpilih ({{ count($bulkSelected) }}) Data

                        <i class="mdi mdi-chevron-down"></i>
                    </span>

                    <span wire:loading wire:target="confirm-delete-selected-billing" class="spinner-border spinner-border-sm"></span>
                    <span wire:loading wire:target="confirm-delete-selected-billing" role="status">Loading..</span>
                </button>

                <ul class="dropdown-menu dropdown-menu-animated">
                    <li>
                        @can('delete', \App\Models\Billing::class)
                            <button x-on:click="$dispatch('confirm-delete-selected-billing')" class="dropdown-item">
                                Hapus
                            </button>
                        @endcan
                    </li>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">Export ke :</h6>
                    <li>
                        @can('viewAny', \App\Models\Billing::class)
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
                        <span wire:loading.remove wire:target="search" role="status">Cari</span>

                        <span wire:loading wire:target="search" class="spinner-border spinner-border-sm" role="status"></span>
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
                    <th class="all sort @if ($sortColumn == 'name') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'name' })">
                        Nama Penyewa
                    </th>
                    <th class="sort @if ($sortColumn == 'created_date') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'created_date' })">
                        Tgl Dibuat
                    </th>
                    <th class="sort @if ($sortColumn == 'due_date') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'due_date' })">
                        Tgl Jatuh Tempo
                    </th>
                    <th class="sort @if ($sortColumn == 'total') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'total' })">
                        Total Bayar
                    </th>
                    <th>
                        Bukti Bayar
                    </th>
                    <th class="sort @if ($sortColumn == 'status') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'status' })">
                        Status
                    </th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($billings as $key => $billing)
                    <tr class="align-middle" wire:key='{{ $billing->id }}'>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" wire:model.live='bulkSelected' class="form-check-input" id="customCheck2"
                                    value="{{ $billing->id }}" role="button">
                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                            </div>
                        </td>
                        <td>{{ $billings->firstItem() + $key }}</td>
                        <td class="fw-semibold">{{ $billing->order->order_code }}</td>
                        <td class="font-15">{{ $billing->order->orderedBy->name }}</td>
                        <td class="font-15">
                            {{ $billing->created_date->translatedFormat('d M Y') }}
                            {{-- , {{ $billing->created_at->format('H:i') }} --}}
                        </td>
                        <td class="font-15" style="min-width: 145px;">{{ $billing->due_date->translatedFormat('d M Y') }}</td>
                        <td class="font-15">Rp. {{ number_format($billing->total, 0, '', '.') }}</td>
                        <td>
                            <a href="{{ !is_null($billing->image) ? asset('storage/image/billings/' . $billing->image) : asset('src/backend/images/no_image.png') }}"
                                target="_blank" rel="noopener noreferrer">
                                <img src="{{ !is_null($billing->image) ? asset('storage/image/billings/' . $billing->image) : asset('src/backend/images/no_image.png') }}"
                                    alt="billing-img" title="billing-img" class="rounded" height="55" width="80">
                            </a>
                        </td>
                        <td class="font-14">
                            @if ($billing->status === 'unpaid')
                                <span class="font-13 badge bg-warning">Belum dibayar</span>
                            @elseif ($billing->status === 'waiting')
                                <span class="font-13 badge bg-primary">Menunggu konfirmasi</span>
                            @elseif ($billing->status === 'passed')
                                <span class="font-13 badge bg-danger">Jatuh tempo</span>
                            @elseif ($billing->status === 'paid')
                                <span class="font-13 badge bg-success">Sudah dibayar</span>
                            @else
                                <span class="font-13 badge bg-secondary">Dibatalkan</span>
                            @endif
                        </td>
                        <td class="table-action">
                            @can('view', $billing)
                                <a href="{{ route('admin_area.billing.detail', ['orderCode' => $billing->order->order_code]) }}"
                                    class="action-icon">
                                    <i class="mdi mdi-eye"></i>
                                </a>
                            @endcan
                            @can('update', $billing)
                                @if ($billing->status !== 'paid' && $billing->status !== 'cancelled')
                                    <a x-on:click="$dispatch('set-billing-data', { id: {{ $billing->id }} })" class="action-icon" role="button"
                                        data-bs-toggle="modal" data-bs-target="#edit-billing-status">
                                        <i class="mdi mdi-square-edit-outline"></i>
                                    </a>
                                @endif
                            @endcan
                            @can('delete', $billing)
                                <a x-on:click="confirmDeleteBill({{ $billing->id }}, '{{ $billing->order->order_code }}')" class="action-icon"
                                    role="button">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center fw-semibold">
                            {{ $billings->isEmpty() ? 'Data tidak tersedia!' : 'Tidak ditemukan data yang sesuai!' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if (count($billings))
        {{ $billings->links(data: ['scrollTo' => false]) }}
    @endif
</div>
