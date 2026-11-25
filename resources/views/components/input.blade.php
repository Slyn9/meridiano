{{-- Campo de texto. Los atributos (incluido `wire:model`) llegan al <input>. `invalid` marca el error para lectores de pantalla. --}}
@props(['invalid' => false])
<input {{ $attributes->class('dn-input')->merge(['type' => 'text']) }} @if ($invalid) aria-invalid="true" @endif>
