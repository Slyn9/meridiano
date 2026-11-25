# Shell

El shell es el marco común de toda pantalla autenticada: barra superior a todo el ancho, menú lateral debajo de ella a la izquierda, y el contenido sobre el fondo gris.

```
┌──────────────────────────────────────────────────────────┐
│ ☰  ▣ Marca   Migas › de › la página        🔍  ?  ⛶  ◐  │  barra superior (--dn-shell, 56 px)
├──────────────┬───────────────────────────────────────────┤
│ Empresa ▾    │                                           │
│              │  Título de página            [Acción]     │
│ SECCIÓN      │                                           │
│ ● Ítem activo│  ┌─────────────┐ ┌─────────────┐          │
│   Ítem       │  │ tarjeta     │ │ tarjeta     │          │  fondo (--dn-canvas)
│              │  └─────────────┘ └─────────────┘          │
│ Usuario      │                                           │
└──────────────┴───────────────────────────────────────────┘
  menú (--dn-surface, borde --dn-divider)
```

| Región | Reglas |
| --- | --- |
| **Barra superior** | Alto `--dn-shell-height` (56 px), fondo `--dn-shell`, separador inferior `--dn-divider`, fija arriba al desplazar. A la izquierda: botón para plegar el menú, marca de la aplicación (ícono en un cuadro del color de relleno primario y nombre; bajo 640 px solo el ícono) y migas. A la derecha: búsqueda global, ayuda, pantalla completa y tema, como botones de ícono con nombre accesible. No repite navegación del menú. |
| **Menú lateral** | Debajo de la barra superior, fondo `--dn-surface` con borde derecho `--dn-divider`. Ancho `--dn-sidebar-width` (256 px), plegable a `--dn-sidebar-width-icon` en tablet (con el nombre como tooltip); en teléfono es un panel deslizable que trae su propia marca arriba. Secciones con un rótulo pequeño en `--dn-text-muted`. |
| **Ítem activo** | Fondo `--dn-primary-subtle`, texto `--dn-primary-strong` en peso 600 y un punto de 6 px a la derecha en `--dn-primary-fill` (oculto en el modo de solo íconos). Un solo ítem activo por pantalla. |
| **Contenido** | Fondo `--dn-canvas`, padding 24–32 px, ancho fluido (las tablas usan el ancho disponible). Solo los formularios simples se limitan a ~640–720 px. |
| **Encabezado de página** | Título de 20 px en peso 600, descripción corta opcional y las acciones principales a la derecha (una sola primaria). |
| **Migas** | Solo cuando hay jerarquía real; bajo 768 px colapsan a «‹ último nivel». |
| **Pie** | Opcional y mínimo (`text-xs`, `--dn-text-muted`). |

## Pantallas sin shell

Acceso (inicio de sesión) y páginas de error usan un marco mínimo: fondo `--dn-canvas`, una tarjeta centrada con la marca y el contenido, sin menú.
