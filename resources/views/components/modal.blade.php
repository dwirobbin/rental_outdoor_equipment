@props(['modalTitle', 'eventName', 'modalSize' => null])

<div wire:ignore.self class="modal fade" id="{{ $eventName }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog {{ $modalSize }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modalTitle }}</h5>
                <button type="button" x-on:click="$dispatch('{{ $eventName }}-close')" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @isset($slot)
                    {{ $slot }}
                @endisset
            </div>
            <div class="modal-footer">
                <button type="button" x-on:click="$dispatch('{{ $eventName }}-close')" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button x-on:click="$dispatch('{{ $eventName }}')" type="button" class="btn btn-success" wire:loading.attr="disabled">
                    <span wire:loading.remove wire.target="{{ $eventName }}">Simpan</span>

                    <span wire:loading wire.target="{{ $eventName }}" class="spinner-border spinner-border-sm"></span>
                    <span wire:loading wire.target="{{ $eventName }}" role="status">Menyimpan..</span>
                </button>
            </div>
        </div>
    </div>
</div>
