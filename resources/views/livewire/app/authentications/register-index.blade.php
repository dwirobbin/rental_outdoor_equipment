<div class="container">
    <div class="row justify-content-center">
        <div class="col-xxl-5 col-lg-7">

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
                        <h3 class="my-0 text-light">{{ config('app.name') }}</h3>
                    </a>
                </div>

                <div class="card-body p-3">
                    <div class="text-center w-75 m-auto">
                        <h4 class="text-dark-50 text-center mt-0 pb-0 fw-bold">Daftar Akun</h4>
                        <p class="text-muted mb-3">
                            Belum punya akun? Ayo buat akun anda, ini hanya butuh beberapa menit saja.
                        </p>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" wire:model='form.name' id="name"
                            class="form-control {{ $errors->has('form.name') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                            placeholder="Nama...">
                        @error('form.name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" wire:model='form.username' id="username"
                                class="form-control {{ $errors->has('form.username') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                placeholder="Username...">
                            @error('form.username')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="emailaddress" class="form-label">Email</label>
                            <input type="email" wire:model='form.email' id="emailaddress"
                                class="form-control {{ $errors->has('form.email') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                placeholder="Email...">
                            @error('form.email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <div class="input-group input-group-merge">
                                <input type="password" wire:model='form.password' id="password"
                                    class="form-control {{ $errors->has('form.password') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                    placeholder="Password...">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                            @error('form.password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="passwordConfirmation" class="form-label">Konfirmasi Kata Sandi</label>
                            <div class="input-group input-group-merge">
                                <input type="password" wire:model='form.password_confirmation' id="passwordConfirmation"
                                    class="form-control {{ $errors->has('form.password_confirmation') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                    placeholder="Konfirmasi Kata Sandi">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                            @error('form.password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-0 mt-1 text-center">
                        <button type="button" wire:click="save" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading wire.target="save" class="spinner-border spinner-border-sm me-1" role="status"></span>

                            <i class="mdi mdi-send"></i>
                            <span wire:loading wire.target="save" role="status">Mendaftar...</span>

                            <span wire:loading.remove wire.target="save">Daftar</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="text-muted">
                        Sudah punya akun? <a wire:navigate href="{{ route('auth.login') }}" class="text-muted ms-1"><b>Log In</b></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('remove-alert', () => {
                setTimeout(() => {
                    $("div.alert").remove();
                }, 5000);
            })
        })
    </script>
@endpush
