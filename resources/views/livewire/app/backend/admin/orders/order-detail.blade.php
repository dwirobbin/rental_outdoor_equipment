<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pesanan</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
                <h4 class="page-title">Detail Pesanan</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    @if ($order->status === 'pending')
                        <span class="font-12 badge bg-warning float-end">Pending</span>
                    @elseif ($order->status === 'waiting')
                        <span class="font-12 badge bg-info float-end">Menunggu Konfirmasi</span>
                    @elseif ($order->status === 'rented')
                        <span class="font-12 badge bg-success float-end">Sedang disewa</span>
                    @elseif ($order->status === 'passed')
                        <span class="font-12 badge bg-danger float-end">Jatuh tempo</span>
                    @elseif ($order->status === 'returned')
                        <span class="font-12 badge bg-primary float-end">Sudah dikembalikan</span>
                    @else
                        <span class="font-12 badge bg-secondary float-end">Dibatalkan</span>
                    @endif
                    <h4 class="header-title mb-3">No. Order #{{ $order->order_code }}</h4>
                    <div class="table-responsive">
                        <table class="table mb-0 table-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Jumlah Pesan</th>
                                    <th>Harga Sewa</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($order->orderDetails as $item)
                                    <tr class="align-middle">
                                        <td>{{ ++$count }}</td>
                                        <td class="text-center">
                                            <a href="{{ !is_null($item->equipment->photo) ? asset('storage/image/equipments/' . $item->equipment->photo) : asset('src/backend/images/no_image.png') }}"
                                                target="_blank" rel="noopener noreferrer">
                                                <img src="{{ !is_null($item->equipment->photo) ? asset('storage/image/equipments/' . $item->equipment->photo) : asset('src/backend/images/no_image.png') }}"
                                                    alt="equipment-img" title="equipment-img" class="rounded  mx-auto" height="50"
                                                    width="70">
                                            </a>
                                            <p class="m-0 d-block align-middle font-15 text-body fw-semibold">
                                                {{ $item->equipment->name }}
                                            </p>
                                        </td>
                                        <td>{{ $item->amount }}</td>
                                        <td>Rp. {{ number_format($item->equipment->price, 0, '', '.') }} /Hari</td>
                                        <td>Rp. {{ number_format($item->equipment->price * $item->amount, 0, '', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Ringkasan Pesanan</h4>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Deskripsi</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Jumlah Hari :</td>
                                    <td>{{ $numberOfDays }} Hari</td>
                                </tr>
                                <tr>
                                    <td>Total Semuanya :</td>
                                    <td>Rp. {{ number_format($order->billing->total, 0, '', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Bayar:</th>
                                    <th>Rp. {{ number_format($order->billing->total, 0, '', '.') }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-2">
            <a href="{{ route('admin_area.order.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>

</div>
