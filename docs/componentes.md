# Componentes

Reglas visuales y de comportamiento de cada componente común. Valen igual para la versión React y la versión Blade: la apariencia sale de los tokens, el comportamiento accesible de la herramienta de cada stack (Radix en React, Alpine en Blade).

| Componente | Reglas |
| --- | --- |
| **Botón** | Jerarquía única: `primary` (relleno `--dn-primary-fill`, a lo sumo uno por vista para la acción principal), `secondary` (con borde), `ghost` (sin borde, acciones terciarias y de tabla), `destructive` (relleno `--dn-danger`, con confirmación si es irreversible). Alturas 32 / 36 / 40 px. Ícono opcional a la izquierda del texto. |
| **Campo de texto** | Borde `--dn-control-border` (≥ 3:1), anillo `--dn-focus` al enfocar, borde y mensaje en color de error al fallar (nunca solo color). El placeholder es un ejemplo de formato, nunca reemplaza a la etiqueta. 36 px de alto. |
| **Select / combobox** | Misma altura y radio que el campo. Lista con sombra media, opción activa en `--dn-primary-subtle`. El combobox (con búsqueda) es para listas largas y muestra el código en monoespaciada junto al nombre; se opera completo con teclado. |
| **Fecha** | Un solo formato en toda la app (`dd/MM/yyyy`), calendario en popover. Una fecha pura nunca se interpreta como medianoche UTC. |
| **Monto** | Símbolo de moneda dentro del campo, alineado a la derecha, en monoespaciada con separador de miles; editable en crudo con foco, formateado en reposo. |
| **Tarjeta** | Superficie `--dn-surface`, radio `--dn-radius-card`, sombra `--dn-shadow-card` y borde `--dn-surface-border`, padding 24 px, título opcional de 18 px. Agrupa contenido dentro de una vista; una tabla o un formulario de página completa no necesitan ir dentro de una tarjeta. |
| **Pestañas** | Texto en peso 500 y `--dn-text-muted`; la activa en `--dn-primary` con una barra de `--dn-tab-indicator` (3 px) del mismo color debajo. Un contador va entre paréntesis en el texto. Nunca pestañas en píldora, que competirían con las insignias. |
| **Insignia de estado** | 1–2 palabras, radio pequeño, 12 px en peso 500. Por defecto la variante tenue (`--dn-<estado>-subtle` + `--dn-<estado>-text`). La sólida (`--dn-<estado>` + `--dn-on-<estado>`) se reserva para estados finales y lleva ícono. El color nunca es la única señal: el texto dice el estado. |
| **Alerta** | Bloque en la página (no flota) con fondo tenue de su estado e ícono a la izquierda; no se cierra sola mientras la condición siga vigente. |
| **Aviso flotante** | Temporal (≈4 s salvo error), abajo a la derecha, para confirmar una acción. Nunca para errores de validación, que van junto al campo. |
| **Diálogo** | Confirmaciones y formularios cortos. Radio `--dn-radius-dialog`, sombra alta, ≈560 px de ancho. Cierra con Esc o clic fuera, salvo con cambios sin guardar: entonces pide confirmación. El desplazamiento vive en un contenedor interior, no en la superficie. |
| **Panel lateral** | Formularios de más de ~6 campos o detalle que no amerita otra página. Desde la derecha, 480–640 px, botón de cierre siempre visible al desplazar. |
| **Confirmación** | Diálogo sin campos para operaciones irreversibles o sensibles; pide el motivo dentro del mismo diálogo cuando la regla de negocio lo exige. Cancelar a la izquierda (`ghost`), la acción a la derecha. |
| **Menú contextual** | Acciones de una fila o entidad (⋯), hasta ~7 ítems; las destructivas al final, separadas y en color de error. |
| **Estado vacío** | Ícono de 24–32 px en `--dn-text-muted`, un título, una línea de explicación y, si aplica, la acción de crear. Nunca una tabla con encabezados y cero filas sin explicación. |
| **Carga** | Un esqueleto con la forma real del contenido, nunca un spinner a pantalla completa. En una acción puntual, el spinner va dentro del botón. |
| **Error** | Distingue no autorizado, no encontrado y falla del servidor, cada uno con texto claro y una acción; nunca un mensaje técnico crudo. |

## Versión Blade (`<x-dn::…>`)

Desde la 0.3.0 el paquete registra sus vistas bajo el espacio `dn` (`MeridianoServiceProvider`, descubierto solo por Laravel). Cada componente aplica las recetas de `resources/css/recipes.css`, que la app importa en su CSS. Los atributos que no son props (`wire:model`, `wire:click`, `x-on:…`, `aria-*`, `class`) llegan al elemento real, así que funcionan con Livewire y Alpine.

