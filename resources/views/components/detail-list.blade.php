{{-- Lista de detalle: <x-dn::detail-item> en dos columnas desde 768 px (etiqueta a la derecha). `stacked` las apila siempre. --}}
@props(['stacked' => false])
<dl {{ $attributes->class(['dn-dl', 'dn-dl--stacked' => $stacked]) }}>{{ $slot }}</dl>
