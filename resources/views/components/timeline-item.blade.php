{{--
    Evento de una <x-dn::timeline>: `title` (qué pasó), `meta` (cuándo y quién), `tone` del punto
    (neutral · primary · success · warning · danger · info) y, en el slot, el detalle opcional.
--}}
@props(['title', 'meta' => null, 'tone' => 'neutral'])
<li {{ $attributes->class(['dn-timeline-item', 'dn-timeline-item--'.$tone => $tone !== 'neutral']) }}>
    <span class="dn-timeline-dot" aria-hidden="true"></span>
    <p class="dn-timeline-title">{{ $title }}</p>
    @if ($meta)
        <p class="dn-timeline-meta">{{ $meta }}</p>
    @endif
    @if ($slot->isNotEmpty())
        <div class="dn-timeline-body">{{ $slot }}</div>
    @endif
</li>
