{{-- Etiqueta + control (slot) + ayuda o error. `for` es el id del control. --}}
@props(['label', 'for' => null, 'hint' => null, 'error' => null])
<div {{ $attributes->class('dn-field') }}>
    <label class="dn-label" @if ($for) for="{{ $for }}" @endif>{{ $label }}</label>
    {{ $slot }}
    @if ($error)
        <p class="dn-error" role="alert">{{ $error }}</p>
    @elseif ($hint)
        <p class="dn-hint">{{ $hint }}</p>
    @endif
</div>
