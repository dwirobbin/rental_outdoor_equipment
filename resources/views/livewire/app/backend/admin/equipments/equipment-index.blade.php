<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right d-block">
                    <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#create-equipment">
                        <i class="mdi mdi-plus-circle m-0"></i> Tambah
                    </button>
                </div>
                <h4 class="page-title">Peralatan</h4>
            </div>
        </div>
    </div>

    @can('create', \App\Models\Equipment::class)
        @livewire('app.backend.admin.equipments.equipment-create')
    @endcan

    @can('update', \App\Models\Equipment::class)
        @livewire('app.backend.admin.equipments.equipment-edit')
    @endcan

    @can('delete', \App\Models\Equipment::class)
        @livewire('app.backend.admin.equipments.equipment-delete')

        @livewire('app.backend.admin.equipments.equipment-bulk-delete')
    @endcan

    <div class="row">
        <div class="col-12">
            <div class="card">
                @can('viewAny', \App\Models\Equipment::class)
                    @livewire('app.backend.admin.equipments.equipment-table', ['lazy' => true])
                @endcan
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        // Runs after Livewire is loaded but before it's initialized
        document.addEventListener('livewire:init', () => {
            $("input[id='stock']").on('input', function(e) {
                $(e.target).val($(e.target).val().replace(/[^\d.]/ig, "")); // only number
            })

            $('.rupiah').mask("#.##0", {
                reverse: true
            });
        })

        // Runs immediately after Livewire has finished initializing
        document.addEventListener('livewire:initialized', () => {

            // hide modal
            @this.on('refresh-equipments', (event) => {
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
