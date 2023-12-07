<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
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
    public function canGetEntries(): void
    {
        $palette = $this->getTesteeInstance();
        $mode = $this->getPaletteModeMock();

        self::assertInstanceOf(Generator::class, $palette->getEntries($mode));
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
            ->expects(self::never())
            ->method('getStylingMode')
        ;
        self::assertInstanceOf(PaletteOptions::class, $palette->getOptions($mode));
    }

}