| Componente | Props | Ejemplo |
| --- | --- | --- |
| `icon` | `name` (ícono lucide de `resources/icons/icons.txt`), `size` (16), `label` (si no es decorativo) | `<x-dn::icon name="plus" />` |
| `button` | `variant` (secondary · primary · ghost · danger · danger-subtle), `size` (`sm`), `href`, `icon`, `iconOnly` | `<x-dn::button variant="primary" icon="plus" :href="route('clients.create')">Nuevo</x-dn::button>` |
| `card` | `title`, `subtitle`, `icon`, `flush` (sin padding, para tablas); slot `actions` | `<x-dn::card title="Sedes" icon="map-pin">…</x-dn::card>` |
| `badge` | `tone` (neutral · success · warning · danger · info · primary), `icon`, `solid` | `<x-dn::badge tone="success">Activo</x-dn::badge>` |
| `alert` | `tone`, `title` | `<x-dn::alert tone="warning" title="…">…</x-dn::alert>` |
| `page-heading` | `title`, `description`, `back` (URL de «volver»), `backLabel`; slot = acciones | `<x-dn::page-heading title="Clientes">…</x-dn::page-heading>` |
| `field` | `label`, `for`, `hint`, `error`; slot = el control | `<x-dn::field label="Nombre" for="name"><x-dn::input id="name" wire:model="name" /></x-dn::field>` |
| `input` · `select` | `invalid` | `<x-dn::input wire:model.live="search" />` |
| `search` | `label` (nombre accesible) | `<x-dn::search wire:model.live.debounce.300ms="search" label="Buscar clientes" />` |
| `segmented` · `segmented-item` | `label` · `pressed` | `<x-dn::segmented-item wire:click="$set('status', 'active')" :pressed="$status === 'active'">Activos</x-dn::segmented-item>` |
| `sort-header` | `column`, `sortBy`, `sortDir`, `thClass` | `<x-dn::sort-header column="name" :sort-by="$sortBy" :sort-dir="$sortDir" wire:click="sort('name')">Cliente</x-dn::sort-header>` |
| `detail-list` · `detail-item` | `stacked` · `label` | `<x-dn::detail-item label="Correo">…</x-dn::detail-item>` |
| `empty-state` | `title`, `hint`, `icon`; slot = acción | `<x-dn::empty-state title="Sin clientes" />` |
| `tokens` | — | `<x-dn::tokens />` en el `<head>` de una página que no carga el CSS de la app (página de error, página pública independiente): incrusta los tokens en un `<style>` |

**Paginación de Livewire:** `{{ $items->links('dn::pagination.livewire') }}` dentro del componente; usa `previousPage`/`nextPage`/`gotoPage` y siempre muestra el conteo.

**Íconos:** solo los listados en `resources/icons/icons.txt` (trazos de lucide, licencia ISC en `licenses/`). Un nombre desconocido lanza una excepción a propósito. Para sumar uno: agregarlo a `icons.txt` y correr `node scripts/build-icons.mjs <ruta a node_modules/lucide-react>`.

**Acento por empresa:** `Slyn9\Meridiano\AccentPalette::problem($hex)` dice por qué un color no sirve (o `null`); `AccentPalette::from($hex)->css()` devuelve los 7 tokens de acento derivados para claro y oscuro, todos con contraste AA garantizado (lo prueba un barrido de más de 100 colores). Se inyecta en un `<style>` después del CSS de la app.

## Componentes de la 0.4: línea de tiempo, flujo de pasos, accesos rápidos y fila expandible

Existen en Blade y en React con la misma estructura y las mismas clases, así que se ven igual en las dos apps.

