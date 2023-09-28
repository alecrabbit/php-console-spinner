<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\NoCharPalette;
use AlecRabbit\Spinner\Core\Palette\PaletteTemplate;
use AlecRabbit\Tests\TestCase\TestCase;
use Generator;
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
    public function canGetTemplateWithMode(): void
    {
        $palette = $this->getTesteeInstance();

        $mode = $this->getPaletteModeMock();

        $template = $palette->getTemplate($mode);

        self::assertInstanceOf(PaletteTemplate::class, $template);
        self::assertInstanceOf(Generator::class, $template->getEntries());
        self::assertNull($template->getInterval());
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }

    #[Test]
    public function canGetEntriesWithoutMode(): void
    {
        $palette = $this->getTesteeInstance();

        $template = $palette->getTemplate();

        self::assertInstanceOf(PaletteTemplate::class, $template);
        self::assertInstanceOf(Generator::class, $template->getEntries());
        self::assertNull($template->getInterval());
    }

    #[Test]
    public function returnsOneFrameIterator(): void
    {
        $palette = $this->getTesteeInstance();

        $template = $palette->getTemplate();

        $traversable = $template->getEntries();

        self::assertInstanceOf(Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(1, $entries);
        self::assertEquals(new CharFrame('', 0), $entries[0]);
    }
}
