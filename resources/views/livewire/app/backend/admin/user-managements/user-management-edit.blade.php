<div>
    <x-modal :modalTitle="$title" :eventName="$event" modalSize="modal-lg">
        <form enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" id="name" wire:model='form.name'
                        class="form-control {{ $errors->has('form.name') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                    @error('form.name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" wire:model='form.username'
                        class="form-control @error('form.username') is-invalid @enderror">
                    @error('form.username')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" wire:model='form.email'
                        class="form-control {{ $errors->has('form.email') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                    @error('form.email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select {{ $errors->has('form.role') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                        id="role" wire:model='form.role'>
                        <option value="">Pilih Peran</option>
                        <option value="admin">Admin</option>
                        <option value="customer">Customer</option>
                    </select>
                    @error('form.role')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="current_password" class="form-label">Kata Sandi Saat ini</label>
                    <div class="input-group input-group-merge">
                        <input type="password" wire:model='form.current_password' id="current_password"
                            class="form-control {{ $errors->has('form.current_password') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                            placeholder="Kata sandi saat ini...">
                        <div class="input-group-text" data-password="false">
                            <span class="password-eye"></span>
                        </div>
                    </div>
                    @error('form.current_password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="newPassword" class="form-label">Kata Sandi Baru</label>
                    <div class="input-group input-group-merge">
                        <input type="password" wire:model='form.password' id="newPassword"
                            class="form-control {{ $errors->has('form.password') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                            placeholder="Kata sandi baru...">
                        <div class="input-group-text" data-password="false">
                            <span class="password-eye"></span>
                        </div>
                    </div>
                    @error('form.password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Foto</label>
                <div class="d-flex justify-content-center mb-1">
                    @if ($form->new_photo)
                        <img src="{{ $form->new_photo->temporaryUrl() }}" alt="foto-user" class="rounded" height="75">
                    @else
                        <img src="{{ !is_null($form->photo) ? asset('storage/image/users/' . $form->photo) : asset('src/backend/images/no_image.png') }}"
                            alt="Tidak ada gambar" class="rounded" height="75">
                    @endif
                </div>

                <div x-data="{ uploading: false }" x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false"
                    x-on:livewire-upload-error="uploading = false" class="text-center">

                    <span x-text="`Mengunggah...`" x-show="uploading" class="text-danger"></span>

                    <input type="file" id="photo" wire:model='form.new_photo'
                        class="form-control {{ $errors->has('form.new_photo') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                    @error('form.new_photo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </form>
    </x-modal>
</div>
