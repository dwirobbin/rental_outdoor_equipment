<div class="container">
    <div class="row justify-content-center">
        <div class="col-xxl-4 col-lg-5">

            @if (session()->has('message'))
                <div id="alert"
                    class="alert alert-{{ session('message')['type'] }} alert-dismissible bg-{{ session('message')['type'] }} text-white border-0 fade show"
                    role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ session('message')['text'] }}
                </div>
            @endif

            <div class="card">
                <div class="card-header py-3 text-center bg-primary">
                    <a href="{{ route('home') }}">
                        <h2 class="my-0 text-light">{{ config('app.name') }}</h2>
                    </a>
                </div>

                <div class="card-body p-3">
                    <div class="text-center w-75 m-auto">
                        <h4 class="text-dark-50 text-center mt-0 pb-0 fw-bold">Masuk</h4>
                        <p class="text-muted mb-3">
                            Masukkan email dan kata sandi anda untuk tindakan lebih lanjut.
                        </p>
                    </div>

                    <form>
                        <div class="mb-3">
                            <label for="loginId" class="form-label">Email atau Username</label>
                            <input type="text" wire:model='loginId' id="loginId"
                                class="form-control {{ $errors->has('loginId') || $errors->isNotEmpty() ? 'is-invalid' : ($errors->isEmpty() && !is_null($loginId) ? 'is-valid' : '') }}"
                                placeholder="Email atau username.." tabindex="1" autofocus>
                            @error('login_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            {{-- <a href="{{ route('auth.password.forgot') }}" class="text-muted float-end" tabindex="5">
                                <small>Lupa kata sandi?</small>
                            </a> --}}
                            <label for="password" class="form-label">Kata Sandi</label>
                            <div class="input-group input-group-merge">
                                <input type="password" wire:model='password' id="password"
                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                    placeholder="Kata sandi..." tabindex="2">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-0 text-center">
                            <button type="button" wire:click="loginHandler" class="btn btn-primary" wire:loading.attr="disabled" tabindex="3">
                                <span wire:loading wire.target="loginHandler" class="spinner-border spinner-border-sm me-1"
                                    role="status"></span>

                                <i class="mdi mdi-login-variant"></i>
                                <span wire:loading wire.target="loginHandler" role="status">Masuk...</span>

                                <span wire:loading.remove wire.target="loginHandler">Masuk</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="text-muted">
                        Belum punya akun? <a wire:navigate href="{{ route('auth.register') }}" class="text-muted ms-1"
                            tabindex="4"><b>Daftar</b></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('remove-alert', (event) => {
                setTimeout(() => {
                    $("div.alert").remove();
                }, 5000);
            })
        })
    </script>
@endpush
