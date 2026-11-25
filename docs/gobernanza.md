# Gobernanza

## Cómo se agrega o cambia algo

1. **Antes de construir una pantalla**, revisar esta documentación: si el patrón existe, se reutiliza tal cual.
2. **Un componente que falta se agrega a Meridiano**, no a la pantalla ni a la aplicación que lo necesitó, con su regla en `componentes.md` y, cuando aplique, su versión para cada stack.
3. **Ningún color, tamaño, radio o sombra se escribe literal** en una pantalla: siempre por un token `--dn-*` (directo o a través de un puente) o una clase que lo consuma. Un valor suelto es señal de que falta un token: se agrega aquí.
4. **Un valor nuevo o cambiado** se mide con `npm test` (contraste) y se publica con su versión (ver `README.md`, Versionado) y una entrada en `CHANGELOG.md`.
5. **Ninguna marca de terceros** en nombres de paquete, clase, componente, token ni documentación, ni recursos copiados de otros productos.

## Reglas que evitan defectos ya vistos

- **`min-w-0` en hijos de flex y grid que deban truncar o compartir espacio** con columnas fijas. Un ítem flex/grid no se achica por debajo de su contenido por defecto y desborda la página en teléfono.
- **Un contenedor con `overflow-y-auto` también recorta en horizontal**, y un control enfocado pegado a su borde pierde el anillo de foco: el contenedor desplazable lleva un margen interior que deja ver el anillo (por ejemplo `-m-1 p-1`).
- **La superficie de un diálogo no tiene `overflow`**: el desplazamiento vive en un contenedor interior, para que los popovers anidados no queden recortados.
- **Una restricción del servidor también se impide en el campo** (largo máximo, solo dígitos), nunca solo al enviar.
