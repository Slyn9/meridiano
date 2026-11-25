{{-- Línea de tiempo vertical: lista ordenada de <x-dn::timeline-item>, de lo más reciente a lo más antiguo o al revés, según el uso. --}}
@props(['label'])
<ol aria-label="{{ $label }}" {{ $attributes->class('dn-timeline') }}>{{ $slot }}</ol>
