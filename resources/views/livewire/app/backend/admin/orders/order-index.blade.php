<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right d-block">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Order</li>
                    </ol>
                </div>
                <h4 class="page-title">Order</h4>
            </div>
        </div>
    </div>

    @can('create', \App\Models\Order::class)
        @livewire('app.backend.admin.orders.order-chat')
    @endcan

    @can('update', \App\Models\Order::class)
        @livewire('app.backend.admin.orders.order-edit')
    @endcan

    @can('delete', \App\Models\Order::class)
        @livewire('app.backend.admin.orders.order-delete')

        @livewire('app.backend.admin.orders.order-bulk-delete')
    @endcan

    <div class="row">
        <div class="col-12">
            <div class="card">
                @can('viewAny', \App\Models\Order::class)
                    @livewire('app.backend.admin.orders.order-table', ['lazy' => true])
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
            @this.on('refresh-orders', (event) => {
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

            @this.on('scroll-down', () => {
                var container = document.querySelector('.modal-body');
                container.scrollTop = container.scrollHeight;
            })
        })
    </script>
@endPush
