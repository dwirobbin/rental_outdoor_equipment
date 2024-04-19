@php
    if (! isset($scrollTo)) {
        $scrollTo = 'body';
    }

    $scrollIntoViewJsSnippet = ($scrollTo !== false)
        ? <<<JS
            (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView();
        JS
        : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav class="d-flex flex-wrap justify-content-center justify-content-sm-between align-items-center mb-0" role="navigation" aria-label="Page navigation example">
            <div>
                <p class="font-13 text-muted my-auto">
                    {!! __('Tampil') !!}
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    {!! __('sampai') !!}
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    {!! __('dari') !!}
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    {!! __('data') !!}
                </p>
            </div>

            <div>
                <ul class="pagination mb-0">
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link" aria-hidden="true">&laquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <button class="page-link" wire:click="previousPage" wire:loading.attr="disabled" rel="prev">
                                &laquo;
                            </button>
                        </li>
                    @endif

                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}"
                                        aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}"><button
                                            type="button" class="page-link"
                                            wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                            x-on:click="{{ $scrollIntoViewJsSnippet }}">{{ $page }}</button></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->onLastPage())
                        <li class="page-item disabled">
                            <span class="page-link" aria-hidden="true">&raquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <button class="page-link" wire:click="nextPage" wire:loading.attr="disabled" rel="next">
                                &raquo;
                            </button>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    @endif
</div>
