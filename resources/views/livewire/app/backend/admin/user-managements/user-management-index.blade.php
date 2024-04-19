<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right d-block">
                    @can('create', \App\Models\User::class)
                        <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#create-user">
                            <i class="mdi mdi-plus-circle m-0"></i> Tambah
                        </button>
                    @endcan
                </div>
                <h4 class="page-title">Manajemen User</h4>
            </div>
        </div>
    </div>

    @can('create', \App\Models\User::class)
        @livewire('app.backend.admin.user-managements.user-management-create')
    @endcan

    @can('update', \App\Models\User::class)
        @livewire('app.backend.admin.user-managements.user-management-edit')
    @endcan

    @can('delete', \App\Models\User::class)
        @livewire('app.backend.admin.user-managements.user-management-delete')

        @livewire('app.backend.admin.user-managements.user-management-bulk-delete')
    @endcan

    <div class="row">
        <div class="col-12">
            <div class="card">
                @can('viewAny', \App\Models\User::class)
                    @livewire('app.backend.admin.user-managements.user-management-table', ['lazy' => true])
                @endcan
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        // Runs immediately after Livewire has finished initializing
        document.addEventListener('livewire:initialized', () => {

            // hide modal
            @this.on('refresh-users', (event) => {
                $("#photo").val(null);

                let modalEl = document.getElementById(`${event.eventName}`);
                let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.hide();
            })

            // toast
            @this.on('flash-msg', (event) => {
                swalToast.fire({
                    icon: event.type,
                    title: event.text
                });
            })
        })
    </script>
@endPush
