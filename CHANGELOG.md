# Changelog

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
