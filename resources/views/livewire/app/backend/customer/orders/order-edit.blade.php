<div>
    <x-modal :modalTitle="$title" :eventName="$event">
        <form>
            <div class="mb-1">
                <label for="photo" class="form-label">Gambar</label>
                <div class="d-flex justify-content-center mb-1">
                    @if ($form->new_photo)
                        <img src="{{ $form->new_photo->temporaryUrl() }}" alt="foto-user" class="rounded" height="75">
                    @else
                        <img src="{{ !is_null($form->photo) ? asset('storage/image/orders/' . $form->photo) : asset('src/backend/images/no_image.png') }}"
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
