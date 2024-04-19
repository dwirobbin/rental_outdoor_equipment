<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right d-block">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Tagihan</li>
                    </ol>
                </div>
                <h4 class="page-title">Tagihan</h4>
            </div>
        </div>
    </div>

    @can('update', \App\Models\Billing::class)
        @livewire('app.backend.admin.billings.billing-edit')
    @endcan

    @can('delete', \App\Models\Billing::class)
        @livewire('app.backend.admin.billings.billing-delete')

        @livewire('app.backend.admin.billings.billing-bulk-delete')
    @endcan

    <div class="row">
        <div class="col-12">
            <div class="card">
                @can('viewAny', \App\Models\Billing::class)
                    @livewire('app.backend.admin.billings.billing-table', ['lazy' => true])
                @endcan
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        // Runs after Livewire is loaded but before it's initialized
        document.addEventListener('livewire:init', () => {
            $("input[data-type='numeric']").on('input', function(e) {
                $(e.target).val($(e.target).val().replace(/[^\d.]/ig, "")); // only number
            })

            $('.rupiah').mask("#.##0", {
                reverse: true
            });
        })

        // Runs immediately after Livewire has finished initializing
        document.addEventListener('livewire:initialized', () => {

            // hide modal
            @this.on('refresh-billings', (event) => {
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
