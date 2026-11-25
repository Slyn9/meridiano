{{--
    Alerta en la página (no flota): tone neutral · info · success · warning · danger, con su ícono.
    No se cierra sola: debe seguir visible mientras la condición siga vigente.
--}}
@props(['tone' => 'info', 'title' => null])
@php
    $icon = ['success' => 'circle-check', 'warning' => 'triangle-alert', 'danger' => 'circle-x'][$tone] ?? 'info';
@endphp
<div {{ $attributes->class(['dn-alert', 'dn-alert--'.$tone => $tone !== 'neutral']) }} role="{{ in_array($tone, ['warning', 'danger'], true) ? 'alert' : 'status' }}">
    <x-dn::icon :name="$icon" />
    <div>
        @if ($title)
            <p class="dn-alert-title">{{ $title }}</p>
        @endif
        <p>{{ $slot }}</p>
    </div>
</div>
