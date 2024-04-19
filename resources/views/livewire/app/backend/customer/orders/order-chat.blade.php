<div wire:ignore.self class="modal fade" id="{{ $event }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" x-on:click="$dispatch('{{ $event }}-close')" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="conversation-list" data-simplebar="" style="max-height: 537px">
                    @foreach ($messages as $message)
                        <li class="clearfix {{ $message->user_id === auth()->id() ? 'odd' : '' }}">
                            <p class="font-12" style='margin-bottom: 3px;'>{{ $message->created_at->translatedFormat('d F Y') }}</p>
                            <div class="chat-avatar">
                                <img src="{{ !is_null($message->user->photo) ? asset('storage/image/users/' . $message->user->photo) : asset('src/backend/images/no_image.png') }}"
                                    class="rounded" alt="">
                                <i>{{ $message->created_at->format('H:i') }}</i>
                            </div>
                            <div class="conversation-text">
                                <div class="ctext-wrap">
                                    <i>{{ $message->user->name }}</i>
                                    <p class="text-left">
                                        {{ $message->body }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer justify-content-center">
                <div class="bg-light p-3 rounded w-100">
                    <form class="needs-validation" name="chat-form" id="chat-form" wire:submit='saveMessage'>
                        @csrf
                        <div class="row">
                            <div class="col mb-2 mb-sm-0">
                                <input type="text" wire:model='body'
                                    class="form-control border-0 {{ $errors->has('body') ? 'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
                                    placeholder="Masukkan Pesan">
                                @error('body')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-auto">
                                <div class="btn-group">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success chat-send"><i class='uil uil-message'></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
