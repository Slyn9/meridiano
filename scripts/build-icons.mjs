// Genera resources/icons/lucide.php con los íconos de resources/icons/icons.txt.
//
// Los trazos salen de lucide (licencia ISC, ver licenses/lucide-ISC.txt); el
// paquete no depende de lucide en tiempo de ejecución: guarda solo los íconos
// que usa. Para agregar uno: sumarlo a icons.txt y correr
//
//   node scripts/build-icons.mjs <ruta a node_modules/lucide-react>
//
// (cualquier app con lucide-react instalado sirve, por ejemplo ContaPE).
import { readFileSync, writeFileSync } from 'node:fs';
import { join } from 'node:path';
import { pathToFileURL } from 'node:url';

const lucideDir = process.argv[2];
if (!lucideDir) {
    console.error('Uso: node scripts/build-icons.mjs <ruta a node_modules/lucide-react>');
    process.exit(1);
}

const root = new URL('..', import.meta.url);
const names = readFileSync(new URL('resources/icons/icons.txt', root), 'utf8').split(/\r?\n/).map((n) => n.trim()).filter(Boolean);
const version = JSON.parse(readFileSync(join(lucideDir, 'package.json'), 'utf8')).version;
const escape = (value) => String(value).replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;');

const entries = [];
for (const name of [...new Set(names)].sort()) {
    const mod = await import(pathToFileURL(join(lucideDir, 'dist/esm/icons', `${name}.js`)).href);
    const markup = mod.__iconNode
        .map(([tag, attrs]) => `<${tag} ${Object.entries(attrs).filter(([k]) => k !== 'key').map(([k, v]) => `${k}="${escape(v)}"`).join(' ')}/>`)
        .join('');
    entries.push(`    '${name}' => '${markup.replace(/\\/g, '\\\\').replace(/'/g, "\\'")}',`);
}

writeFileSync(
    new URL('resources/icons/lucide.php', root),
    `<?php\n\n// Generado por scripts/build-icons.mjs desde lucide-react ${version} (ISC, ver licenses/lucide-ISC.txt).\n// No editar a mano: agregar el nombre a icons.txt y volver a generar.\n\nreturn [\n${entries.join('\n')}\n];\n`,
);
console.log(`${entries.length} íconos escritos (lucide-react ${version})`);
