import { type ReactNode } from 'react';

export type TimelineTone = 'neutral' | 'primary' | 'success' | 'warning' | 'danger' | 'info';

/** Línea de tiempo vertical (equivalente a `<x-dn::timeline>`). */
export function Timeline({ label, children, className }: { label: string; children: ReactNode; className?: string }) {
    return (
        <ol aria-label={label} className={['dn-timeline', className].filter(Boolean).join(' ')}>
            {children}
        </ol>
    );
}

interface TimelineItemProps {
    /** Qué pasó. */
    title: ReactNode;
    /** Cuándo y quién. */
    meta?: ReactNode;
    tone?: TimelineTone;
    /** Detalle opcional (por ejemplo, el motivo de una anulación). */
    children?: ReactNode;
}

export function TimelineItem({ title, meta, tone = 'neutral', children }: TimelineItemProps) {
    return (
        <li className={['dn-timeline-item', tone !== 'neutral' && `dn-timeline-item--${tone}`].filter(Boolean).join(' ')}>
            <span className="dn-timeline-dot" aria-hidden="true" />
            <p className="dn-timeline-title">{title}</p>
            {meta && <p className="dn-timeline-meta">{meta}</p>}
            {children && <div className="dn-timeline-body">{children}</div>}
        </li>
    );
}
