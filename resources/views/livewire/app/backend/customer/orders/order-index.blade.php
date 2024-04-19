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

    @unless (auth()->user()->can('update', \App\Models\Order::class))
        @livewire('app.backend.customer.orders.order-edit')
    @endunless

    @unless (auth()->user()->can('create', \App\Models\Order::class))
        @livewire('app.backend.customer.orders.order-chat')
    @endunless

    <div class="row">
        <div class="col-12">
            <div class="card">
                @unless (auth()->user()->can('viewAny', \App\Models\Order::class))
                    @livewire('app.backend.customer.orders.order-table', ['lazy' => true])
                @endunless
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
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
        })
    </script>
@endPush
