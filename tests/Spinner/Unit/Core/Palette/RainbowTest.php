<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette;

use AlecRabbit\Spinner\Contract\Mode\StylingMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class RainbowTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(Rainbow::class, $palette);
    }

    private function getTesteeInstance(
        ?IPaletteOptions $options = null,
    ): IStylePalette {
        return
            new Rainbow(
                options: $options ?? $this->getPaletteOptionsMock(),
            );
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    #[Test]
    public function canGetEntries(): void
    {
        $palette = $this->getTesteeInstance();
        $mode = $this->getPaletteModeMock();

        self::assertInstanceOf(Traversable::class, $palette->getEntries($mode));
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
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
            ->willReturn(StylingMode::NONE)
        ;
        self::assertInstanceOf(PaletteOptions::class, $palette->getOptions($mode));
    }
}
