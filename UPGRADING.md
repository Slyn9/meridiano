# Actualizar entre versiones

## De 0.6 a 0.7

Sin cambios de valores ni de nombres: solo se agregan íconos y `dn-icon.js`. Una app React que importe `DnIcon` incluye la lista completa de íconos en su bundle (crece con cada ícono nuevo).

## De 0.5 a 0.6

Sin cambios de valores ni de nombres: solo se agrega `bridges/bootstrap.css`. ContaPE y Air-System no necesitan nada.

## De 0.4 a 0.5

Sin cambios de valores ni de nombres: solo se agregan tokens, variables de los puentes y `<x-dn::tokens />`. Una app que use shadcn puede mapear `--color-overlay: var(--overlay)` en su `@theme` para el fondo de diálogos y paneles.

## De 0.3 a 0.4

Sin cambios de valores ni de nombres: se agregan componentes. Una app Blade no necesita nada. Una app React que quiera usar los componentes React agrega el alias `@meridiano` en `vite.config.js` y `tsconfig.json` e importa `recipes.css` (ver `docs/componentes.md`). Las recetas no van en una capa de Tailwind: pisan una utilidad aplicada al mismo elemento.

## De 0.2 a 0.3

Sin cambios de valores ni de nombres: solo se agregan recetas, componentes Blade, íconos, `AccentPalette` y dos tokens. El paquete ahora declara `illuminate/support` e `illuminate/view` (^12 o ^13) y registra un proveedor de servicios que Laravel descubre solo. Una app React (ContaPE) no necesita cambiar nada.

## De 0.1 a 0.2

La 0.2 cambia los valores de los tokens: toda app que la adopte cambia de aspecto sin tocar sus pantallas. Antes de desplegar:

1. **Azul de texto.** En oscuro, `--primary` (shadcn) es ahora el relleno del botón y no alcanza 4,5:1 como texto. Las clases de texto o borde azul (`text-primary`, `border-primary`) deben pasar a la variable nueva `--link` (por ejemplo una utilidad `text-link` definida en el `@theme` de la app como `--color-link: var(--link)`).
2. **Tarjetas.** Para el borde transparente en claro y visible en oscuro, la tarjeta usa `--card-border` como color de borde, `--dn-radius-card` como radio y `--dn-shadow-card` como sombra.
3. **Barra superior.** `--shell` es el fondo de la barra superior.
4. **Sobrescrituras locales.** Quitar de la app cualquier valor que pisara un token: la 0.2 ya trae el definitivo.
5. **Revisión visual** en teléfono, tablet y escritorio, en claro y oscuro.
