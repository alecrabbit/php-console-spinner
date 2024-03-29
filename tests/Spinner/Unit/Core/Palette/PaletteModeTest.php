<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\PaletteMode;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class PaletteModeTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(PaletteMode::class, $palette);
    }

    private function getTesteeInstance(
        ?StylingMethodMode $stylingMode = null,
    ): IPaletteMode {
        return
            new PaletteMode(
                stylingMode: $stylingMode ?? StylingMethodMode::NONE,
            );
    }

    #[Test]
    public function canGetStylingMode(): void
    {
        $stylingMode = StylingMethodMode::ANSI8;

        $palette = $this->getTesteeInstance(
            stylingMode: $stylingMode,
        );

        self::assertSame($stylingMode, $palette->getStylingMode());
    }
}
