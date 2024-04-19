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
                    @if (count($user_managements))
                        <option value="{{ $user_managements->total() }}">Semua</option>
                    @endif
                </select>
            </label>
        </div>

        <div class="text-muted my-1 my-sm-0">
            <div class="dropdown-center btn-group">
                <button class="btn btn-info dropdown-toggle arrow-none" data-bs-toggle="dropdown" @disabled($bulkSelectedDisabled)
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="confirm-delete-selected-user">
                        Terpilih ({{ count($bulkSelected) }}) Data

                        <i class="mdi mdi-chevron-down"></i>
                    </span>

                    <span wire:loading wire:target="confirm-delete-selected-user" class="spinner-border spinner-border-sm"></span>
                    <span wire:loading wire:target="confirm-delete-selected-user" role="status">Loading..</span>
                </button>

                <ul class="dropdown-menu dropdown-menu-animated">
                    <li>
                        @can('delete', \App\Models\User::class)
                            <button x-on:click="$dispatch('confirm-delete-selected-user')" class="dropdown-item">
                                Hapus
                            </button>
                        @endcan
                    </li>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">Export ke :</h6>
                    <li>
                        @can('viewAny', \App\Models\User::class)
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
                    <th class="all sort @if ($sortColumn == 'name') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'name' })">
                        Nama
                    </th>
                    <th class="sort @if ($sortColumn == 'username') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'username' })">
                        Username
                    </th>
                    <th class="sort @if ($sortColumn == 'email') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'email' })">
                        Email
                    </th>
                    <th class="sort @if ($sortColumn == 'roles.name') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'name' })">
                        Jabatan
                    </th>
                    <th class="sort @if ($sortColumn == 'is_active') {{ $sortDirection }} @endif"
                        x-on:click="$dispatch('sort', { columnName: 'is_active' })">
                        Status Akun
                    </th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($user_managements as $key => $userManagement)
                    <tr class="align-middle" wire:key='{{ $userManagement->id }}'>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" wire:model.live='bulkSelected' class="form-check-input" id="customCheck2"
                                    value="{{ $userManagement->id }}" role="button">
                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                            </div>
                        </td>
                        <td>{{ $user_managements->firstItem() + $key }}</td>
                        <td class="table-user">
                            <img src="{{ !is_null($userManagement->photo) ? asset('storage/image/users/' . $userManagement->photo) : asset('src/backend/images/no_image.png') }}"
                                alt="userManagement-img" title="userManagement-img" class="rounded-circle me-1">
                            <p class="m-0 d-inline-block align-middle font-15 text-body fw-semibold">
                                {{ $userManagement->name }}
                            </p>
                        </td>
                        <td class="font-15">{{ $userManagement->username }}</td>
                        <td class="font-15">{{ $userManagement->email }}</td>
                        <td class="font-14">
                            @if ($userManagement->role->name === 'admin')
                                <span class="font-13 badge bg-primary">Admin</span>
                            @else
                                <span class="font-13 badge bg-warning">Customer</span>
                            @endif
                        </td>
                        <td class="font-15">
                            @can('update', $userManagement)
                                <livewire:app.backend.bootstraps.toggle-button :model="$userManagement" field="is_active" :key="$userManagement->id" />
                            @endcan
                        </td>
                        <td class="table-action">
                            @can('update', $userManagement)
                                <a x-on:click="$dispatch('set-user-data', { id: {{ $userManagement->id }} })" class="action-icon" role="button"
                                    data-bs-toggle="modal" data-bs-target="#edit-user">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>
                            @endcan
                            @can('delete', $userManagement)
                                <a x-on:click="confirmDeleteAccountUser({{ $userManagement->id }}, '{{ $userManagement->name }}')"
                                    class="action-icon" role="button">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center fw-semibold">
                            {{ $user_managements->isEmpty() ? 'Data tidak tersedia!' : 'Tidak ditemukan data yang sesuai!' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if (count($user_managements))
        {{ $user_managements->links(data: ['scrollTo' => false]) }}
    @endif
</div>
