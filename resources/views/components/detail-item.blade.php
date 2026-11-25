{{-- Fila de <x-dn::detail-list>: etiqueta (`label`) y valor (slot). --}}
@props(['label'])
<div {{ $attributes->class('dn-dl-row') }}>
    <dt>{{ $label }}</dt>
    <dd>{{ $slot }}</dd>
</div>
