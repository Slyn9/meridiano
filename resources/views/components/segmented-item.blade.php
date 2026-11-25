{{-- Opción de un filtro segmentado. `pressed` = la opción elegida. Los atributos (p. ej. `wire:click`) llegan al botón. --}}
@props(['pressed' => false])
<button type="button" aria-pressed="{{ $pressed ? 'true' : 'false' }}" {{ $attributes->class('dn-segmented-item') }}>{{ $slot }}</button>
