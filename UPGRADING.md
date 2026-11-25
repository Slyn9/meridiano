# Actualizar entre versiones

## De 0.1 a 0.2

La 0.2 cambia los valores de los tokens: toda app que la adopte cambia de aspecto sin tocar sus pantallas. Antes de desplegar:

1. **Azul de texto.** En oscuro, `--primary` (shadcn) es ahora el relleno del botón y no alcanza 4,5:1 como texto. Las clases de texto o borde azul (`text-primary`, `border-primary`) deben pasar a la variable nueva `--link` (por ejemplo una utilidad `text-link` definida en el `@theme` de la app como `--color-link: var(--link)`).
2. **Tarjetas.** Para el borde transparente en claro y visible en oscuro, la tarjeta usa `--card-border` como color de borde, `--dn-radius-card` como radio y `--dn-shadow-card` como sombra.
3. **Barra superior.** `--shell` es el fondo de la barra superior.
4. **Sobrescrituras locales.** Quitar de la app cualquier valor que pisara un token: la 0.2 ya trae el definitivo.
5. **Revisión visual** en teléfono, tablet y escritorio, en claro y oscuro.
