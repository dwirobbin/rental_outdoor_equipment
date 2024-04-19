@extends('layouts.backend-app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">403 Error</h4>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="text-center">

                    <h1 class="text-error mt-4">403</h1>
                    <h4 class="text-uppercase text-danger mt-3">Akses ditolak</h4>
                    <p class="text-muted mt-3">
                        Mohon maaf, anda tidak dapat mengunjungi halaman yang bukan ditujukan untuk peran anda.
                    </p>

                    <a class="btn btn-info mt-3" href="javascript:history.back()">
                        <i class="mdi mdi-reply"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
