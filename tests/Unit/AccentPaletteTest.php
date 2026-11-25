<?php

namespace Slyn9\Meridiano\Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Slyn9\Meridiano\AccentPalette;

class AccentPaletteTest extends TestCase
{
    /** @return array<string, array{string, string|null}> */
    public static function colorsToNormalize(): array
    {
        return [
            'seis dígitos en minúscula' => ['#2447d6', '#2447D6'],
            'sin numeral' => ['2447D6', '#2447D6'],
            'tres dígitos' => ['#abc', '#AABBCC'],
            'con espacios' => ['  #7c3aed ', '#7C3AED'],
            'no es hexadecimal' => ['azul', null],
            'cinco dígitos' => ['#12345', null],
            'ocho dígitos (con alfa)' => ['#2447D6FF', null],
        ];
    }

    #[DataProvider('colorsToNormalize')]
    public function test_normalizes_hex_colors(string $input, ?string $expected): void
    {
        $this->assertSame($expected, AccentPalette::normalize($input));
    }

    /** @return array<string, array{string}> */
    public static function legibleAccents(): array
    {
        return [
            'azul de Meridiano' => ['#2447D6'],
            'violeta' => ['#7C3AED'],
            'verde oscuro' => ['#17773A'],
            'rojo' => ['#C42B2B'],
            'petróleo' => ['#0B6A86'],
            'negro' => ['#000000'],
        ];
    }

    #[DataProvider('legibleAccents')]
    public function test_accepts_accents_that_meet_aa(string $accent): void
    {
        $this->assertNull(AccentPalette::problem($accent));
        $this->assertSame($accent, AccentPalette::from($accent)->accent());
    }

    /** @return array<string, array{string, string}> */
    public static function illegibleAccents(): array
    {
        return [
            'ámbar: el blanco encima no se lee' => ['#F2B33D', 'texto blanco'],
            'gris claro' => ['#CCCCCC', 'texto blanco'],
            'blanco' => ['#FFFFFF', 'texto blanco'],
            'texto inválido' => ['rojo', 'hexadecimal'],
        ];
    }

    #[DataProvider('illegibleAccents')]
    public function test_rejects_accents_that_fail_aa_with_a_reason(string $accent, string $reasonFragment): void
    {
        $this->assertStringContainsString($reasonFragment, (string) AccentPalette::problem($accent));

        $this->expectException(InvalidArgumentException::class);
        AccentPalette::from($accent);
    }

    public function test_every_derived_pair_meets_aa_for_a_sweep_of_valid_accents(): void
    {
        $checked = 0;

        foreach (range(0, 345, 15) as $hue) {
            foreach ([0.35, 0.55, 0.75, 0.95] as $saturation) {
                foreach ([0.12, 0.22, 0.32, 0.42, 0.50] as $lightness) {
                    $accent = self::hsl($hue, $saturation, $lightness);

                    if (AccentPalette::problem($accent) !== null) {
                        continue;
                    }

                    $palette = AccentPalette::from($accent);
                    $light = $palette->light();
                    $dark = $palette->dark();

                    foreach (AccentPalette::LIGHT_SURFACES as $surface) {
                        $this->assertAtLeast(4.5, $light['--dn-primary'], $surface, "$accent claro: texto");
                        $this->assertAtLeast(3.0, $light['--dn-focus'], $surface, "$accent claro: foco");
                    }
                    $this->assertAtLeast(4.5, $light['--dn-on-primary-fill'], $light['--dn-primary-fill'], "$accent claro: botón");
                    $this->assertAtLeast(4.5, $light['--dn-on-primary-fill'], $light['--dn-primary-fill-hover'], "$accent claro: hover");
                    $this->assertAtLeast(4.5, $light['--dn-primary-strong'], $light['--dn-primary-subtle'], "$accent claro: ítem activo");

                    foreach (AccentPalette::DARK_SURFACES as $surface) {
                        $this->assertAtLeast(4.5, $dark['--dn-primary'], $surface, "$accent oscuro: texto");
                        $this->assertAtLeast(3.0, $dark['--dn-focus'], $surface, "$accent oscuro: foco");
                    }
                    $this->assertAtLeast(4.5, $dark['--dn-on-primary-fill'], $dark['--dn-primary-fill'], "$accent oscuro: botón");
                    $this->assertAtLeast(4.5, $dark['--dn-on-primary-fill'], $dark['--dn-primary-fill-hover'], "$accent oscuro: hover");
                    $this->assertAtLeast(4.5, $dark['--dn-primary-strong'], $dark['--dn-primary-subtle'], "$accent oscuro: ítem activo");

                    $checked++;
                }
            }
        }

        $this->assertGreaterThan(100, $checked, 'el barrido debe cubrir más de 100 acentos válidos');
    }

    public function test_css_declares_the_seven_accent_tokens_for_each_theme(): void
    {
        $css = AccentPalette::from('#7C3AED')->css();

        foreach (['--dn-primary', '--dn-primary-fill', '--dn-primary-fill-hover', '--dn-on-primary-fill', '--dn-primary-subtle', '--dn-primary-strong', '--dn-focus'] as $token) {
            $this->assertSame(2, substr_count($css, "  {$token}: "), $token);
        }
        $this->assertStringStartsWith(':root {', $css);
        $this->assertStringContainsString(".dark {\n", $css);
        $this->assertStringContainsString('--dn-primary-fill: #7C3AED;', $css);
    }

    public function test_reference_surfaces_match_tokens_css(): void
    {
        $css = (string) file_get_contents(__DIR__.'/../../resources/css/tokens.css');
        $darkStart = (int) strpos($css, '.dark {');
        $value = static function (string $block, string $token): string {
            preg_match('/--dn-'.$token.':\s*([^;]+);/', $block, $match);

            return strtoupper(trim($match[1] ?? ''));
        };

        foreach (AccentPalette::LIGHT_SURFACES as $token => $hex) {
            $this->assertSame($hex, $value(substr($css, 0, $darkStart), $token), "claro: --dn-{$token}");
        }
        foreach (AccentPalette::DARK_SURFACES as $token => $hex) {
            $this->assertSame($hex, $value(substr($css, $darkStart), $token), "oscuro: --dn-{$token}");
        }
    }

    private function assertAtLeast(float $min, string $foreground, string $background, string $message): void
    {
        $ratio = AccentPalette::contrast($foreground, $background);
        $this->assertGreaterThanOrEqual($min, $ratio, sprintf('%s: %s sobre %s mide %.2f:1', $message, $foreground, $background, $ratio));
    }

    private static function hsl(float $h, float $s, float $l): string
    {
        $a = $s * min($l, 1 - $l);
        $channel = static function (int $n) use ($h, $l, $a): int {
            $k = fmod($n + $h / 30, 12);

            return (int) round(($l - $a * max(-1, min($k - 3, 9 - $k, 1))) * 255);
        };

        return sprintf('#%02X%02X%02X', $channel(0), $channel(8), $channel(4));
    }
}
