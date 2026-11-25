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

Los componentes de lista de detalle, filtro segmentado, línea de tiempo, flujo de pasos, accesos rápidos y fila expandible llegan en la fase 3 del plan, con su versión React y Blade.
