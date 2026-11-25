import { Fragment, type ElementType, type ReactNode } from 'react';
import { DnIcon } from './icon';

export type ProcessStepState = 'done' | 'current' | 'pending';

export interface ProcessStep {
    key: string;
    label: ReactNode;
    state: ProcessStepState;
    /** Una línea bajo el paso (por ejemplo «Contabilizada»). */
    meta?: ReactNode;
    href?: string;
}

const STATE_TEXT: Record<ProcessStepState, string> = { done: 'completado', current: 'paso actual', pending: 'pendiente' };

interface ProcessFlowProps {
    label: string;
    steps: ProcessStep[];
    /** Apilado siempre (columnas angostas). Por defecto, horizontal desde 640 px. */
    vertical?: boolean;
    /** Componente de enlace (p. ej. el `Link` de Inertia); por defecto `<a>`. */
    linkAs?: ElementType;
    className?: string;
}

/** Flujo de pasos de solo lectura (equivalente a `<x-dn::process-flow>`). */
export function ProcessFlow({ label, steps, vertical = false, linkAs: LinkTag = 'a', className }: ProcessFlowProps) {
    return (
        <ol aria-label={label} className={['dn-process', vertical && 'dn-process--vertical', className].filter(Boolean).join(' ')}>
            {steps.map((step, index) => (
                <Fragment key={step.key}>
                    {index > 0 && (
                        <li className="dn-process-sep" aria-hidden="true">
                            <DnIcon name="chevrons-right" size={14} />
                        </li>
                    )}
                    <li className="dn-process-step" data-state={step.state} aria-current={step.state === 'current' ? 'step' : undefined}>
                        <span className="dn-process-marker" aria-hidden="true">
                            {step.state === 'done' ? <DnIcon name="check" size={14} /> : index + 1}
                        </span>
                        <span className="dn-process-text">
                            {step.href ? (
                                <LinkTag href={step.href} className="dn-process-label">
                                    {step.label}
                                </LinkTag>
                            ) : (
                                <span className="dn-process-label">{step.label}</span>
                            )}
                            <span className="dn-sr-only">({STATE_TEXT[step.state]})</span>
                            {step.meta && <span className="dn-process-meta">{step.meta}</span>}
                        </span>
                    </li>
                </Fragment>
            ))}
        </ol>
    );
}
