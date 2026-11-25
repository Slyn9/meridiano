<?php

namespace Slyn9\Meridiano\Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Slyn9\Meridiano\Icons;

class IconsTest extends TestCase
{
    public function test_every_icon_listed_in_icons_txt_was_generated(): void
    {
        $listed = array_filter(array_map('trim', file(__DIR__.'/../../resources/icons/icons.txt')));

        foreach ($listed as $name) {
            $this->assertTrue(Icons::has($name), "falta «{$name}» en lucide.php: correr scripts/build-icons.mjs");
        }
        $this->assertCount(count(array_unique($listed)), Icons::all(), 'lucide.php trae íconos que icons.txt no lista');
    }

    public function test_react_and_blade_share_exactly_the_same_icons(): void
    {
        $ts = (string) file_get_contents(__DIR__.'/../../resources/js/react/icons.ts');
        preg_match_all("/^    '([a-z0-9-]+)': '(.*)',$/m", $ts, $matches);
        $react = array_combine($matches[1], array_map('stripslashes', $matches[2]));

        $this->assertSame(array_keys(Icons::all()), array_keys($react), 'icons.ts y lucide.php deben listar los mismos íconos: correr scripts/build-icons.mjs');
        $this->assertSame(Icons::all(), $react, 'los trazos de cada ícono deben ser idénticos en los dos stacks');
    }

    public function test_returns_the_inner_markup_of_an_icon(): void
    {
        $this->assertStringStartsWith('<path d="', Icons::inner('plus'));
        $this->assertStringNotContainsString('<svg', Icons::inner('plus'));
    }

    public function test_an_unknown_icon_fails_loudly(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('icons.txt');

        Icons::inner('no-existe');
    }
}
