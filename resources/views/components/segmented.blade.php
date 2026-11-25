{{-- Filtro segmentado: grupo de <x-dn::segmented-item>. `label` nombra el grupo para lectores de pantalla. --}}
@props(['label'])
<div role="group" aria-label="{{ $label }}" {{ $attributes->class('dn-segmented') }}>{{ $slot }}</div>
