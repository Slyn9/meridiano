{{-- Lista de accesos rápidos: <x-dn::quick-link> en 1 columna, o en `columns` (2 o 3) desde 768 px. --}}
@props(['label' => null, 'columns' => 1])
<ul @if ($label) aria-label="{{ $label }}" @endif {{ $attributes->class(['dn-quick-links', 'dn-quick-links--'.$columns => in_array((int) $columns, [2, 3], true)]) }}>{{ $slot }}</ul>
