{{-- Campo de búsqueda con ícono. `label` es su nombre accesible; los atributos (incluido `wire:model`) llegan al <input>. --}}
@props(['label' => 'Buscar'])
<div class="dn-search">
    <x-dn::icon name="search" />
    <input aria-label="{{ $label }}" {{ $attributes->class('dn-input')->merge(['type' => 'search']) }}>
</div>
