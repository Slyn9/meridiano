{{--
    Flujo de pasos (solo lectura): dónde está un proceso dentro de su secuencia.
    `steps`: lista de ['label' => …, 'state' => 'done'|'current'|'pending', 'meta' => …?, 'href' => …?].
    Horizontal desde 640 px; `vertical` lo deja apilado siempre (columnas angostas).
    El estado no depende del color: cada paso lleva su estado en texto para lectores de pantalla.
--}}
@props(['label', 'steps' => [], 'vertical' => false])
@php
    $stateText = ['done' => 'completado', 'current' => 'paso actual', 'pending' => 'pendiente'];
@endphp
<ol aria-label="{{ $label }}" {{ $attributes->class(['dn-process', 'dn-process--vertical' => $vertical]) }}>
    @foreach ($steps as $index => $step)
        @php $state = $step['state'] ?? 'pending'; @endphp
        @if ($index > 0)
            <li class="dn-process-sep" aria-hidden="true"><x-dn::icon name="chevrons-right" size="14" /></li>
        @endif
        <li class="dn-process-step" data-state="{{ $state }}" @if ($state === 'current') aria-current="step" @endif>
            <span class="dn-process-marker" aria-hidden="true">
                @if ($state === 'done')
                    <x-dn::icon name="check" size="14" />
                @else
                    {{ $index + 1 }}
                @endif
            </span>
            <span class="dn-process-text">
                @if (! empty($step['href']))
                    <a href="{{ $step['href'] }}" class="dn-process-label">{{ $step['label'] }}</a>
                @else
                    <span class="dn-process-label">{{ $step['label'] }}</span>
                @endif
                <span class="dn-sr-only">({{ $stateText[$state] ?? $state }})</span>
                @if (! empty($step['meta']))
                    <span class="dn-process-meta">{{ $step['meta'] }}</span>
                @endif
            </span>
        </li>
    @endforeach
</ol>
