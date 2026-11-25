# Tokens

Los tokens son variables CSS `--dn-*` definidas en `resources/css/tokens.css`: claro en `:root`, oscuro en `.dark` (la clase va en `<html>`). Una app nunca escribe un color, radio o medida literal: usa el token, directo o a través de un puente.

El prefijo es `dn-` (DN Systems) y no el nombre del sistema, para que un cambio de nombre no toque el código.

## Superficies

| Token | Uso |
| --- | --- |
| `--dn-canvas` | Fondo de la aplicación, detrás de todo |
| `--dn-surface` | Tarjetas, popovers, diálogos y menú lateral: un nivel encima del fondo |
| `--dn-surface-border` | Borde de una tarjeta: transparente en claro (la separa su sombra), visible en oscuro |
| `--dn-shell` | Barra superior de la aplicación |
| `--dn-neutral-subtle` | Relleno neutro: encabezado de tabla, botón secundario, chip |
| `--dn-divider` | Separadores y bordes decorativos (sin requisito de contraste) |
| `--dn-control-border` | Borde de un campo de formulario (≥ 3:1 contra la superficie) |

## Texto

| Token | Uso |
| --- | --- |
| `--dn-text` | Texto principal |
| `--dn-text-muted` | Texto secundario, ayudas, encabezados de tabla |

## Acento

El sistema tiene un solo acento. Se separa en dos usos porque un mismo azul no puede servir a la vez de texto sobre un fondo oscuro y de relleno con texto blanco:

| Token | Uso |
| --- | --- |
| `--dn-primary` | Azul **de texto**: enlaces, pestaña activa, ícono activo |
| `--dn-primary-fill` / `--dn-on-primary-fill` | Relleno del botón primario y su texto |
| `--dn-primary-fill-hover` | Relleno del botón primario en hover |
| `--dn-primary-subtle` | Fondo del ítem activo del menú, fila seleccionada, hover |
| `--dn-primary-strong` | Texto sobre `--dn-primary-subtle` |
| `--dn-focus` | Anillo de foco (≥ 3:1) |

## Estados

Cuatro familias (`success`, `warning`, `danger`, `info`), cada una con cuatro tokens:

| Token | Uso |
| --- | --- |
| `--dn-<estado>` | Relleno sólido (botón destructivo, insignia de estado final) |
| `--dn-on-<estado>` | Texto sobre el relleno sólido |
| `--dn-<estado>-subtle` | Fondo tenue (insignia, alerta) |
| `--dn-<estado>-text` | Texto de color sobre el fondo tenue o sobre la superficie |

## Gráficos

`--dn-chart-1` a `--dn-chart-5`: paleta categórica, validada contra la superficie de cada tema.

## Forma, shell y tipografía

| Token | Uso |
| --- | --- |
| `--dn-radius-control` | Botones, campos, selects, popovers |
| `--dn-radius-card` | Tarjetas |
| `--dn-radius-dialog` | Diálogos y paneles laterales |
| `--dn-shadow-card` | Sombra de una tarjeta: mínima en claro, ninguna en oscuro |
| `--dn-shadow-popover` | Sombra de lo que flota sobre la página: menú desplegable, popover |
| `--dn-overlay` | Fondo oscurecido detrás de un panel deslizable o un diálogo |
| `--dn-shell-height` | Alto de la barra superior |
| `--dn-sidebar-width` / `--dn-sidebar-width-icon` | Ancho del menú lateral, expandido y plegado a íconos |
| `--dn-tab-indicator` | Grosor de la barra bajo la pestaña activa |
| `--dn-font-sans` / `--dn-font-mono` | Familias tipográficas (cada app carga sus fuentes) |

## Contraste

`tests/contrast.test.mjs` define cada par que se mide (texto sobre fondo, texto sobre tarjeta, texto del botón, texto de cada insignia, borde de campo, foco) y su mínimo: 4,5:1 para texto (WCAG 2.1, 1.4.3) y 3:1 para bordes de control y foco (1.4.11). Cambiar un valor implica correr `npm test`.
