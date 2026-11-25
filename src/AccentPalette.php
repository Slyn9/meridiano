<?php

namespace Slyn9\Meridiano;

use InvalidArgumentException;

/**
 * Deriva, a partir de UN color de acento elegido por una empresa, todos los
 * tokens de acento de Meridiano para claro y oscuro, y garantiza que cada par
 * cumpla WCAG 2.1 AA.
 *
 * Un acento es válido si el texto blanco sobre él alcanza 4,5:1 (relleno del
 * botón) y él mismo alcanza 4,5:1 como texto sobre el fondo claro. Todo lo
 * demás se calcula: el hover, el fondo del ítem activo, el texto sobre ese
 * fondo y, en oscuro, un azul de texto aclarado hasta alcanzar 4,5:1 contra las
 * superficies oscuras.
 *
 * Las superficies de referencia replican resources/css/tokens.css; una prueba
 * verifica que no se desincronicen.
 */
final class AccentPalette
{
    public const WHITE = '#FFFFFF';

    public const BLACK = '#000000';

    /** Superficies del tema claro sobre las que se lee el acento como texto. */
    public const LIGHT_SURFACES = ['surface' => '#FFFFFF', 'canvas' => '#F2F4F8'];

    /** Superficies del tema oscuro sobre las que se lee el acento como texto. */
    public const DARK_SURFACES = ['surface' => '#181E27', 'canvas' => '#10141B', 'shell' => '#141920'];

    public const TEXT_MIN = 4.5;

    private function __construct(private readonly string $accent) {}

    /**
     * @throws InvalidArgumentException si el color no es válido o no cumple AA.
     */
    public static function from(string $color): self
    {
        $problem = self::problem($color);

        if ($problem !== null) {
            throw new InvalidArgumentException($problem);
        }

        return new self((string) self::normalize($color));
    }

    /** `#abc` o `#aabbcc` (con o sin `#`, cualquier caja) → `#AABBCC`; `null` si no es un color. */
    public static function normalize(string $color): ?string
    {
        $hex = ltrim(trim($color), '#');

        if (preg_match('/^[0-9a-fA-F]{3}$/', $hex)) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        return preg_match('/^[0-9a-fA-F]{6}$/', $hex) ? '#'.strtoupper($hex) : null;
    }

    /** Por qué el color no sirve como acento, en español para el usuario; `null` si sirve. */
    public static function problem(string $color): ?string
    {
        $hex = self::normalize($color);

        if ($hex === null) {
            return 'El color debe escribirse en hexadecimal, por ejemplo #2447D6.';
        }

        $onFill = self::contrast(self::WHITE, $hex);
        if ($onFill < self::TEXT_MIN) {
            return sprintf('El texto blanco sobre %s mide %s:1 y necesita al menos 4,5:1. Elige un tono más oscuro.', $hex, self::format($onFill));
        }

        $asText = self::contrast($hex, self::LIGHT_SURFACES['canvas']);
        if ($asText < self::TEXT_MIN) {
            return sprintf('Como texto sobre el fondo, %s mide %s:1 y necesita al menos 4,5:1. Elige un tono más oscuro.', $hex, self::format($asText));
        }

        return null;
    }

    public function accent(): string
    {
        return $this->accent;
    }

    /** @return array<string, string> tokens `--dn-*` del tema claro */
    public function light(): array
    {
        $subtle = self::mix($this->accent, self::WHITE, 0.90);

        return [
            '--dn-primary' => $this->accent,
            '--dn-primary-fill' => $this->accent,
            '--dn-primary-fill-hover' => self::mix($this->accent, self::BLACK, 0.15),
            '--dn-on-primary-fill' => self::WHITE,
            '--dn-primary-subtle' => $subtle,
            '--dn-primary-strong' => self::reach($this->accent, self::BLACK, [$subtle], 7.0),
            '--dn-focus' => $this->accent,
        ];
    }

    /** @return array<string, string> tokens `--dn-*` del tema oscuro */
    public function dark(): array
    {
        $text = self::reach($this->accent, self::WHITE, array_values(self::DARK_SURFACES), self::TEXT_MIN);
        $subtle = self::mix($this->accent, self::DARK_SURFACES['surface'], 0.75);

        return [
            '--dn-primary' => $text,
            '--dn-primary-fill' => $this->accent,
            '--dn-primary-fill-hover' => self::mix($this->accent, self::BLACK, 0.12),
            '--dn-on-primary-fill' => self::WHITE,
            '--dn-primary-subtle' => $subtle,
            '--dn-primary-strong' => self::reach($this->accent, self::WHITE, [$subtle], 7.0),
            '--dn-focus' => $text,
        ];
    }

    /** CSS listo para un `<style>` que va después del CSS de la app. */
    public function css(): string
    {
        $block = static fn (string $selector, array $tokens): string => $selector." {\n"
            .implode('', array_map(static fn (string $name, string $value): string => "  {$name}: {$value};\n", array_keys($tokens), $tokens))
            ."}\n";

        return $block(':root', $this->light()).$block('.dark', $this->dark());
    }

    /** Relación de contraste WCAG 2.1 entre dos colores `#RRGGBB`. */
    public static function contrast(string $a, string $b): float
    {
        $la = self::luminance($a);
        $lb = self::luminance($b);

        return (max($la, $lb) + 0.05) / (min($la, $lb) + 0.05);
    }

    /** Mezcla lineal en sRGB: `$amount` es la proporción de `$with` (0 = solo `$color`). */
    public static function mix(string $color, string $with, float $amount): string
    {
        $from = self::channels($color);
        $to = self::channels($with);

        return sprintf('#%02X%02X%02X', ...array_map(
            static fn (int $c, int $t): int => (int) round($c + ($t - $c) * $amount),
            $from,
            $to,
        ));
    }

    /**
     * El primer paso (de 5 en 5 %) de `$color` hacia `$toward` que alcanza
     * `$min` contra todos los `$backgrounds`. Hacia blanco o negro el último
     * paso siempre lo alcanza.
     *
     * @param  list<string>  $backgrounds
     */
    private static function reach(string $color, string $toward, array $backgrounds, float $min): string
    {
        for ($step = 0; $step <= 20; $step++) {
            $candidate = self::mix($color, $toward, $step / 20);
            $worst = min(array_map(static fn (string $bg): float => self::contrast($candidate, $bg), $backgrounds));

            if ($worst >= $min) {
                return $candidate;
            }
        }

        return $toward;
    }

    /** @return array{int, int, int} */
    private static function channels(string $hex): array
    {
        $hex = ltrim($hex, '#');

        return [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
    }

    private static function luminance(string $hex): float
    {
        [$r, $g, $b] = array_map(static function (int $c): float {
            $c /= 255;

            return $c <= 0.04045 ? $c / 12.92 : (($c + 0.055) / 1.055) ** 2.4;
        }, self::channels($hex));

        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }

    private static function format(float $ratio): string
    {
        return number_format(floor($ratio * 100) / 100, 2, ',', '');
    }
}
