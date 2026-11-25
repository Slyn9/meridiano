import { useId, useState, type ElementType, type ReactNode } from 'react';
import { DnIcon } from './icon';

interface ExpandableRowProps {
    /** Celdas de la fila, después de la del botón. */
    children: ReactNode;
    /** Contenido que se despliega debajo. */
    detail: ReactNode;
    /** Columnas de la tabla, incluida la del botón. */
    colSpan: number;
    /** Nombre accesible del botón («Ver conceptos de Ana Pérez»). */
    label: string;
    defaultOpen?: boolean;
    /** Componentes de fila y celda de la tabla de la app (p. ej. TableRow/TableCell de shadcn); por defecto <tr>/<td>. */
    row?: ElementType;
    cell?: ElementType;
}

/**
 * Fila de tabla que despliega un detalle debajo (equivalente a `<x-dn::expandable-row>`).
 * Devuelve dos filas: va dentro del <tbody> de la tabla. El botón anuncia su estado con
 * aria-expanded y apunta al detalle con aria-controls.
 */
export function ExpandableRow({ children, detail, colSpan, label, defaultOpen = false, row: Row = 'tr', cell: Cell = 'td' }: ExpandableRowProps) {
    const [open, setOpen] = useState(defaultOpen);
    const detailId = useId();

    return (
        <>
            <Row>
                <Cell className="dn-expand-cell">
                    <button type="button" className="dn-expand-btn" aria-expanded={open} aria-controls={detailId} aria-label={label} onClick={() => setOpen((value) => !value)}>
                        <DnIcon name="chevron-right" />
                    </button>
                </Cell>
                {children}
            </Row>
            <Row id={detailId} className="dn-row-detail" hidden={!open}>
                <Cell colSpan={colSpan}>{detail}</Cell>
            </Row>
        </>
    );
}
