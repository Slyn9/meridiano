import { type SVGProps } from 'react';
import { icons, type DnIconName } from './icons';

interface DnIconProps extends Omit<SVGProps<SVGSVGElement>, 'name'> {
    name: DnIconName;
    size?: number;
    /** Nombre accesible; sin él el ícono es decorativo (aria-hidden). */
    label?: string;
}

/**
 * Ícono lucide incluido en Meridiano (la misma lista que `<x-dn::icon>`).
 * Los trazos son estáticos y vienen del propio paquete (icons.ts, generado).
 */
export function DnIcon({ name, size = 16, label, className, ...props }: DnIconProps) {
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            width={size}
            height={size}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            strokeWidth={2}
            strokeLinecap="round"
            strokeLinejoin="round"
            className={['dn-icon', className].filter(Boolean).join(' ')}
            {...(label ? { role: 'img', 'aria-label': label } : { 'aria-hidden': true, focusable: false })}
            dangerouslySetInnerHTML={{ __html: icons[name] }}
            {...props}
        />
    );
}
