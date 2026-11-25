{{-- Ícono lucide incluido en el paquete. Decorativo por defecto (aria-hidden); con `label`, es una imagen con nombre. --}}
@props(['name', 'size' => 16, 'label' => null])
<svg xmlns="http://www.w3.org/2000/svg" width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" {{ $attributes->class('dn-icon') }} @if ($label) role="img" aria-label="{{ $label }}" @else aria-hidden="true" focusable="false" @endif>{!! \Slyn9\Meridiano\Icons::inner($name) !!}</svg>
