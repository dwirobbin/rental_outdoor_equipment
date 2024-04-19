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
                        <h4 class="text-dark-50 text-center mt-0 pb-0 fw-bold">Kata Sandi baru</h4>
                        <p class="text-muted mb-3">
                            Buat kata sandi baru.
                        </p>
                    </div>

                    <form>
                        <input type="text" name="token" hidden wire:model='token'>

                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi Baru</label>
                            <div class="input-group input-group-merge">
                                <input type="password" wire:model='password' id="password"
                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                    placeholder="kata Sandi...">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="passwordConfirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                            <div class="input-group input-group-merge">
                                <input type="password" wire:model='password_confirmation' id="passwordConfirmation"
                                    class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                    placeholder="kata Sandi Konfirmasi...">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-0 text-center">
                            <button type="button" wire:click="submitResetPasswordForm" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading wire.target="submitResetPasswordForm" class="spinner-border spinner-border-sm me-1"
                                    role="status"></span>

                                <i class="mdi mdi-content-save"></i>
                                <span wire:loading wire.target="submitResetPasswordForm" role="status">Sedang diubah...</span>

                                <span wire:loading.remove wire.target="submitResetPasswordForm">Ubah Kata sandi</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="text-muted">
                        Belum punya akun? <a wire:navigate href="{{ route('auth.register') }}" class="text-muted ms-1"><b>Daftar</b></a>
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
