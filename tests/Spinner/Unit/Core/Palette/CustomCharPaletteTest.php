<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IFinitePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\CustomCharPalette;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class CustomCharPaletteTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(CustomCharPalette::class, $palette);
    }

    private function getTesteeInstance(
        ?\ArrayObject $frames = null,
        ?IPaletteOptions $options = null,
        ?int $index = null,
    ): ICharPalette {
        return
            new CustomCharPalette(
                frames: $frames ?? $this->getFramesMock(),
                options: $options ?? $this->getPaletteOptionsMock(),
                index: $index ?? 0,
            );
    }

    private function getFramesMock(): MockObject&\ArrayObject
    {
        return $this->createMock(\ArrayObject::class);
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

        $frame = new CharSequenceFrame('', 0);

        $actual = $palette->getFrame();

        self::assertEquals($frame, $actual);
        self::assertSame($actual, $palette->getFrame());
        self::assertSame($actual, $palette->getFrame());
        self::assertSame($actual, $palette->getFrame());
    }

    #[Test]
    public function canBeCreatedWithCustomFrames(): void
    {
        $frames = new \ArrayObject(
            [
                new CharSequenceFrame('   ', 3),
                new CharSequenceFrame('.  ', 3),
                new CharSequenceFrame('.. ', 3),
                new CharSequenceFrame('...', 3),
                new \stdClass(),
                new CharSequenceFrame(' ..', 3),
                new CharSequenceFrame('  .', 3),
                new CharSequenceFrame('   ', 3),
            ]
        );
        $palette = $this->getTesteeInstance(
            frames: $frames,
        );

        self::assertEquals(new CharSequenceFrame('.  ', 3), $palette->getFrame());
        self::assertEquals(new CharSequenceFrame('.. ', 3), $palette->getFrame());
        self::assertEquals(new CharSequenceFrame('...', 3), $palette->getFrame());
        self::assertEquals(new CharSequenceFrame(' ..', 3), $palette->getFrame());
        self::assertEquals(new CharSequenceFrame('  .', 3), $palette->getFrame());
        self::assertEquals(new CharSequenceFrame('   ', 3), $palette->getFrame());
        self::assertEquals(new CharSequenceFrame('   ', 3), $palette->getFrame());
    }
}
