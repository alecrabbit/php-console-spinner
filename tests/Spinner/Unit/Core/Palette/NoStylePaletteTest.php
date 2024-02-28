<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette;

use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IFinitePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class NoStylePaletteTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(NoStylePalette::class, $palette);
    }

    private function getTesteeInstance(
        ?IPaletteOptions $options = null,
        ?IStyleSequenceFrame $frame = null,
    ): IFinitePalette {
        return
            new NoStylePalette(
                options: $options ?? $this->getPaletteOptionsMock(),
                frame: $frame ?? $this->getStyleSequenceFrameMock(),
            );
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    private function getStyleSequenceFrameMock(): MockObject&IStyleSequenceFrame
    {
        return $this->createMock(IStyleSequenceFrame::class);
    }

    #[Test]
    public function canFrame(): void
    {
        $frame = $this->getStyleSequenceFrameMock();
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
