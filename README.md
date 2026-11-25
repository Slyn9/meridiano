# Meridiano

El sistema de diseño de DN Systems. Una sola fuente de colores, tipografía, radios y medidas para las aplicaciones Laravel de DN Systems, sin importar su stack de interfaz: React con Inertia, Blade con Livewire o Blade con Alpine.

## Qué trae

| Ruta | Qué es | Quién lo usa |
| --- | --- | --- |
| `resources/css/tokens.css` | Variables `--dn-*`, tema claro (`:root`) y oscuro (`.dark`). La única fuente de valores. | Todas las apps |
| `resources/css/bridges/shadcn.css` | Hace que las variables de shadcn/ui (`--background`, `--primary`…) lean los tokens. | Apps con shadcn/ui |
| `resources/css/bridges/air-system.css` | Hace que las variables propias de Air-System (`--accent`, `--bg-page`…) lean los tokens. | Air-System |
| `resources/css/recipes.css` | Clases `.dn-*`: la apariencia de cada componente, en CSS plano (sirve con o sin Tailwind). | Apps Blade |
| `resources/views/components/` | Componentes Blade `<x-dn::…>` y la paginación de Livewire `dn::pagination.livewire`. | Apps Blade/Livewire |
| `resources/icons/` | Íconos lucide incluidos (`<x-dn::icon>`), con su licencia ISC en `licenses/`. | Apps Blade |
| `src/AccentPalette.php` | Deriva y valida contra WCAG AA la paleta de acento de una empresa a partir de un solo color. | Apps con tema por empresa |
| `docs/` | Documentación del sistema, en español: fundamentos, tokens, shell, componentes, tablas y gobernanza. | Quien diseña o programa una pantalla |

Los componentes React se agregan en la fase 3 (ver `CHANGELOG.md`).

## Instalación

El paquete se sirve desde su repositorio de GitHub (no se publica en Packagist ni en npm).

```json
"repositories": [
    { "name": "meridiano", "type": "vcs", "url": "https://github.com/Slyn9/meridiano.git" }
]
```

```bash
composer require slyn9/meridiano:^0.3
```

En el CSS de entrada de la app (Vite), antes de cualquier regla propia:

```css
@import '../../vendor/slyn9/meridiano/resources/css/tokens.css';
@import '../../vendor/slyn9/meridiano/resources/css/bridges/shadcn.css';     /* apps shadcn/ui */
@import '../../vendor/slyn9/meridiano/resources/css/bridges/air-system.css'; /* Air-System, después de su global-theme.css */
@import '../../vendor/slyn9/meridiano/resources/css/recipes.css';            /* apps Blade */
```

En el servidor, `composer install` debe correr **antes** de `npm run build`: el CSS se lee desde `vendor/`.

## Actualizar

1. Se publica una etiqueta nueva en este repositorio (`vX.Y.Z`).
2. En cada app: `composer update slyn9/meridiano`, `npm run build`, pruebas y revisión visual.
3. Se despliega. Cada app decide cuándo actualiza; `composer.lock` fija la versión exacta.

## Versionado

| Cambio | Versión |
| --- | --- |
| Renombrar o quitar un token, una clase, un componente o una prop | Mayor |
| Token, clase o componente nuevo; ajuste de un valor que mantiene AA | Menor |
| Corrección sin cambio de API | Parche |

Mientras la versión sea `0.x`, un cambio de versión menor puede romper compatibilidad; `UPGRADING.md` dice qué hacer.

## Pruebas

```bash
npm test                                 # contraste WCAG 2.1 de cada par documentado (Node 18+, sin dependencias)
composer install && vendor/bin/phpunit   # AccentPalette e íconos (PHPUnit, solo desarrollo del paquete)
```

Un valor que baje de 4,5:1 (texto) o 3:1 (bordes de control y foco) hace fallar `npm test`.

## Licencia

MIT. Ver `LICENSE`.
