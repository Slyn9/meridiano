// Coherencia de los puentes de resources/css/bridges con tokens.css.
// Sin dependencias: `node --test` (Node 18+).
import { readFileSync, readdirSync } from 'node:fs';
import { test } from 'node:test';
import assert from 'node:assert/strict';
import { ratio } from './color.mjs';

const read = (path) => readFileSync(new URL(`../resources/css/${path}`, import.meta.url), 'utf8');
const tokensCss = read('tokens.css');

function hexTokensOf(selector) {
    const start = tokensCss.indexOf(`${selector} {`);
    const body = tokensCss.slice(start, tokensCss.indexOf('}', start));
    return Object.fromEntries([...body.matchAll(/--dn-([a-z0-9-]+):\s*(#[0-9A-Fa-f]{6});/g)].map((m) => [m[1], m[2]]));
}

const light = hexTokensOf(':root');
const themes = { claro: light, oscuro: { ...light, ...hexTokensOf('.dark') } };
const declared = new Set([...tokensCss.matchAll(/--dn-([a-z0-9-]+):/g)].map((m) => m[1]));

for (const file of readdirSync(new URL('../resources/css/bridges/', import.meta.url))) {
    test(`${file}: cada token que usa existe en tokens.css`, () => {
        const used = new Set([...read(`bridges/${file}`).matchAll(/var\(--dn-([a-z0-9-]+)\)/g)].map((m) => m[1]));
        const missing = [...used].filter((name) => !declared.has(name));
        assert.deepEqual(missing, [], `tokens inexistentes: ${missing.join(', ')}`);
    });
}

// ---- Puente Bootstrap -----------------------------------------------------
const bootstrap = read('bridges/bootstrap.css');

function blockOf(css, selector) {
    const start = css.indexOf(selector.includes('{') ? `\n${selector}` : `\n${selector} {`);
    assert.notEqual(start, -1, `falta el bloque ${selector}`);
    return css.slice(start, css.indexOf('}', start));
}

const hex = (triplet) => `#${triplet.split(',').map((n) => Number(n).toString(16).padStart(2, '0')).join('')}`;

test('bootstrap.css: las tripletas RGB coinciden con los tokens en claro y en oscuro', () => {
    const map = { ':root': themes.claro, '.dark': themes.oscuro };
    for (const [selector, palette] of Object.entries(map)) {
        // El bloque propio del tema (abre con `--dnb-shade`), no el compartido `:root, [data-bs-theme], .dark`.
        const body = blockOf(bootstrap, `${selector} {\n    --dnb-shade`);
        const triplets = [...body.matchAll(/--bs-([a-z-]+)-rgb:\s*([\d, ]+);/g)];
        assert.ok(triplets.length > 10, `${selector} sin tripletas`);
        const values = Object.values(palette).map((v) => v.toLowerCase());
        for (const [, name, triplet] of triplets) {
            assert.ok(values.includes(hex(triplet)), `${selector} --bs-${name}-rgb (${hex(triplet)}) no es ningún token`);
        }
    }
});

/** Mezcla sRGB como `color-mix(in srgb, a p%, b)`. */
function mix(a, b, p) {
    const ch = (h) => [1, 3, 5].map((i) => parseInt(h.slice(i, i + 2), 16));
    const [x, y] = [ch(a), ch(b)];
    return `#${x.map((c, i) => Math.round(c * p + y[i] * (1 - p)).toString(16).padStart(2, '0')).join('')}`;
}

// [texto sobre el relleno, relleno, color en hover]; `shade` es `--dnb-shade` (negro en claro, blanco en oscuro): lo que declara el puente para cada botón.
const buttons = {
    primary: ['on-primary-fill', 'primary-fill', (t) => t['primary-fill-hover']],
    secondary: ['surface', 'text-muted', (t) => mix(t['text-muted'], t.text, 0.8)],
    success: ['on-success', 'success', (t, shade) => mix(t.success, shade, 0.85)],
    info: ['on-info', 'info', (t, shade) => mix(t.info, shade, 0.85)],
    warning: ['on-warning', 'warning', (t, shade) => mix(t.warning, shade, 0.85)],
    danger: ['on-danger', 'danger', (t, shade) => mix(t.danger, shade, 0.85)],
    light: ['text', 'neutral-subtle', (t) => mix(t['neutral-subtle'], t.text, 0.85)],
};

for (const [theme, tokens] of Object.entries(themes)) {
    for (const [role, [on, fill, hover]] of Object.entries(buttons)) {
        test(`bootstrap.css ${theme}: .btn-${role} y su hover ≥ 4.5:1`, () => {
            const rest = ratio(tokens[on], tokens[fill]);
            const over = ratio(tokens[on], hover(tokens, theme === 'claro' ? '#000000' : '#ffffff'));
            assert.ok(rest >= 4.5, `reposo mide ${rest.toFixed(2)}:1`);
            assert.ok(over >= 4.5, `hover mide ${over.toFixed(2)}:1`);
        });
    }
}

test('bootstrap.css: el botón de cada rol usa los tokens que mide esta prueba', () => {
    for (const [role, [on, fill]] of Object.entries(buttons)) {
        const body = blockOf(bootstrap, `.btn-${role}`);
        assert.match(body, new RegExp(`--bs-btn-color: var\\(--dn-${on}\\);`), `.btn-${role}: texto`);
        assert.match(body, new RegExp(`--bs-btn-bg: var\\(--dn-${fill}\\);`), `.btn-${role}: relleno`);
    }
});
