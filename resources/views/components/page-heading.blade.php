{{-- Encabezado de página: título, descripción opcional, enlace «volver» opcional y acciones (slot) a la derecha. --}}
@props(['title', 'description' => null, 'back' => null, 'backLabel' => 'Volver'])
<div {{ $attributes->class('dn-page-heading') }}>
    <div class="dn-page-heading-main">
        @if ($back)
            <x-dn::button :href="$back" variant="ghost" size="sm" icon="arrow-left" :icon-only="true" :aria-label="$backLabel" />
        @endif
        <div class="dn-card-heading">
            <h1 class="dn-page-title">{{ $title }}</h1>
            @if ($description)
                <p class="dn-page-description">{{ $description }}</p>
            @endif
        </div>
    </div>
    @if ($slot->isNotEmpty())
        <div class="dn-page-actions">{{ $slot }}</div>
    @endif
</div>
