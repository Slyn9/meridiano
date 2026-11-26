# Changelog

## 0.7.1 — 2026-11-25

- Puente Bootstrap: `.bg-white` y `.bg-body` respetan `bg-opacity` (antes pintaban la superficie opaca: un cuadro translúcido sobre una cabecera de color quedaba sólido y su ícono blanco, invisible). Encontrado al migrar las pantallas de Farmacy.

## 0.7.0 — 2026-11-25

Íconos para Farmacy (fase 5). Sin cambios de valores ni de nombres.

- 138 íconos lucide nuevos (210 en total): los que reemplazan a los de Font Awesome que usa Farmacy, verificados uno por uno contra lucide-react 0.475.0.
- `resources/js/dn-icon.js`: `dnIcon()` y `hasDnIcon()` para el JS de una app Blade que arma marcado; el mismo SVG que `<x-dn::icon>` (prueba `tests/dn-icon.test.mjs`).

## 0.6.0 — 2026-11-25

Puente para apps con Bootstrap 5.3 (Farmacy, fase 5). Sin cambios de valores ni de nombres.

- `resources/css/bridges/bootstrap.css`: las variables `--bs-*` (roles, superficies, texto, bordes, enlaces, validación, foco, radios, sombras, tipografía) leen los tokens, y se vuelven a declarar los colores que Bootstrap compila como literales (botones sólidos y de contorno, foco de campos, casilla marcada, menú desplegable, pestañas, paginación, lista, barra de progreso, acordeón, tablas de color, alertas) y sus utilidades de color con `color-mix()` en vez de tripletas RGB, respetando las de opacidad. Las tripletas `--bs-*-rgb` quedan para usos heredados y reflejan los tokens.
- `tests/bridges.test.mjs`: cada token que usa un puente existe; las tripletas coinciden con los tokens en claro y en oscuro; cada botón de Bootstrap y su hover miden al menos 4,5:1 en los dos temas (encontró que oscurecer el relleno en hover bajaba de AA en oscuro, donde el texto encima es oscuro: ahora el hover va hacia el lado opuesto al texto). Las funciones de contraste pasan a `tests/color.mjs`.

## 0.5.0 — 2026-11-25

Lo que faltaba para que ContaPE y Air-System no tengan ningún color fijo (Fase 4). Sin cambios de valores existentes.

- Tokens nuevos: bordes tenues de estado y de acento (`--dn-<estado>-border`, `--dn-primary-border`), sombra de diálogo (`--dn-shadow-dialog`), velo sobre fotos (`--dn-scrim`, `--dn-scrim-strong`, `--dn-on-scrim`) y una categoría violeta para etiquetas que elige el usuario (`--dn-violet`, `-subtle`, `-text`). La prueba de contraste suma sus pares y el velo compuesto sobre una foto blanca (67 pruebas).
- Puente shadcn: `--overlay`. Puente de Air-System: `--accent-on`, `--accent-border`, `--color-<estado>-on`, `--color-<estado>-border`, `--color-purple(-bg, -text)`, `--scrim(-strong)`, `--on-scrim` y `--shadow-modal`.
- `<x-dn::tokens />` y `Slyn9\Meridiano\Tokens::css()`: los tokens incrustados para páginas que no cargan el CSS compilado (páginas de error, páginas públicas).

## 0.4.0 — 2026-11-25

Cuatro componentes nuevos, en Blade y en React, y la primera vez que una app React usa componentes del paquete. Sin cambios de valores.

- Línea de tiempo (`<x-dn::timeline>`/`timeline-item`, `Timeline`/`TimelineItem`), flujo de pasos (`<x-dn::process-flow>`, `ProcessFlow`), accesos rápidos (`<x-dn::quick-links>`/`quick-link`, `QuickLinkList`/`QuickLink`) y fila expandible (`<x-dn::expandable-row>`, `ExpandableRow`), con sus recetas en `recipes.css`. Estado anunciado en texto (no solo color), operables con teclado.
- `resources/js/react/`: componentes React compilados por el Vite de la app con el alias `@meridiano` (no se publican en npm), y `DnIcon`.
- `resources/js/react/icons.ts` lo genera el mismo `scripts/build-icons.mjs` que `lucide.php`; una prueba exige que sean idénticos. Íconos nuevos: check, chevrons-right, history (72 en total).

