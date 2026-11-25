// Contraste WCAG 2.1 de cada par documentado de resources/css/tokens.css.
// Sin dependencias: `node --test` (Node 18+).
import { readFileSync } from 'node:fs';
import { test } from 'node:test';
import assert from 'node:assert/strict';

const css = readFileSync(new URL('../resources/css/tokens.css', import.meta.url), 'utf8');

/** Variables `--dn-*` de un bloque `selector { … }`. */
function tokensOf(selector) {
    const start = css.indexOf(`${selector} {`);
    assert.notEqual(start, -1, `falta el bloque ${selector}`);
    const body = css.slice(start, css.indexOf('}', start));
    return Object.fromEntries([...body.matchAll(/--dn-([a-z0-9-]+):\s*([^;]+);/g)].map((m) => [m[1], m[2].trim()]));
}

const light = tokensOf(':root');
const themes = { claro: light, oscuro: { ...light, ...tokensOf('.dark') } };

/** sRGB 0–1 de un color `#rrggbb` o `hsl(h, s%, l%)`. */
function rgb(value) {
    const hex = value.match(/^#([0-9a-f]{6})$/i);
    if (hex) {
        return [0, 2, 4].map((i) => parseInt(hex[1].slice(i, i + 2), 16) / 255);
    }
    const hsl = value.match(/^hsl\(\s*([\d.]+)\s*,\s*([\d.]+)%\s*,\s*([\d.]+)%\s*\)$/);
    assert.ok(hsl, `color no reconocido: ${value}`);
    const [h, s, l] = [Number(hsl[1]), Number(hsl[2]) / 100, Number(hsl[3]) / 100];
    const k = (n) => (n + h / 30) % 12;
    const a = s * Math.min(l, 1 - l);
    return [0, 8, 4].map((n) => l - a * Math.max(-1, Math.min(k(n) - 3, Math.min(9 - k(n), 1))));
}

function luminance(value) {
    const [r, g, b] = rgb(value).map((c) => (c <= 0.04045 ? c / 12.92 : ((c + 0.055) / 1.055) ** 2.4));
    return 0.2126 * r + 0.7152 * g + 0.0722 * b;
}

export function ratio(a, b) {
    const [hi, lo] = [luminance(a), luminance(b)].sort((x, y) => y - x);
    return (hi + 0.05) / (lo + 0.05);
}

// [primer plano, fondo, mínimo, uso]. 4.5 = texto (1.4.3); 3 = borde de control y foco (1.4.11).
const pairs = [
    ['text', 'canvas', 4.5, 'texto principal sobre el fondo'],
    ['text', 'surface', 4.5, 'texto principal sobre una tarjeta'],
    ['text', 'neutral-subtle', 4.5, 'texto sobre relleno neutro'],
    ['text', 'shell', 4.5, 'texto de la barra superior'],
    ['text-muted', 'shell', 4.5, 'texto secundario de la barra superior'],
    ['text-muted', 'canvas', 4.5, 'texto secundario sobre el fondo'],
    ['text-muted', 'surface', 4.5, 'texto secundario sobre una tarjeta'],
    ['text-muted', 'neutral-subtle', 4.5, 'encabezado de tabla'],
    ['primary', 'surface', 4.5, 'enlace sobre una tarjeta'],
    ['primary', 'canvas', 4.5, 'enlace sobre el fondo'],
    ['on-primary-fill', 'primary-fill', 4.5, 'botón primario'],
    ['on-primary-fill', 'primary-fill-hover', 4.5, 'botón primario en hover'],
    ['primary-strong', 'primary-subtle', 4.5, 'ítem activo del menú'],
    ['text', 'primary-subtle', 4.5, 'texto sobre fila seleccionada'],
    ['on-success', 'success', 4.5, 'insignia sólida de éxito'],
    ['success-text', 'success-subtle', 4.5, 'insignia tenue de éxito'],
    ['success-text', 'surface', 4.5, 'texto de éxito'],
    ['on-warning', 'warning', 4.5, 'insignia sólida de advertencia'],
    ['warning-text', 'warning-subtle', 4.5, 'insignia tenue de advertencia'],
    ['warning-text', 'surface', 4.5, 'texto de advertencia'],
    ['on-danger', 'danger', 4.5, 'botón destructivo'],
    ['danger-text', 'danger-subtle', 4.5, 'insignia tenue de error'],
    ['danger-text', 'surface', 4.5, 'texto de error'],
    ['on-info', 'info', 4.5, 'insignia sólida informativa'],
    ['info-text', 'info-subtle', 4.5, 'insignia tenue informativa'],
    ['info-text', 'surface', 4.5, 'texto informativo'],
    ['violet-text', 'violet-subtle', 4.5, 'etiqueta de categoría violeta'],
    ['violet-text', 'surface', 4.5, 'texto de categoría violeta'],
    ['violet', 'surface', 3, 'punto de categoría violeta'],
    ['control-border', 'surface', 3, 'borde de un campo'],
    ['control-border', 'canvas', 3, 'borde de un campo sobre el fondo'],
    ['focus', 'surface', 3, 'anillo de foco'],
    ['focus', 'canvas', 3, 'anillo de foco sobre el fondo'],
];

// Pares que la paleta no cumple. Debe quedar vacío: un par nuevo que no llega
// al mínimo se corrige en el token, no se agrega aquí. (La 0.1.0, con los
// valores heredados de ContaPE, tenía 7; la 0.2.0 los resolvió.)
const knownFailures = new Set([]);

for (const [theme, tokens] of Object.entries(themes)) {
    for (const [fg, bg, min, use] of pairs) {
        const key = `${theme}: ${fg} / ${bg}`;
        test(`${key} (${use}) ≥ ${min}:1`, () => {
            assert.ok(tokens[fg], `falta --dn-${fg}`);
            assert.ok(tokens[bg], `falta --dn-${bg}`);
            const measured = ratio(tokens[fg], tokens[bg]);
            if (knownFailures.has(key)) {
                assert.ok(measured < min, `${key} ya cumple (${measured.toFixed(2)}:1): quítalo de knownFailures`);
                return;
            }
            assert.ok(measured >= min, `${key} mide ${measured.toFixed(2)}:1, mínimo ${min}:1`);
        });
    }
}

// El velo es translúcido: se compone sobre el peor caso, una foto blanca.
test('velo: texto blanco sobre el velo encima de una foto blanca ≥ 4.5:1', () => {
    const scrim = light.scrim.match(/^rgb\((\d+) (\d+) (\d+) \/ ([\d.]+)\)$/);
    assert.ok(scrim, `velo no reconocido: ${light.scrim}`);
    const alpha = Number(scrim[4]);
    const hex = [1, 2, 3].map((i) => Math.round(Number(scrim[i]) * alpha + 255 * (1 - alpha)).toString(16).padStart(2, '0')).join('');
    const measured = ratio(light['on-scrim'], `#${hex}`);
    assert.ok(measured >= 4.5, `mide ${measured.toFixed(2)}:1`);
});
