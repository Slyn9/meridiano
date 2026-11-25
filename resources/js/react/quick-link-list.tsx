import { type ComponentPropsWithoutRef, type ElementType, type ReactNode } from 'react';

/** Lista de accesos rápidos (equivalente a `<x-dn::quick-links>`). */
export function QuickLinkList({ label, columns = 1, children }: { label?: string; columns?: 1 | 2 | 3; children: ReactNode }) {
    return (
        <ul aria-label={label} className={['dn-quick-links', columns > 1 && `dn-quick-links--${columns}`].filter(Boolean).join(' ')}>
            {children}
        </ul>
    );
}

type QuickLinkProps<T extends ElementType> = {
    href: string;
    title: ReactNode;
    description?: ReactNode;
    /** Ícono ya dibujado (p. ej. de lucide-react o `<DnIcon>`). */
    icon?: ReactNode;
    /** Componente de enlace (p. ej. el `Link` de Inertia); por defecto `<a>`. */
    as?: T;
} & Omit<ComponentPropsWithoutRef<T>, 'href' | 'title' | 'as' | 'className' | 'children'>;

/** Acceso rápido: ícono en un cuadro tenue, título y una línea de descripción. Toda la fila es el enlace. */
export function QuickLink<T extends ElementType = 'a'>({ href, title, description, icon, as, ...rest }: QuickLinkProps<T>) {
    const LinkTag: ElementType = as ?? 'a';

    return (
        <li>
            <LinkTag href={href} className="dn-quick-link" {...rest}>
                {icon && (
                    <span className="dn-quick-link-icon" aria-hidden="true">
                        {icon}
                    </span>
                )}
                <span className="dn-quick-link-text">
                    <span className="dn-quick-link-title">{title}</span>
                    {description && <span className="dn-quick-link-desc">{description}</span>}
                </span>
            </LinkTag>
        </li>
    );
}
