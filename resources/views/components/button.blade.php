{{--
    Botón de Meridiano. variant: secondary (por defecto) · primary · ghost · danger · danger-subtle.
    Con `href` es un enlace. Un botón solo con ícono (`iconOnly`) exige `aria-label`.
--}}
@props(['variant' => 'secondary', 'size' => null, 'href' => null, 'icon' => null, 'iconOnly' => false])
@php
    $classes = [
        'dn-btn',
        'dn-btn--'.$variant => $variant !== 'secondary',
        'dn-btn--sm' => $size === 'sm',
        'dn-btn--icon' => $iconOnly,
    ];
    $iconSize = $size === 'sm' ? 14 : 16;
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>@if ($icon)<x-dn::icon :name="$icon" :size="$iconSize" />@endif{{ $slot }}</a>
@else
    <button {{ $attributes->class($classes)->merge(['type' => 'button']) }}>@if ($icon)<x-dn::icon :name="$icon" :size="$iconSize" />@endif{{ $slot }}</button>
@endif
