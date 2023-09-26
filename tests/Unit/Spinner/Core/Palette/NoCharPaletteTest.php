<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\NoCharPalette;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class NoCharPaletteTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(NoCharPalette::class, $palette);
    }

    private function getTesteeInstance(): IPalette
    {
        return
            new NoCharPalette();
    }

    #[Test]
    public function canGetEntriesWithOptions(): void
    {
        $palette = $this->getTesteeInstance();

        $mode = $this->getPaletteModeMock();

        $entries = $palette->getEntries($mode);

        self::assertInstanceOf(\Generator::class, $entries);
    }

    #[Test]
    public function canGetEntriesWithoutOptions(): void
    {
        $palette = $this->getTesteeInstance();

        $entries = $palette->getEntries();

        self::assertInstanceOf(\Generator::class, $entries);
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }

    #[Test]
    public function returnsOneFrameIterator(): void
    {
        $palette = $this->getTesteeInstance();

        $traversable = $palette->getEntries();

        self::assertInstanceOf(\Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(1, $entries);
        self::assertEquals(new CharFrame('', 0), $entries[0]);
    }
}
