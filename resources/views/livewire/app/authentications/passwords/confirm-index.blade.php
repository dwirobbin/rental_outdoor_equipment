 <div class="container">
     <div class="row justify-content-center">
         <div class="col-xxl-4 col-lg-5">
             <div class="card">
                 <div class="card-header py-3 text-center bg-primary">
                     <a href="{{ route('home') }}">
                         <h2 class="my-0 text-light">{{ config('app.name') }}</h2>
                     </a>
                 </div>

                 <div class="card-body p-3">
                     <div class="text-center m-auto">
                         <img src="{{ asset('src/backend/images/mail_sent.svg') }}" alt="mail sent image" height="64" />
                         <h4 class="text-dark-50 text-center mt-4 fw-bold">Silahkan cek email anda!</h4>
                         <p class="text-muted mb-4">
                             Kami telah mengirimkan tautan reset kata sandi ke email <b>{{ $email ?? 'anda' }}</b>.
                             Silahkan cek email anda dan klik tautan yang disertakan untuk melakukan reset kata sandi.
                         </p>
                     </div>

                     <div class="mb-0 text-center">
                         <a wire:navigate href="{{ route('auth.login') }}" class="btn btn-primary">
                             <i class="mdi mdi-login-variant me-1"></i>Kembali ke Log In
                         </a>
                     </div>
                 </div>

             </div>
         </div>
     </div>
 </div>
