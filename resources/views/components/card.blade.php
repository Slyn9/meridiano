{{--
    Tarjeta: superficie sobre el fondo. `title` (y opcionalmente `subtitle`, `icon`) arma el encabezado;
    el slot `actions` va a su derecha. `flush` quita el padding del cuerpo (para tablas).
--}}
@props(['title' => null, 'subtitle' => null, 'icon' => null, 'flush' => false])
<div {{ $attributes->class('dn-card') }}>
    @if ($title || isset($actions))
        <div class="dn-card-header">
            <div class="dn-card-heading">
                @if ($title)
                    <h2 class="dn-card-title">@if ($icon)<x-dn::icon :name="$icon" class="dn-muted" />@endif{{ $title }}</h2>
                @endif
                @if ($subtitle)
                    <p class="dn-card-subtitle">{{ $subtitle }}</p>
                @endif
            </div>
            {{ $actions ?? '' }}
        </div>
    @endif
    @if ($flush)
        {{ $slot }}
    @else
        <div class="dn-card-body">{{ $slot }}</div>
    @endif
</div>
