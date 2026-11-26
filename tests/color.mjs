// Contraste WCAG 2.1 entre colores `#rrggbb` o `hsl(h, s%, l%)`, compartido por las pruebas.
import assert from 'node:assert/strict';

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
