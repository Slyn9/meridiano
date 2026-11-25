{{--
    Encabezado de columna ordenable (<th>). `column` es la clave de esta columna; `sortBy`/`sortDir` el orden actual.
    Los atributos (p. ej. wire:click con el método de orden) llegan al botón; `thClass` va al <th>.
--}}
@props(['column', 'sortBy' => null, 'sortDir' => 'asc', 'thClass' => null])
@php
    $active = $sortBy === $column;
    $icon = $active ? ($sortDir === 'asc' ? 'arrow-up' : 'arrow-down') : 'arrow-up-down';
@endphp
<th @if ($thClass) class="{{ $thClass }}" @endif @if ($active) aria-sort="{{ $sortDir === 'asc' ? 'ascending' : 'descending' }}" @endif>
    <button type="button" {{ $attributes->class('dn-sort') }}>{{ $slot }}<x-dn::icon :name="$icon" size="14" /></button>
</th>