| Componente | Cuándo usarlo | Reglas |
| --- | --- | --- |
| **Línea de tiempo** | Historial de un registro: quién hizo qué y cuándo (creado, contabilizado, anulado; cambios de estado). | Lista ordenada (`<ol>` con nombre accesible). Cada evento: título, una línea de fecha · usuario y un detalle opcional (el motivo). El tono del punto (`neutral`, `primary`, `success`, `warning`, `danger`, `info`) acompaña al texto, nunca lo reemplaza. Un evento sin detalle no lleva cuerpo vacío. |
| **Flujo de pasos** | Un proceso con pasos en orden y un estado por paso: el cierre del mes, el ciclo de vida de una orden. | Cada paso está `done`, `current` o `pending`. El actual lleva `aria-current="step"` y cada paso dice su estado en texto oculto para lectores de pantalla («completado», «paso actual», «pendiente»): el color y el ícono de check no son la única señal. Horizontal desde 640 px, siempre vertical en teléfono o con `vertical`. Un paso puede enlazar a la pantalla donde se resuelve. |
| **Accesos rápidos** | Un índice de destinos con una línea de descripción cada uno: un hub de reportes, los reportes desde el Inicio. | Toda la fila es el enlace (un solo destino de tabulación). Ícono en un cuadro tenue, título en azul de texto, descripción de una línea. 1, 2 o 3 columnas (desde 768 px). Los destinos que el usuario no puede abrir no se muestran. |
| **Fila expandible** | Detalle secundario de una fila que no merece otra pantalla ni otra columna. | Un botón propio en la primera celda (no la fila entera, que puede tener su propia acción) con `aria-expanded`, `aria-controls` y un nombre que dice qué abre («Ver conceptos de Ana Ruiz»). Se opera con Enter y Espacio. El detalle es una segunda fila que ocupa todo el ancho; cerrado, queda `hidden`. Clic en el botón no dispara el clic de la fila. |

### Blade

| Componente | Props | Ejemplo |
| --- | --- | --- |
| `timeline` · `timeline-item` | `label` · `title`, `meta`, `tone`; slot = detalle | `<x-dn::timeline label="Historial"><x-dn::timeline-item title="Anulado" meta="20/01/2026 · Ana" tone="danger">Motivo: duplicado</x-dn::timeline-item></x-dn::timeline>` |
| `process-flow` | `label`, `steps` (lista de `['label', 'state', 'meta'?, 'href'?]`), `vertical` | `<x-dn::process-flow label="Estado de la orden" :steps="$steps" :vertical="true" />` |
| `quick-links` · `quick-link` | `label`, `columns` (1–3) · `href`, `title`, `description`, `icon` | `<x-dn::quick-link :href="route('reports.operational')" title="Reporte Operacional" icon="wrench" description="…" />` |
| `expandable-row` | `rowKey` (único en la tabla; también `wire:key`), `colspan` (columnas totales, incluida la del botón), `label`, `open`; slot = celdas, slot `detail` | `<x-dn::expandable-row :row-key="'client-'.$client->id" :colspan="5" :label="'Ver detalle de '.$client->name">…<x-slot:detail>…</x-slot:detail></x-dn::expandable-row>` |

La fila expandible genera su propio `<tbody>` (con su estado de Alpine), así que va directamente dentro de `<table>`, una por registro; la tabla agrega una celda de encabezado vacía `<th class="dn-expand-cell">` para la columna del botón. Los atributos sueltos (`x-on:click`, `class`) llegan a la fila principal.

### React (`@meridiano`)

Los componentes React no se publican en npm: los compila el Vite de la app. La app define el alias y carga las recetas:

```js
// vite.config.js
resolve: { alias: { '@meridiano': fileURLToPath(new URL('./vendor/slyn9/meridiano/resources/js/react', import.meta.url)) } }
```

```json
// tsconfig.json → compilerOptions.paths
"@meridiano": ["./vendor/slyn9/meridiano/resources/js/react/index.ts"]
```

```css
@import '../../vendor/slyn9/meridiano/resources/css/recipes.css';
```

| Componente | Props |
| --- | --- |
| `Timeline` · `TimelineItem` | `label` · `title`, `meta`, `tone`, `children` (detalle) |
| `ProcessFlow` | `label`, `steps: { key, label, state, meta?, href? }[]`, `vertical`, `linkAs` (componente de enlace, ej. `Link` de Inertia) |
| `QuickLinkList` · `QuickLink` | `label`, `columns` · `href`, `title`, `description`, `icon` (un nodo, ej. un ícono de lucide-react), `as` (componente de enlace; el resto de props le llega, ej. `prefetch`) |
| `ExpandableRow` | `colSpan`, `label`, `detail`, `defaultOpen`, `row`/`cell` (los componentes de fila y celda de la tabla de la app; por defecto `tr`/`td`); `children` = celdas. Devuelve dos filas: va dentro del `<tbody>`. |
| `DnIcon` | `name` (mismos íconos que Blade), `size`, `label` |

```tsx
import { ProcessFlow } from '@meridiano';

<ProcessFlow vertical label="Cierre del mes" linkAs={Link} steps={steps} />
```

Blade y React comparten exactamente los mismos íconos (`resources/js/react/icons.ts` lo genera el mismo script que `lucide.php`; una prueba lo verifica).
