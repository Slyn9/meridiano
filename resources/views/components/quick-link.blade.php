{{-- Acceso rápido: ícono en un cuadro tenue, título (el enlace) y una línea de descripción. Toda la fila es el enlace. --}}
@props(['href', 'title', 'description' => null, 'icon' => 'chevron-right'])
<li>
    <a href="{{ $href }}" {{ $attributes->class('dn-quick-link') }}>
        <span class="dn-quick-link-icon" aria-hidden="true"><x-dn::icon :name="$icon" size="18" /></span>
        <span class="dn-quick-link-text">
            <span class="dn-quick-link-title">{{ $title }}</span>
            @if ($description)
                <span class="dn-quick-link-desc">{{ $description }}</span>
            @endif
        </span>
    </a>
</li>
