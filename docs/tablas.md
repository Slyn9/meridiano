# Tablas

La tabla es el componente más usado en las aplicaciones de DN Systems. Estas reglas valen para toda tabla con datos.

| Aspecto | Regla |
| --- | --- |
| **Densidad** | Compacta: filas de 36–40 px, padding horizontal de celda de 12 px. |
| **Alineación** | Texto a la izquierda; números, montos y fechas a la derecha en monoespaciada con cifras tabulares; acciones a la derecha, en la última columna. Nunca centrado. |
| **Líneas** | Solo separadores horizontales (`--dn-divider`), sin líneas verticales. |
| **Encabezados** | 12 px en peso 500, `--dn-text-muted`, mayúsculas con espaciado leve, fondo `--dn-neutral-subtle`, fijos al desplazar en tablas largas. |
| **Identificador** | El número o código que abre el registro es un enlace en `--dn-primary`. |
| **Estados** | Insignia tenue (ver Componentes). |
| **Acciones** | Una acción primaria visible por fila como botón `ghost`; el resto en un menú ⋯. |
| **Filtros** | Una fila sobre la tabla con los 1–2 filtros más usados siempre visibles; los secundarios detrás de «Más filtros». |
| **Búsqueda** | Un solo campo por tabla, con espera de 300 ms entre teclas antes de consultar. |
| **Orden** | Clic en el encabezado ordena (tres estados), con flecha y `aria-sort`; un criterio a la vez; el orden viaja en la URL junto con los filtros. Las columnas de estado o tipo no se ordenan. |
| **Paginación y conteo** | En el servidor para tablas que pueden crecer; el conteo siempre visible («Mostrando 1–25 de 156», «24 encontrados de 156»). |
| **Vacío** | Sin datos: estado vacío con la acción de crear. Sin resultados por filtro: mensaje que lo diga y cómo limpiar los filtros. |
| **Carga** | Esqueleto de filas del alto real. |
| **Teléfono** | Bajo 768 px la tabla densa se muestra como lista de tarjetas con los mismos datos (doble renderizado), con un selector «Ordenar por». |
| **Tablet** | Tabla real con desplazamiento horizontal de respaldo dentro de su contenedor, nunca de toda la página. |
