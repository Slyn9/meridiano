{{--
    Insignia de estado. tone: neutral · success · warning · danger · info · primary.
    La variante sólida (`solid`) es solo para estados finales y debe llevar ícono. El texto siempre dice el estado.
--}}
@props(['tone' => 'neutral', 'icon' => null, 'solid' => false])
<span {{ $attributes->class(['dn-badge', 'dn-badge--'.$tone => $tone !== 'neutral', 'dn-badge--solid' => $solid]) }}>@if ($icon)<x-dn::icon :name="$icon" size="12" />@endif{{ $slot }}</span>
