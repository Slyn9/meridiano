{{--
    Paginación de Meridiano para un componente Livewire. Uso, dentro del componente:
        {{ $items->links('dn::pagination.livewire') }}
    Usa los métodos que Livewire agrega con WithPagination (previousPage, nextPage, gotoPage) y siempre
    muestra el conteo («Mostrando 1–10 de 48»), también cuando hay una sola página.
--}}
@php
    if (! isset($scrollTo)) {
        $scrollTo = 'body';
    }

    $scrollIntoView = $scrollTo !== false
        ? "(\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()"
        : '';
    $pageName = $paginator->getPageName();
@endphp

<nav class="dn-pagination" aria-label="Paginación">
    <p>
        @if ($paginator->total() > 0)
            Mostrando {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} de {{ $paginator->total() }}
        @else
            Sin resultados
        @endif
    </p>

    @if ($paginator->hasPages())
        <div class="dn-pagination-pages">
            <button type="button" class="dn-page" wire:click="previousPage('{{ $pageName }}')" x-on:click="{{ $scrollIntoView }}" wire:loading.attr="disabled" aria-label="Página anterior" @disabled($paginator->onFirstPage())>
                <x-dn::icon name="chevron-left" />
            </button>

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="dn-page" aria-hidden="true">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <button type="button" class="dn-page" wire:key="paginator-{{ $pageName }}-page-{{ $page }}" wire:click="gotoPage({{ $page }}, '{{ $pageName }}')" x-on:click="{{ $scrollIntoView }}" @if ($page == $paginator->currentPage()) aria-current="page" @endif aria-label="Página {{ $page }}">{{ $page }}</button>
                    @endforeach
                @endif
            @endforeach

            <button type="button" class="dn-page" wire:click="nextPage('{{ $pageName }}')" x-on:click="{{ $scrollIntoView }}" wire:loading.attr="disabled" aria-label="Página siguiente" @disabled(! $paginator->hasMorePages())>
                <x-dn::icon name="chevron-right" />
            </button>
        </div>
    @endif
</nav>
