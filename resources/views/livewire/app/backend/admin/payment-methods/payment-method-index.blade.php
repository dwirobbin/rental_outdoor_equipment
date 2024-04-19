<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Metode Pembayaran</h4>
            </div>
        </div>
    </div>

    @can('delete', \App\Models\PaymentMethod::class)
        @livewire('app.backend.admin.payment-methods.payment-method-delete')

        @livewire('app.backend.admin.payment-methods.payment-method-bulk-delete')
    @endcan

    <div class="row">
        @can('viewAny', \App\Models\PaymentMethod::class)
            <div class="col-4">
                @livewire('app.backend.admin.payment-methods.payment-method-form')
            </div>

            <div class="col-8">
                <div class="card">
                    @livewire('app.backend.admin.payment-methods.payment-method-table', ['lazy' => true])
                </div>
            </div>
        @endcan
    </div>
</div>

@push('js')
    <script>
        // Runs after Livewire is loaded but before it's initialized
        document.addEventListener('livewire:init', () => {
            $("input[id='number']").on('input', function(e) {
                $(e.target).val($(e.target).val().replace(/[^\d.]/ig, "")); // only number
            })
        })

        // Runs immediately after Livewire has finished initializing
        document.addEventListener('livewire:initialized', () => {

            // reset file input
            @this.on('refresh-paymentMethods', (event) => {
                $("#photo").val(null);
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
