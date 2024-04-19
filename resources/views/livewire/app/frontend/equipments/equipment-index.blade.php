<div>
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('src/frontend/images/bg.jpeg') }}');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 pb-5">
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="{{ route('home') }}">Beranda <i class="ion-ios-arrow-forward"></i></a>
                        </span>
                        <span>Peralatan <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Pilih dan Masukkan Ke Keranjang</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">

            <x-alert />

            <div class="row">
                @forelse ($equipments as $equipment)
                    <div class="col-md-4" wire:key='{{ $equipment->id }}'>
                        <div class="car-wrap rounded">
                            <div class="img rounded d-flex align-items-end"
                                style="background-image: url('{{ !is_null($equipment->photo) ? asset('storage/image/equipments/' . $equipment->photo) : asset('src/backend/images/no_image.png') }}');">
                            </div>
                            <div class="text">
                                <h2><a href="car-single.html">{{ $equipment->name }}</a></h2>
                                <div class="d-flex mb-3">
                                    <span class="price">
                                        Rp. {{ number_format($equipment->price, 0, '', '.') }}
                                        <span>/Hari</span>
                                    </span>
                                    <p class="price ml-auto"><span>Stok: </span>
                                        @if ($equipment->stock === 0)
                                            <span class="badge badge-danger text-white">Habis</span>
                                        @else
                                            {{ $equipment->stock }}
                                        @endif
                                    </p>
                                </div>
                                <a wire:click='addToCart({{ $equipment->id }})'
                                    class="btn btn-block btn-primary py-2 @if ($equipment->stock === 0 || auth()?->user()?->role->name === 'admin') disabled @endif">
                                    Masukkan Ke Keranjang
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="col text-center">
                            <div class="block-27">
                                {{ empty($equipments) ? 'Data tidak tersedia!' : 'Tidak ditemukan data yang sesuai!' }}
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center">
                @if (count($equipments))
                    {{ $equipments->links(data: ['scrollTo' => true]) }}
                @endif
            </div>
        </div>
    </section>
</div>
