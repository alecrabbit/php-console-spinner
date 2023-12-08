<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Palette;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Palette\Builder\PaletteTemplateBuilder;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\PaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\Snake;
use AlecRabbit\Tests\TestCase\TestCase;
use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SnakeTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(Snake::class, $palette);
    }

    private function getTesteeInstance(
        ?IPaletteOptions $options = null,
    ): ICharPalette {
        return
            new Snake(
                options: $options ?? $this->getPaletteOptionsMock(),
            );
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    #[Test]
    public function canGetTemplateWithMode(): void
    {
        $palette = $this->getTesteeInstance();

        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::never())
            ->method('getStylingMode')
        ;

        $template = $this->createTemplate($mode, $palette);

        self::assertInstanceOf(PaletteTemplate::class, $template);
        self::assertInstanceOf(Generator::class, $template->getEntries());
        self::assertSame(80, $template->getOptions()->getInterval());
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }

    private function createTemplate(?IPaletteMode $mode = null, ?IPalette $palette = null): IPaletteTemplate
    {
        $mode ??= $this->getPaletteModeMock();

        $palette ??= $this->getTesteeInstance();

        $templateBuilder = new PaletteTemplateBuilder();

        return $templateBuilder
            ->withEntries($palette->getEntries($mode))
            ->withOptions($palette->getOptions($mode))
            ->build()
        ;
    }

    #[Test]
    public function canGetEntriesWithoutMode(): void
    {
        $palette = $this->getTesteeInstance();

        $template = $this->createTemplate(palette: $palette);

        self::assertInstanceOf(PaletteTemplate::class, $template);
        self::assertInstanceOf(Generator::class, $template->getEntries());
        self::assertSame(80, $template->getOptions()->getInterval());
    }

    #[Test]
    public function canGetEntriesWithoutModeCustomOptions(): void
    {
        $options = $this->getPaletteOptionsMock();
        $options
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn(null)
        ;

        $palette = $this->getTesteeInstance(
            options: $options,
        );

        $template = $this->createTemplate(palette: $palette);

        self::assertInstanceOf(PaletteTemplate::class, $template);
        self::assertInstanceOf(Generator::class, $template->getEntries());
        self::assertSame(80, $template->getOptions()->getInterval());
    }

    #[Test]
    public function returnsFrames(): void
    {
        $palette = $this->getTesteeInstance();

        $template = $this->createTemplate(palette: $palette);

        $traversable = $template->getEntries();

        self::assertInstanceOf(Generator::class, $traversable);
        self::assertSame(80, $template->getOptions()->getInterval()); // should pass before unwrapping

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(8, $entries);

        self::assertEquals(new CharFrame('⠏', 1), $entries[0]);
        self::assertEquals(new CharFrame('⠛', 1), $entries[1]);
        self::assertEquals(new CharFrame('⠹', 1), $entries[2]);
        self::assertEquals(new CharFrame('⢸', 1), $entries[3]);
        self::assertEquals(new CharFrame('⣰', 1), $entries[4]);
        self::assertEquals(new CharFrame('⣤', 1), $entries[5]);
        self::assertEquals(new CharFrame('⣆', 1), $entries[6]);
        self::assertEquals(new CharFrame('⡇', 1), $entries[7]);
    }

    #[Test]
    public function returnsFramesWithOptions(): void
    {
        $interval = 100;

        $options = $this->getPaletteOptionsMock();
        $options
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;
        $options
            ->expects(self::once())
            ->method('isReversed')
            ->willReturn(true)
        ;

        $palette = $this->getTesteeInstance(
            options: $options,
        );

        $template = $this->createTemplate(palette: $palette);

        $traversable = $template->getEntries();

        self::assertInstanceOf(Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator
        self::assertSame($interval, $template->getOptions()->getInterval());

        self::assertCount(8, $entries);

        self::assertEquals(new CharFrame('⡇', 1), $entries[0]);
        self::assertEquals(new CharFrame('⣆', 1), $entries[1]);
        self::assertEquals(new CharFrame('⣤', 1), $entries[2]);
        self::assertEquals(new CharFrame('⣰', 1), $entries[3]);
        self::assertEquals(new CharFrame('⢸', 1), $entries[4]);
        self::assertEquals(new CharFrame('⠹', 1), $entries[5]);
        self::assertEquals(new CharFrame('⠛', 1), $entries[6]);
        self::assertEquals(new CharFrame('⠏', 1), $entries[7]);
    }
}
