# Meridiano

El sistema de diseño de DN Systems. Una sola fuente de colores, tipografía, radios y medidas para las aplicaciones Laravel de DN Systems, sin importar su stack de interfaz: React con Inertia, Blade con Livewire o Blade con Alpine.

## Qué trae

| Ruta | Qué es | Quién lo usa |
| --- | --- | --- |
| `resources/css/tokens.css` | Variables `--dn-*`, tema claro (`:root`) y oscuro (`.dark`). La única fuente de valores. | Todas las apps |
| `resources/css/bridges/shadcn.css` | Hace que las variables de shadcn/ui (`--background`, `--primary`…) lean los tokens. | Apps con shadcn/ui |
| `docs/` | Documentación del sistema, en español. | Quien diseña o programa una pantalla |

Las recetas CSS, los componentes Blade y los componentes React se agregan en versiones siguientes (ver `CHANGELOG.md`).

## Instalación

El paquete se sirve desde su repositorio de GitHub (no se publica en Packagist ni en npm).

```json
"repositories": [
    { "name": "meridiano", "type": "vcs", "url": "https://github.com/Slyn9/meridiano.git" }
]
```

```bash
composer require slyn9/meridiano:^0.1
```

En el CSS de entrada de la app (Vite), antes de cualquier regla propia:

```css
@import '../../vendor/slyn9/meridiano/resources/css/tokens.css';
@import '../../vendor/slyn9/meridiano/resources/css/bridges/shadcn.css'; /* solo apps shadcn/ui */
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
npm test
```

Mide el contraste WCAG 2.1 de cada par de texto/fondo documentado en `docs/tokens.md`, en claro y en oscuro (Node 18+, sin dependencias). Un valor que baje de 4,5:1 (texto) o 3:1 (bordes de control y foco) hace fallar la prueba.

## Licencia

MIT. Ver `LICENSE`.
