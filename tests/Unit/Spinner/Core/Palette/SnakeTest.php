<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
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

    private function getTesteeInstance(): IPalette
    {
        return
            new Snake();
    }

    #[Test]
    public function canGetEntriesWithOptions(): void
    {
        $palette = $this->getTesteeInstance();

        $options = $this->getPaletteOptionsMock();

        $entries = $palette->getEntries($options);

        self::assertInstanceOf(\Generator::class, $entries);
    }

    #[Test]
    public function canGetEntriesWithoutOptions(): void
    {
        $palette = $this->getTesteeInstance();

        $entries = $palette->getEntries();

        self::assertInstanceOf(\Generator::class, $entries);
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    #[Test]
    public function returnsFrames(): void
    {
        $palette = $this->getTesteeInstance();

        $traversable = $palette->getEntries();

        self::assertInstanceOf(\Generator::class, $traversable);

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
}
