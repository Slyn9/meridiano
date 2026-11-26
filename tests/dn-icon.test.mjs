// dnIcon(): el mismo SVG que <x-dn::icon> para el JS de las apps Blade.
import { test } from 'node:test';
import assert from 'node:assert/strict';
import { dnIcon, hasDnIcon } from '../resources/js/dn-icon.js';

test('dnIcon: SVG decorativo con la clase dn-icon y el tamaño pedido', () => {
    const svg = dnIcon('pencil', { size: 14, className: 'me-1' });
    assert.match(svg, /^<svg /);
    assert.match(svg, /width="14" height="14"/);
    assert.match(svg, /class="dn-icon me-1"/);
    assert.match(svg, /aria-hidden="true"/);
    assert.match(svg, /<path /);
});

test('dnIcon: con label es una imagen con nombre, escapado', () => {
    const svg = dnIcon('trash-2', { label: 'Borrar "todo" <ya>' });
    assert.match(svg, /role="img" aria-label="Borrar &quot;todo&quot; &lt;ya>"/);
    assert.doesNotMatch(svg, /aria-hidden/);
});

test('dnIcon: un nombre que no existe lanza un error', () => {
    assert.equal(hasDnIcon('no-existe'), false);
    assert.throws(() => dnIcon('no-existe'), /no incluye el ícono/);
});
