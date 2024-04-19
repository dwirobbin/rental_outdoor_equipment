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
                         <h4 class="text-dark-50 text-center mt-0 fw-bold">Atur Ulang Kata Sandi</h4>
                         <p class="text-muted mb-4">
                             Masukkan alamat email Anda dan kami akan mengirimkan email
                             berisi instruksi untuk mengatur ulang kata sandi Anda.
                         </p>
                     </div>

                     <form wire:submit='submitForgetPasswordForm'>
                         <div class="mb-3">
                             <label for="emailaddress" class="form-label">Email</label>
                             <input type="email" id="emailaddress" wire:model='email'
                                 class="form-control {{ $errors->has('email') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                 placeholder="Email...">
                             @error('email')
                                 <small class="text-danger">{{ $message }}</small>
                             @enderror
                         </div>

                         <div class="mb-0 text-center">
                             <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                 <span wire:loading wire.target="submitForgetPasswordForm" class="spinner-border spinner-border-sm me-1"
                                     role="status"></span>

                                 <i class="mdi mdi-send"></i>
                                 <span wire:loading wire.target="submitForgetPasswordForm" role="status">Sedang mengirim...</span>

                                 <span wire:loading.remove wire.target="submitForgetPasswordForm">Kirim tautan</span>
                             </button>
                         </div>
                     </form>
                 </div>
             </div>

             <div class="row mt-3">
                 <div class="col-12 text-center">
                     <p class="text-muted">
                         Kembali ke <a wire:navigate href="{{ route('auth.login') }}" class="text-muted ms-1"><b>Log In</b></a>
                     </p>
                 </div>
             </div>
         </div>
     </div>
 </div>
