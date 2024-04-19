<div>
    <x-modal :modalTitle="$title" :eventName="$event">
        <form>
            <div class="mb-1">
                <label for="order_status" class="form-label">Status</label>
                <select class="form-select {{ $errors->has('form.order_status') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                    id="order_status" wire:model='form.order_status'>
                    <option value="">Pilih Status</option>
                    <option value="waiting">Waiting</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Dibatalkan</option>
                    <option value="passed">Jatuh tempo</option>
                    <option value="rented">Sedang disewa</option>
                    <option value="returned">Sudah dikembalikan</option>
                </select>
                @error('form.order_status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </form>
    </x-modal>
</div>
