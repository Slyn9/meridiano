{{--
    Fila de tabla que despliega un detalle debajo (Alpine). Se usa como un <tbody> propio por registro
    (una tabla admite varios), dentro de un <table class="dn-table">:

        <x-dn::expandable-row :row-key="'client-'.$client->id" :colspan="5" label="Ver detalle de {{ $client->name }}">
            <td>…</td><td>…</td>            ← celdas de la fila (después de la del botón)
            <x-slot:detail>…</x-slot:detail> ← contenido del detalle
        </x-dn::expandable-row>

    `colspan` = columnas de la tabla, incluida la del botón. Los demás atributos (p. ej. @click, :aria-selected)
    van al <tr> principal. El botón anuncia su estado con aria-expanded y apunta al detalle con aria-controls.
--}}
@props(['rowKey', 'colspan', 'label' => 'Ver detalle', 'open' => false])
@php $detailId = 'dn-detail-'.\Illuminate\Support\Str::slug((string) $rowKey); @endphp
<tbody x-data="{ open: {{ $open ? 'true' : 'false' }} }" wire:key="{{ $rowKey }}">
    <tr {{ $attributes }}>
        <td class="dn-expand-cell">
            <button type="button" class="dn-expand-btn" @click.stop="open = !open" :aria-expanded="open.toString()" aria-expanded="{{ $open ? 'true' : 'false' }}" aria-controls="{{ $detailId }}" aria-label="{{ $label }}">
                <x-dn::icon name="chevron-right" />
            </button>
        </td>
        {{ $slot }}
    </tr>
    <tr id="{{ $detailId }}" class="dn-row-detail" @if (! $open) hidden @endif :hidden="! open">
        <td colspan="{{ $colspan }}">{{ $detail }}</td>
    </tr>
</tbody>
