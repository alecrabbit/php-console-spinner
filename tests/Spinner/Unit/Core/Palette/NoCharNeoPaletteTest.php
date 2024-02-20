<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IFinitePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\NoCharNeoPalette;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class NoCharNeoPaletteTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(NoCharNeoPalette::class, $palette);
    }

    private function getTesteeInstance(
        ?IPaletteOptions $options = null,
        ?ICharSequenceFrame $frame = null,
    ): IFinitePalette {
        return
            new NoCharNeoPalette(
                options: $options ?? $this->getPaletteOptionsMock(),
                frame: $frame ?? $this->getCharSequenceFrameMock(),
            );
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    private function getCharSequenceFrameMock(): MockObject&ICharSequenceFrame
    {
        return $this->createMock(ICharSequenceFrame::class);
    }

    #[Test]
    public function canFrame(): void
    {
        $frame = $this->getCharSequenceFrameMock();
        $palette = $this->getTesteeInstance(
            frame: $frame,
        );

        self::assertSame($frame, $palette->getFrame());
        self::assertSame($frame, $palette->getFrame());
        self::assertSame($frame, $palette->getFrame());
        self::assertSame($frame, $palette->getFrame());
    }

    #[Test]
    public function canGetOptions(): void
    {
        $options = $this->getPaletteOptionsMock();
        $palette = $this->getTesteeInstance(
            options: $options,
        );

        self::assertSame($options, $palette->getOptions());
    }
}
