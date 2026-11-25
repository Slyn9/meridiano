# Principios y fundamentos

## Principios

Las aplicaciones de DN Systems son herramientas de trabajo: deben transmitir profesionalidad, confianza, simplicidad y eficiencia, nunca la saturación de un sistema heredado.

- **Un solo acento.** El azul es el único color de marca; la modernidad viene de un sistema limpio, no de más color. Los colores de estado comunican estado, no decoran.
- **Superficies sobre fondo.** El contenido vive en superficies (`--dn-surface`) sobre un fondo gris (`--dn-canvas`). En claro, una tarjeta se separa del fondo por una sombra mínima (`--dn-shadow-card`), sin borde; en oscuro, por su borde (`--dn-surface-border`), sin sombra. La sombra fuerte se reserva para lo que flota (menús, popovers, diálogos, avisos).
- **Radios moderados.** 8 px en controles, 12 px en tarjetas, 16 px en diálogos. Suficiente para sentirse actual sin leerse informal en un producto que maneja dinero.
- **Densidad antes que aire.** Tablas compactas, espaciado generoso solo donde agrupa información.
- **Revelar de a poco.** Lo que se usa poco se oculta detrás de una acción explícita (opciones avanzadas, más filtros), nunca se muestra por defecto.

## Tipografía

| Rol | Familia | Token |
| --- | --- | --- |
| Interfaz y texto | Inter | `--dn-font-sans` |
| Montos, códigos, números de documento | IBM Plex Mono | `--dn-font-mono` |

Una sola familia para la interfaz; la monoespaciada tiene un trabajo funcional (alinear cifras en columnas). Cada aplicación carga las fuentes (pesos de Inter 400/500/600/700, de Plex Mono 400/500/600).

| Tamaño | Uso |
| --- | --- |
| 12 px | Metadatos, insignias, fechas en tablas densas |
| 13 px | Texto secundario, ayudas, celdas densas |
| 14 px | Tamaño por defecto: cuerpo, campos, botones |
| 16 px | Texto destacado, cuerpo de diálogo |
| 18 px | Título de tarjeta |
| 20 px | Título de página |
| 24 px | Título de inicio, cifra secundaria |
| 30 px | Cifra principal (uso excepcional) |

Pesos: 400 lectura, 500 etiquetas y encabezados de tabla, 600 títulos y estado activo, 700 solo la cifra principal.

## Espaciado

Grilla de 4 px con la escala de Tailwind: 4 (ícono–texto), 8 (dentro de insignias), 12 (dentro de campos), 16 (entre campos), 24 (dentro de tarjetas, entre secciones de formulario), 32 (entre bloques), 48 (entre secciones mayores). La separación entre elementos relacionados nunca es mayor que entre grupos distintos.

## Radios y elevación

| Token | Valor | Uso |
| --- | --- | --- |
| `--dn-radius-control` | 8 px | Botones, campos, selects, popovers |
| `--dn-radius-card` | 12 px | Tarjetas |
| `--dn-radius-dialog` | 16 px | Diálogos |
| — | 4–6 px | Insignias, casillas |
| — | completo | Avatares, puntos de estado |

| Nivel | Cuándo |
| --- | --- |
| `--dn-shadow-card` | Tarjeta en reposo (solo claro) |
| Sombra media | Menú desplegable, popover, combobox abierto, tooltip |
| Sombra alta | Diálogo, panel lateral, aviso flotante |

## Íconos

lucide, trazo de 2 px, en `currentColor`. 16 px junto a texto, 20 px en botones y menú, 24 px en encabezados y estados vacíos. Un botón solo con ícono lleva nombre accesible y, en escritorio, tooltip; una acción de negocio siempre lleva texto visible.

## Tramos de pantalla

Cada tramo tiene su forma correcta de mostrar la misma información, nunca una compresión del escritorio:

| Tramo | Ancho | Comportamiento |
| --- | --- | --- |
| Teléfono | < 768 px | Menú en panel deslizable; tablas densas como tarjetas; filtros secundarios en un panel; barra superior solo con íconos |
| Tablet / laptop chica | 768–1279 px | Menú plegable a íconos; tablas reales con desplazamiento horizontal de respaldo; formularios en 1–2 columnas |
| Escritorio | ≥ 1280 px | Diseño de referencia |

El corte tabla↔tarjeta ocurre exactamente en 768 px (`md`).

## Grilla

Formularios en 12 columnas con 16 px de separación: un campo corto ocupa 4–6, uno largo 12, fechas y números 3–4. Paneles de indicadores en 4 columnas en escritorio, 2 en tablet, 1 en teléfono.
