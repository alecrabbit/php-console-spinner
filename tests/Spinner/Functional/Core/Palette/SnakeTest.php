<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Palette;

use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Snake;
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
    public function returnsFrames(): void
    {
        $interval = 80;
        $options = $this->getPaletteOptionsMock();
        $options
            ->expects($this->once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $palette = $this->getTesteeInstance(
            options: $options,
        );

        self::assertSame($interval, $palette->getOptions()->getInterval());

        self::assertEquals(new CharSequenceFrame('⠛', 1), $palette->getFrame());
        self::assertEquals(new CharSequenceFrame('⠹', 1), $palette->getFrame());
        self::assertEquals(new CharSequenceFrame('⢸', 1), $palette->getFrame());
        self::assertEquals(new CharSequenceFrame('⣰', 1), $palette->getFrame());
        self::assertEquals(new CharSequenceFrame('⣤', 1), $palette->getFrame());
        self::assertEquals(new CharSequenceFrame('⣆', 1), $palette->getFrame());
        self::assertEquals(new CharSequenceFrame('⡇', 1), $palette->getFrame());
        self::assertEquals(new CharSequenceFrame('⠏', 1), $palette->getFrame());
    }
}
