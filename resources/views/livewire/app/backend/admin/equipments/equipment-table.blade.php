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
                    @if (count($equipments))
                        <option value="{{ $equipments->total() }}">Semua</option>
                    @endif
                </select>
            </label>
        </div>

        <div class="text-muted my-1 my-sm-0">
            <div class="dropdown-center btn-group">
                <button class="btn btn-info dropdown-toggle arrow-none" data-bs-toggle="dropdown" @disabled($bulkSelectedDisabled)
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="confirm-delete-selected-equipment">
                        Terpilih ({{ count($bulkSelected) }}) Data

                        <i class="mdi mdi-chevron-down"></i>
                    </span>

                    <span wire:loading wire:target="confirm-delete-selected-equipment" class="spinner-border spinner-border-sm"></span>
                    <span wire:loading wire:target="confirm-delete-selected-equipment" role="status">Loading..</span>
                </button>

                <ul class="dropdown-menu dropdown-menu-animated">
                    <li>
                        @can('delete', \App\Models\Equipment::class)
                            <button x-on:click="$dispatch('confirm-delete-selected-equipment')" class="dropdown-item">
                                Hapus
                            </button>
                        @endcan
                    </li>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">Export ke :</h6>
                    <li>
                        @can('viewAny', \App\Models\Equipment::class)
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
        <table class="table table-centered w-100 dt-responsive table-nowrap table-sortable">
            <thead class="table-light">
                <tr>
                    <th class="all" style="width: 20px;">
                        <div class="form-check">
                            <input type="checkbox" wire:model.live='bulkSelectAll' class="form-check-input" id="customCheck1" role="button">
                            <label class="form-check-label" for="customCheck1">&nbsp;</label>
                        </div>
                    </th>
                    <th>No.</th>
                    <th class="all sort @if ($sortColumn == 'name') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'name' })">
                        Peralatan
                    </th>
                    <th class="sort @if ($sortColumn == 'price') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'price' })">
                        Harga Sewa
                    </th>
                    <th class="sort @if ($sortColumn == 'stock') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'stock' })">
                        Stok
                    </th>
                    <th style="width: 10%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($equipments as $key => $equipment)
                    <tr class="align-middle" wire:key='{{ $equipment->id }}'>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" wire:model.live='bulkSelected' class="form-check-input" id="customCheck2"
                                    value="{{ $equipment->id }}" role="button">
                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                            </div>
                        </td>
                        <td>{{ $equipments->firstItem() + $key }}</td>
                        <td>
                            <img src="{{ !is_null($equipment->photo) ? asset('storage/image/equipments/' . $equipment->photo) : asset('src/backend/images/no_image.png') }}"
                                alt="equipment-img" title="equipment-img" class="rounded me-2" height="63" width="90">
                            <p class="m-0 d-inline-block align-middle font-15 text-body fw-semibold">
                                {{ $equipment->name }}
                            </p>
                        </td>
                        <td class="font-15">Rp. {{ number_format($equipment->price, 0, '', '.') }} /Hari</td>
                        <td class="font-15">
                            @if ($equipment->stock >= 1 && $equipment->stock <= 5)
                                <span class="font-13 badge bg-warning">Sisa: {{ $equipment->stock }}</span>
                            @elseif ($equipment->stock == 0)
                                <span class="font-13 badge bg-danger">Habis</span>
                            @else
                                <span class="font-13 badge bg-success">Tersedia: {{ $equipment->stock }}</span>
                            @endif
                        </td>
                        <td class="table-action">
                            @can('update', $equipment)
                                <a x-on:click="$dispatch('set-equipment-data', { id: {{ $equipment->id }} })" class="action-icon" role="button"
                                    data-bs-toggle="modal" data-bs-target="#edit-equipment">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>
                            @endcan
                            @can('delete', $equipment)
                                <a x-on:click="deleteConfirm({{ $equipment->id }}, '{{ $equipment->name }}')" class="action-icon" role="button">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center fw-semibold">
                            {{ $equipments->isEmpty() ? 'Data tidak tersedia!' : 'Tidak ditemukan data yang sesuai!' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if (count($equipments))
        {{ $equipments->links(data: ['scrollTo' => false]) }}
    @endif
</div>
