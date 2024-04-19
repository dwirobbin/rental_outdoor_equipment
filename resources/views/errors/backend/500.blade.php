@extends('layouts.auth-app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-lg-5">
                <div class="card">
                    <div class="card-header py-3 text-center bg-primary">
                        <a href="{{ url('/') }}">
                            <h2 class="my-0 text-light">{{ config('app.name') }}</h2>
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <div class="text-center m-auto">
                            <img src="{{ asset('src/backend/images/startman.svg') }}" height="120" alt="File not found Image">

                            <h1 class="text-error mt-4">500</h1>
                            <h4 class="text-uppercase text-danger mt-3">Internal Server Error</h4>
                            <p class="text-muted mt-3">
                                Mohon maaf, Sepertinya terjadi suatu kesalahan.
                            </p>

                            <a class="btn btn-info mt-3" href="{{ url('/') }}">
                                <i class="mdi mdi-reply"></i> Kembali ke halaman utama
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
