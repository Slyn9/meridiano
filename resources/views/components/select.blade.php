{{-- Lista desplegable nativa. Los atributos (incluido `wire:model`) llegan al <select>. --}}
@props(['invalid' => false])
<select {{ $attributes->class('dn-select') }} @if ($invalid) aria-invalid="true" @endif>{{ $slot }}</select>
