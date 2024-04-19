<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin_area.billing.index') }}">Tagihan</a></li>
                        <li class="breadcrumb-item active">Invoice</li>
                    </ol>
                </div>
                <h4 class="page-title">Detail Tagihan</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <!-- Invoice Logo-->
                    <div class="clearfix">
                        <div class="float-start mb-2">
                            <span class="logo-lg">
                                <h3 class="mt-0">Outdoor AF</h3>
                            </span>
                        </div>
                        <div class="float-end">
                            <h4 class="m-0 d-print-none">Tagihan</h4>
                        </div>
                    </div>

                    <!-- Invoice Detail-->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="float-end mt-3">
                                <p>Kepada: <b>{{ $billing->order->orderedBy->name }}</b></p>
                                <p class="text-muted font-13">
                                    Untuk bisa disewa, dimohon untuk menyelesaikan pembayaran, di bawah ini adalah rincian biayanya.
                                </p>
                            </div>

                        </div>
                        <div class="col-sm-4 offset-sm-2">
                            <div class="mt-3 float-sm-end">
                                <p class="font-13"><strong>Tanggal Order: </strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ $billing->created_date->translatedFormat('d M Y') }}, {{ $billing->created_at->format('H:i') }}
                                </p>
                                <p class="font-13"><strong>Status Pembayaran:&nbsp;</strong>
                                    @if ($billing->status === 'unpaid')
                                        <span class="font-12 badge bg-warning float-end">Belum dibayar</span>
                                    @elseif ($billing->status === 'waiting')
                                        <span class="font-12 badge bg-primary float-end">Menunggu konfirmasi</span>
                                    @elseif ($billing->status === 'passed')
                                        <span class="font-12 badge bg-danger float-end">Jatuh tempo</span>
                                    @elseif ($billing->status === 'paid')
                                        <span class="font-12 badge bg-success float-end">Sudah dibayar</span>
                                    @else
                                        <span class="font-12 badge bg-secondary float-end">Dibatalkan</span>
                                    @endif
                                </p>
                                <p class="font-13"><strong>Order ID: </strong> <span class="float-end">#{{ $billing->order->order_code }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mt-4">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Produk</th>
                                            <th>Jumlah Pesan</th>
                                            <th>Harga Sewa Per Hari</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($billing->order->orderDetails as $item)
                                            <tr>
                                                <td>{{ ++$count }}</td>
                                                <td>
                                                    <b>{{ $item->equipment->name }}</b>
                                                </td>
                                                <td>{{ $item->amount }}</td>
                                                <td>Rp. {{ number_format($item->equipment->price, 0, '', '.') }}/Hari</td>
                                                <td class="text-end">
                                                    Rp. {{ number_format($item->equipment->price * $item->amount, 0, '', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="clearfix pt-3">
                                <h6 class="text-muted">Catatan:</h6>
                                <small>
                                    Batas waktu bayar adalah selama {{ $payTime }} hari kedepan sejak diterimanyas
                                    faktur ini. Dibayar dengan metode transfer ke salah satu no. hp/rekening berikut.
                                    Jika lewat dari batas pembayaran, maka penyewaan barang akan otomatis dibatalkan.
                                </small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-end mt-3 mt-sm-0">
                                <p><b>Jmlh Hari:</b> <span class="float-end">{{ $numberOfDays }} Hari</span></p>
                                <p><b>Total:</b> <span class="float-end">Rp. {{ number_format($billing->total, 0, '', '.') }}</span></p>
                                <h3>Rp. {{ number_format($billing->total, 0, '', '.') }}</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <h4 class="header-title my-3 text-center">Dimohon kepada: <b>{{ $billing->order->orderedBy->name }}</b> untuk melakukan
                        Pembayaran di salah satu nomor berikut!</h4>

                    <div class="row">
                        @foreach ($paymentMethods as $paymentMethod)
                            <div class="col-md-4 mb-3">
                                <div class="card border-secondary border mb-md-0">
                                    <div class="card-body">
                                        <div class="text-center">
                                            @if (!is_null($paymentMethod->photo))
                                                <img src="{{ asset('storage/image/payment-methods/' . $paymentMethod->photo) }}" width="110px;">
                                            @else
                                                <i class="mdi mdi-truck-fast h2 text-muted"></i>
                                            @endif
                                            <h5><b>{{ $paymentMethod->name }}</b></h5>
                                            <p class="mb-1"><b>Nomor :</b> {{ $paymentMethod->number }}</p>
                                            <p class="mb-0"><b>Payment Mode :</b> Transfer</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-print-none">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin_area.billing.index') }}" class="btn btn-info">Kembali</a>
                            <a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i> Print</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
