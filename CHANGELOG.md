# Changelog

## 0.1.0 — 2026-11-25

Primera versión: la base, sin cambio visible para quien la adopta.

- `resources/css/tokens.css`: tokens `--dn-*` de superficies, texto, acento, estados, gráficos, forma, shell y tipografía, en claro y oscuro. Los valores son los que ContaPE usaba antes de adoptar el paquete.
- `resources/css/bridges/shadcn.css`: las variables de shadcn/ui leen los tokens.
- `tests/contrast.test.mjs`: contraste WCAG 2.1 de 28 pares por tema. Siete pares heredados no cumplen y quedan listados como fallos conocidos (bordes de campo en ambos temas, enlaces en oscuro y el texto de advertencia tenue en claro); la paleta de la 0.2.0 debe resolverlos.
