<?php

namespace Slyn9\Meridiano\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Slyn9\Meridiano\Tokens;

class TokensTest extends TestCase
{
    public function test_returns_the_tokens_file_for_both_themes(): void
    {
        $css = Tokens::css();

        $this->assertSame(file_get_contents(__DIR__.'/../../resources/css/tokens.css'), $css);
        $this->assertStringContainsString('--dn-primary:', $css);
        $this->assertStringContainsString('.dark {', $css);
    }

    public function test_the_inline_component_wraps_the_tokens_in_a_style_tag(): void
    {
        $view = (string) file_get_contents(__DIR__.'/../../resources/views/components/tokens.blade.php');

        $this->assertStringContainsString('<style data-meridiano-tokens>{!! \\Slyn9\\Meridiano\\Tokens::css() !!}</style>', $view);
    }
}
