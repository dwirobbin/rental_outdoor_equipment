<div class="card-body">
    <div class="d-flex flex-wrap justify-content-start mb-3 py-0">
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
                        @unless (auth()->user()->can('viewAny', \App\Models\User::class))
                            <button x-on:click="$dispatch('go-on-export-to-excel-selected')" class="dropdown-item">
                                Excel
                            </button>
                        @endunless
                    </li>
                </ul>
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
                    <th class="all">Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Jabatan</th>
                    <th>Status Akun</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($userManagement))
                    <tr class="align-middle" wire:key='{{ $userManagement->id }}'>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" wire:model.live='bulkSelected' class="form-check-input" id="customCheck2"
                                    value="{{ $userManagement->id }}" role="button">
                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                            </div>
                        </td>
                        <td>1</td>
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
                            @if ($userManagement->is_active == true)
                                <span class="font-13 badge bg-success">Aktif</span>
                            @else
                                <span class="font-13 badge bg-success">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="table-action">
                            @unless (auth()->user()->can('update', $userManagement))
                                <a x-on:click="$dispatch('set-account-data', { id: {{ $userManagement->id }} })" class="action-icon" role="button"
                                    data-bs-toggle="modal" data-bs-target="#edit-account">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>
                            @endunless
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="8" class="text-center fw-semibold">
                            {{ empty($user_managements) ? 'Data tidak tersedia!' : 'Tidak ditemukan data yang sesuai!' }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