## 0.3.0 — 2026-11-25

El paquete pasa a tener componentes para apps Blade/Livewire. Sin cambios de valores para quien ya usa la 0.2.

- `resources/css/recipes.css`: clases `.dn-*` de shell (barra superior, menú lateral con ítem activo y punto, usuario, pie), encabezado de página, tarjeta, botón, campos, búsqueda, insignia, alerta, contador, filtro segmentado, pestañas, barra de tabla, tabla con encabezados ordenables, estado vacío, paginación, detalle en dos columnas, avatar, menú desplegable, grilla de formulario y vista previa de tema. CSS plano, solo tokens, estados con atributos ARIA.
- Componentes Blade anónimos `<x-dn::…>` (icon, button, card, badge, alert, page-heading, field, input, select, search, segmented, segmented-item, sort-header, detail-list, detail-item, empty-state) y la paginación `dn::pagination.livewire`, registrados por `MeridianoServiceProvider` (autodescubierto).
- 69 íconos lucide incluidos (`resources/icons/lucide.php`, generado por `scripts/build-icons.mjs`; licencia ISC en `licenses/lucide-ISC.txt`).
- `Slyn9\Meridiano\AccentPalette`: deriva los 7 tokens de acento de un color de empresa para claro y oscuro y valida WCAG AA; probado con PHPUnit (dependencia solo de desarrollo del paquete) con un barrido de más de 100 colores.
- `bridges/air-system.css`: las variables de Air-System leen los tokens; separa `--accent` (texto) de `--accent-fill` (relleno).
- Tokens nuevos: `--dn-shadow-popover`, `--dn-overlay`; clases `.dn-theme-light`/`.dn-theme-dark` para forzar un tema en una zona.

## 0.2.0 — 2026-11-25

La paleta propia de Meridiano. Cambia el aspecto de toda app que lo use: ver `UPGRADING.md`.

- Paleta nueva en claro y oscuro (azul de DN Systems, fondo gris con sesgo azul, oscuro azul-negro). Los 7 pares heredados bajo AA quedan resueltos: la prueba pasa 30 pares por tema y la lista de fallos conocidos queda vacía.
- En oscuro, el relleno del botón primario (`--dn-primary-fill`, con texto blanco) se separa del azul de texto (`--dn-primary`); los rellenos de estado llevan texto oscuro.
- Nuevo `--dn-surface-border`: la tarjeta no tiene borde en claro (la separa su sombra) y sí en oscuro.
- Tarjeta con radio de 12 px y sombra mínima en claro; diálogo con radio de 16 px; barra de pestaña activa de 3 px.
- Puente shadcn: nuevas variables `--card-border`, `--shell` y `--link` (azul de texto, porque `--primary` es el relleno del botón).
- Documentación del sistema en `docs/` (fundamentos, shell, componentes, tablas y gobernanza), en español.

## 0.1.0 — 2026-11-25

Primera versión: la base, sin cambio visible para quien la adopta.

- `resources/css/tokens.css`: tokens `--dn-*` de superficies, texto, acento, estados, gráficos, forma, shell y tipografía, en claro y oscuro. Los valores son los que ContaPE usaba antes de adoptar el paquete.
- `resources/css/bridges/shadcn.css`: las variables de shadcn/ui leen los tokens.
- `tests/contrast.test.mjs`: contraste WCAG 2.1 de 28 pares por tema. Siete pares heredados no cumplen y quedan listados como fallos conocidos (bordes de campo en ambos temas, enlaces en oscuro y el texto de advertencia tenue en claro); la paleta de la 0.2.0 debe resolverlos.
