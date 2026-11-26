// Ícono lucide de Meridiano como texto HTML, para el JS de una app Blade que arma marcado
// (columnas de DataTables, contenido de SweetAlert, filas agregadas a mano). Produce el mismo
// SVG que el componente Blade <x-dn::icon>: decorativo por defecto (aria-hidden) y, con
// `label`, una imagen con nombre. Un nombre que no existe lanza un error a propósito.
//
// Uso (Vite resuelve el import del .ts de la misma lista que usa React):
//   import { dnIcon } from '../../vendor/slyn9/meridiano/resources/js/dn-icon.js';
//   cell.innerHTML = `${dnIcon('pencil', { size: 14 })} Editar`;
import { icons } from './react/icons.ts';

const escape = (value) => String(value).replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;');

/**
 * @param {string} name  nombre lucide incluido en el paquete (resources/icons/icons.txt)
 * @param {{ size?: number, className?: string, label?: string }} [options]
 * @returns {string}
 */
export function dnIcon(name, { size = 16, className = '', label = '' } = {}) {
    const inner = icons[name];

    if (inner === undefined) {
        throw new Error(`Meridiano no incluye el ícono «${name}». Agrégalo a resources/icons/icons.txt y regenera.`);
    }

    const classes = className ? `dn-icon ${escape(className)}` : 'dn-icon';
    const a11y = label ? `role="img" aria-label="${escape(label)}"` : 'aria-hidden="true" focusable="false"';

    return `<svg xmlns="http://www.w3.org/2000/svg" width="${Number(size)}" height="${Number(size)}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="${classes}" ${a11y}>${inner}</svg>`;
}

export function hasDnIcon(name) {
    return Object.prototype.hasOwnProperty.call(icons, name);
}
