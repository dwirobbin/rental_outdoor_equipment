<div>
    <x-modal :modalTitle="$title" :eventName="$event">
        <form enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" id="name" wire:model='form.name'
                    class="form-control {{ $errors->has('form.name') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                @error('form.name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Harga Sewa</label>
                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="price">Rp.</span>
                    <input type="text" id="price" wire:model='form.price'
                        class="form-control rupiah {{ $errors->has('form.price') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                    <span class="input-group-text" id="stock">/Hari</span>
                </div>
                @error('form.price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stok</label>
                <div class="input-group flex-nowrap">
                    <input type="text" id="stock" wire:model='form.stock'
                        class="form-control {{ $errors->has('form.stock') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                    <span class="input-group-text" id="stock">Item</span>
                </div>
                @error('form.stock')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-1">
                <label for="photo" class="form-label">Foto</label>
                <div class="d-flex justify-content-center mb-1">
                    @if ($form->photo)
                        <img src="{{ $form->photo->temporaryUrl() }}" alt="foto-peralatan" class="rounded" height="75">
                    @else
                        <img src="{{ asset('src/backend/images/no_image.png') }}" alt="Tidak ada gambar" class="rounded" height="75">
                    @endif
                </div>

                <div x-data="{ uploading: false }" x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false"
                    x-on:livewire-upload-error="uploading = false" class="text-center">

                    <span x-text="`Mengunggah...`" x-show="uploading" class="text-danger"></span>

                    <input type="file" id="photo" wire:model='form.photo'
                        class="form-control {{ $errors->has('form.photo') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}">
                    @error('form.photo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </form>
    </x-modal>
</div>
