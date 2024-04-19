<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col">
                            <div class="card shadow-none m-0">
                                <div class="card-header">
                                    <select class="form-select form-select-sm" wire:model.live='billStatus'>
                                        <option value="waiting">Menunggu Konfirmasi</option>
                                        <option value="unpaid">Belum dibayar</option>
                                        <option value="passed">Jatuh tempo</option>
                                        <option value="paid">Sudah dibayar</option>
                                        <option value="cancelled">Dibatalkan</option>
                                    </select>
                                </div>
                                <div class="card-body text-center">
                                    <i class="uil-bill text-muted" style="font-size: 24px;"></i>
                                    <h3><span>{{ $count_data['bill'] }}</span></h3>
                                    <p class="text-muted font-15 mb-0">Total Tagihan</p>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card shadow-none m-0 border-start">
                                <div class="card-header">
                                    <select class="form-select form-select-sm" wire:model.live='orderStatus'>
                                        <option value="waiting">Menunggu Konfirmasi</option>
                                        <option value="pending">Pending</option>
                                        <option value="cancelled">Dibatalkan</option>
                                        <option value="rented">Sedang disewa</option>
                                        <option value="passed">Jatuh tempo</option>
                                        <option value="returned">Sudah dikembalikan</option>
                                    </select>
                                </div>
                                <div class="card-body text-center">
                                    <i class="uil-clipboard-alt text-muted" style="font-size: 24px;"></i>
                                    <h3><span>{{ $count_data['order'] }}</span></h3>
                                    <p class="text-muted font-15 mb-0">Total Pesanan</p>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card shadow-none m-0 border-start h-100">
                                <div class="card-header" style="margin-top: 10px">
                                    Akun
                                </div>
                                <div class="card-body text-center">
                                    <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                    <h3><span>{{ $count_data['user'] }}</span></h3>
                                    <p class="text-muted font-15 mb-0">Total Pengguna</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
