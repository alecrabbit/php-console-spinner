<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Palette\CustomStylePalette;
use AlecRabbit\Spinner\Core\StyleSequenceFrame;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;

final class CustomStylePaletteTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(CustomStylePalette::class, $palette);
    }

    private function getTesteeInstance(
        ?ArrayObject $frames = null,
        ?IPaletteOptions $options = null,
        ?int $index = null,
    ): IStylePalette {
        return
            new CustomStylePalette(
                frames: $frames ?? $this->getFramesMock(),
                options: $options ?? $this->getPaletteOptionsMock(),
                index: $index ?? 0,
            );
    }

    private function getFramesMock(): MockObject&ArrayObject
    {
        return $this->createMock(ArrayObject::class);
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    #[Test]
    public function canGetFrame(): void
    {
        $frames = $this->getFramesMock();
        $palette = $this->getTesteeInstance(
            frames: $frames,
        );

        $frame = new StyleSequenceFrame('%s', 0);

        $actual = $palette->getFrame();

        self::assertEquals($frame, $actual);
        self::assertSame($actual, $palette->getFrame());
        self::assertSame($actual, $palette->getFrame());
        self::assertSame($actual, $palette->getFrame());
    }

    #[Test]
    public function canBeCreatedWithCustomFrames(): void
    {
        $frames = new ArrayObject(
            [
                new StyleSequenceFrame('%s   ', 3),
                new StyleSequenceFrame('%s.  ', 3),
                new StyleSequenceFrame('%s.. ', 3),
                new StyleSequenceFrame('%s...', 3),
                new stdClass(),
                new StyleSequenceFrame('%s ..', 3),
                new StyleSequenceFrame('%s  .', 3),
                new StyleSequenceFrame('%s   ', 3),
            ]
        );
        $palette = $this->getTesteeInstance(
            frames: $frames,
        );

        self::assertEquals(new StyleSequenceFrame('%s.  ', 3), $palette->getFrame());
        self::assertEquals(new StyleSequenceFrame('%s.. ', 3), $palette->getFrame());
        self::assertEquals(new StyleSequenceFrame('%s...', 3), $palette->getFrame());
        self::assertEquals(new StyleSequenceFrame('%s ..', 3), $palette->getFrame());
        self::assertEquals(new StyleSequenceFrame('%s  .', 3), $palette->getFrame());
        self::assertEquals(new StyleSequenceFrame('%s   ', 3), $palette->getFrame());
        self::assertEquals(new StyleSequenceFrame('%s   ', 3), $palette->getFrame());
    }
}