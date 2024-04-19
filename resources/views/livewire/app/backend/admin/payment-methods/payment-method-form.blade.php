<div class="card">
    <div class="card-header py-1">
        <h5>
            {{ $isUpdate ? 'Edit Metode Pembayaran' : 'Tambah Metode Pembayaran' }}
        </h5>
    </div>
    <form enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" id="name" wire:model='form.name'
                    class="form-control {{ $errors->has('form.name') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                    placeholder="">
                @error('form.name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="number" class="form-label">Nomor</label>
                <input type="text" id="number" wire:model='form.number'
                    class="form-control {{ $errors->has('form.number') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                    placeholder="">
                @error('form.number')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-1">
                <label for="photo" class="form-label">Foto</label>
                <div class="d-flex justify-content-center mb-1">
                    @if ($isUpdate)
                        @if (!is_null($form->photo) && is_null($form->new_photo))
                            <img src="{{ asset('storage/image/payment-methods/' . $form->photo) }}" alt="foto-peralatan" class="rounded"
                                height="75">
                        @elseif (!is_null($form->new_photo))
                            <img src="{{ $form->new_photo->temporaryUrl() }}" alt="foto-peralatan-sementara" class="rounded" height="75">
                        @else
                            <img src="{{ asset('src/backend/images/no_image.png') }}" alt="Tidak ada gambar" class="rounded" height="75">
                        @endif
                    @else
                        @if ($form->photo)
                            <img src="{{ $form->photo->temporaryUrl() }}" alt="foto-peralatan-sementara" class="rounded" height="75">
                        @else
                            <img src="{{ asset('src/backend/images/no_image.png') }}" alt="Tidak ada gambar" class="rounded" height="75">
                        @endif
                    @endif

                </div>

                <div x-data="{ uploading: false }" x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false"
                    x-on:livewire-upload-error="uploading = false" class="text-center">

                    <span x-text="`Mengunggah...`" x-show="uploading" class="text-danger"></span>

                    @if ($isUpdate)
                        <input type="file" id="new_photo" wire:model='form.new_photo'
                            class="form-control {{ $errors->has('form.new_photo') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                        @error('form.new_photo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    @else
                        <input type="file" id="photo" wire:model='form.photo'
                            class="form-control {{ $errors->has('form.photo') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">

                        @error('form.photo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer text-muted d-flex justify-content-between">
            <button type="button" wire:click='resetForm' class="btn btn-secondary" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="resetForm">Reset</span>

                <span wire:loading wire:target="resetForm" class="spinner-border spinner-border-sm"></span>
                <span wire:loading wire:target="resetForm" role="status">Loading..</span>
            </button>
            @if ($isUpdate)
                <button type="button" wire:click='update' class="btn btn-success" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="update">Simpan Perubahan</span>

                    <span wire:loading wire:target="update" class="spinner-border spinner-border-sm"></span>
                    <span wire:loading wire:target="update" role="status">Menyimpan..</span>
                </button>
            @else
                <button type="button" wire:click='store' class="btn btn-success" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="store">Simpan</span>

                    <span wire:loading wire:target="store" class="spinner-border spinner-border-sm"></span>
                    <span wire:loading wire:target="store" role="status">Menyimpan..</span>
                </button>
            @endif
        </div>
    </form>
</div>
