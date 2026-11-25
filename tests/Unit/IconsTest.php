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
