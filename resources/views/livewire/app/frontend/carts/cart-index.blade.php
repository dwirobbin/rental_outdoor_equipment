<div>
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('src/frontend/images/bg.jpeg') }}');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 pb-5">
                    <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Beranda <i class="ion-ios-arrow-forward"></i></a></span>
                        <span>Keranjang <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Keranjang</h1>
                </div>
            </div>
        </div>
    </section>

    @livewire('app.frontend.carts.cart-table')

    @livewire('app.frontend.carts.cart-delete')

    <section class="ftco-section bg-light pb-5 ">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-md-8 text-center heading-section">
                    <span class="subheading">Metode Pembayaran</span>
                    <h2 class="mb-3">Metode Pembayaran yang Tersedia</h2>
                </div>
            </div>
            <div class="row d-flex mb-4 justify-content-center">
                @foreach ($paymentMethods as $paymentMethod)
                    <div class="col d-flex align-self-stretch">
                        <div class="services w-100 text-center">
                            <div class="d-flex align-items-center justify-content-center mb-4">
                                <img src="{{ !is_null($paymentMethod->photo) ? asset('storage/image/payment-methods/' . $paymentMethod->photo) : asset('src/backend/images/no_image.png') }}"
                                    width="110px;">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
