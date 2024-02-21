<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\LegacyNoStylePalette;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\StyleSequenceFrame;
use AlecRabbit\Tests\TestCase\TestCase;
use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @deprecated
 */
final class LegacyNoStylePaletteTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyNoStylePalette::class, $palette);
    }

    private function getTesteeInstance(): IPalette
    {
        return
            new LegacyNoStylePalette();
    }

    #[Test]
    public function canGetEntries(): void
    {
        $palette = $this->getTesteeInstance();
        $mode = $this->getPaletteModeMock();

        $traversable = $palette->getEntries($mode);

        self::assertInstanceOf(Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(1, $entries);
        self::assertEquals(new StyleSequenceFrame('%s', 0), $entries[0]);
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }

    #[Test]
    public function canGetOptions(): void
    {
        $palette = $this->getTesteeInstance();

        $mode = $this->getPaletteModeMock();

        self::assertInstanceOf(PaletteOptions::class, $palette->getOptions($mode));
    }
}
