<?php

namespace Slyn9\Meridiano;

use InvalidArgumentException;

/**
 * Íconos lucide incluidos en el paquete (resources/icons/lucide.php, generado
 * por scripts/build-icons.mjs). Un nombre que no existe lanza una excepción a
 * propósito: un error de tipeo debe verse en las pruebas, no como un hueco en
 * la pantalla.
 */
final class Icons
{
    /** @var array<string, string>|null */
    private static ?array $icons = null;

    /** Trazos interiores del ícono (sin la etiqueta `<svg>`). */
    public static function inner(string $name): string
    {
        $icons = self::all();

        if (! isset($icons[$name])) {
            throw new InvalidArgumentException("Meridiano no incluye el ícono «{$name}». Agrégalo a resources/icons/icons.txt y regenera lucide.php.");
        }

        return $icons[$name];
    }

    public static function has(string $name): bool
    {
        return isset(self::all()[$name]);
    }

    /** @return array<string, string> */
    public static function all(): array
    {
        return self::$icons ??= require __DIR__.'/../resources/icons/lucide.php';
    }
}
