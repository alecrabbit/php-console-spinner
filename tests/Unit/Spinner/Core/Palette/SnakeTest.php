<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Snake;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Tests\TestCase\TestCase;
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
    ): IPalette {
        return
            new Snake(
                options: $options ?? $this->getPaletteOptionsMock(),
            );
    }

    #[Test]
    public function canGetEntriesWithMode(): void
    {
        $palette = $this->getTesteeInstance();

        $mode = $this->getPaletteModeMock();

        $entries = $palette->getEntries($mode);

        self::assertInstanceOf(\Generator::class, $entries);
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }

    #[Test]
    public function canGetEntriesWithoutMode(): void
    {
        $palette = $this->getTesteeInstance();

        $entries = $palette->getEntries();

        self::assertInstanceOf(\Generator::class, $entries);
    }

    #[Test]
    public function returnsFrames(): void
    {
        $palette = $this->getTesteeInstance();

        $traversable = $palette->getEntries();

        self::assertInstanceOf(\Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(8, $entries);

        self::assertSame(80, $palette->getOptions()->getInterval());
        self::assertNull($palette->getOptions()->getReversed());

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
            ->method('getReversed')
            ->willReturn(true)
        ;

        $palette = $this->getTesteeInstance(
            options: $options,
        );

        $traversable = $palette->getEntries();

        self::assertInstanceOf(\Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(8, $entries);

        self::assertSame($interval, $palette->getOptions()->getInterval());
        self::assertTrue($palette->getOptions()->getReversed());

        self::assertEquals(new CharFrame('⡇', 1), $entries[0]);
        self::assertEquals(new CharFrame('⣆', 1), $entries[1]);
        self::assertEquals(new CharFrame('⣤', 1), $entries[2]);
        self::assertEquals(new CharFrame('⣰', 1), $entries[3]);
        self::assertEquals(new CharFrame('⢸', 1), $entries[4]);
        self::assertEquals(new CharFrame('⠹', 1), $entries[5]);
        self::assertEquals(new CharFrame('⠛', 1), $entries[6]);
        self::assertEquals(new CharFrame('⠏', 1), $entries[7]);
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }
}
