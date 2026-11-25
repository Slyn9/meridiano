<?php

namespace Slyn9\Meridiano;

use Illuminate\Support\ServiceProvider;

/**
 * Registra las vistas del paquete bajo el espacio `dn`:
 *  - componentes Blade anónimos: `<x-dn::card>`, `<x-dn::badge>`, `<x-dn::icon>`…
 *    (resources/views/components)
 *  - vistas sueltas: `dn::pagination.livewire` (paginación de un componente Livewire).
 *
 * No publica CSS: cada app lo importa desde vendor/ en su entrada de Vite.
 */
class MeridianoServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'dn');
    }
}
