<?php

namespace Slyn9\Meridiano;

/**
 * Los tokens `--dn-*` como texto CSS, para incrustarlos en una página que no pasa
 * por el CSS compilado de la app: una página de error (debe verse aunque falle el
 * build) o una página pública independiente. Las pantallas normales importan
 * resources/css/tokens.css desde su entrada de Vite.
 */
final class Tokens
{
    private static ?string $css = null;

    public static function css(): string
    {
        return self::$css ??= (string) file_get_contents(__DIR__.'/../resources/css/tokens.css');
    }
}
