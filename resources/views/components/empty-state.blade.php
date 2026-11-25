{{-- Estado vacío: ícono, título, explicación y, en el slot, la acción (si aplica). --}}
@props(['title', 'hint' => null, 'icon' => 'search'])
<div {{ $attributes->class('dn-empty') }}>
    <x-dn::icon :name="$icon" size="28" class="dn-empty-icon" />
    <p class="dn-empty-title">{{ $title }}</p>
    @if ($hint)
        <p class="dn-empty-hint">{{ $hint }}</p>
    @endif
    @if ($slot->isNotEmpty())
        <div class="dn-empty-hint">{{ $slot }}</div>
    @endif
</div>
