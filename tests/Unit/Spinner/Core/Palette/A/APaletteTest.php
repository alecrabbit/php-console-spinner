<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Palette\A;

use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\NoCharPalette;
use AlecRabbit\Spinner\Core\Palette\PaletteTemplate;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Core\Palette\A\Override\APaletteOverride;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class APaletteTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(APaletteOverride::class, $palette);
    }

    private function getTesteeInstance(
        ?IPaletteOptions $options = null,
        ?\Traversable $entries = null,
    ): IPalette
    {
        return
            new APaletteOverride(
                options: $options ?? $this->getPaletteOptionsMock(),
                entries: $entries ?? $this->getTraversableMock(),
            );
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    private function getTraversableMock(): MockObject&\Traversable
    {
        return $this->createMock(\Traversable::class);
    }
    #[Test]
    public function canGetTemplate(): void
    {
        $entries = $this->getTraversableMock();
        $options = $this->getPaletteOptionsMock();
        $interval = 100;
        $options
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval);

        $palette = $this->getTesteeInstance(
            options: $options,
            entries: $entries,
        );

        $template = $palette->getTemplate();

        self::assertInstanceOf(PaletteTemplate::class, $template);

        self::assertSame($entries, $template->getEntries());
        self::assertSame($interval, $template->getInterval());
    }
}
