<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette\A;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Tests\Spinner\Unit\Core\Palette\A\Override\AStylePaletteOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class AStylePaletteTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(AStylePaletteOverride::class, $palette);
    }

    private function getTesteeInstance(
        ?IPaletteOptions $options = null,
        ?Traversable $entries = null,
    ): IStylePalette {
        return
            new AStylePaletteOverride(
                options: $options ?? $this->getPaletteOptionsMock(),
                entries: $entries ?? $this->getTraversableMock(),
            );
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    #[Test]
    public function canGetOptions(): void
    {
        $options = $this->getPaletteOptionsMock();

        $palette = $this->getTesteeInstance(
            options: $options,
        );

        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::once())
            ->method('getStylingMode')
            ->willReturn(StylingMethodMode::ANSI24)
        ;

        self::assertInstanceOf(PaletteOptions::class, $palette->getOptions($mode));
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }

    #[Test]
    public function canGetEntries(): void
    {
        $palette = $this->getTesteeInstance();
        $mode = $this->getPaletteModeMock();

        self::assertInstanceOf(Generator::class, $palette->getEntries($mode));
    }

    #[Test]
    public function canGetEntriesTwo(): void
    {
        $styleFrame = new StyleFrame('22', 2);
        $interval = 200;

        $entries = new ArrayObject(['a', $styleFrame, 'b']);

        $options = $this->getPaletteOptionsMock();
        $options
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $palette = $this->getTesteeInstance(
            options: $options,
            entries: $entries,
        );

        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::once())
            ->method('getStylingMode')
            ->willReturn(StylingMethodMode::ANSI24)
        ;

        $traversable = $palette->getEntries($mode);

        self::assertInstanceOf(Generator::class, $traversable);

        self::assertSame($interval, $palette->getOptions()->getInterval());

        $templateEntries = iterator_to_array($traversable);

        self::assertEquals(new StyleFrame('a', 0), $templateEntries[0]);
        self::assertEquals(new StyleFrame('b', 0), $templateEntries[2]);
        self::assertSame($styleFrame, $templateEntries[1]);
    }
}
