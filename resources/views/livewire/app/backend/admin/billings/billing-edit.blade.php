<div>
    <x-modal :modalTitle="$title" :eventName="$event">
        <form>
            <div class="mb-1">
                <label for="bill_status" class="form-label">Status</label>
                <select class="form-select {{ $errors->has('form.bill_status') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                    id="bill_status" wire:model='form.bill_status'>
                    <option value="">Pilih Status</option>
                    <option value="unpaid">Belum dibayar</option>
                    <option value="waiting">Menunggu Konfirmasi</option>
                    <option value="passed">Jatuh tempo</option>
                    <option value="paid">Sudah dibayar</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
                @error('form.bill_status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </form>
    </x-modal>
</div>
