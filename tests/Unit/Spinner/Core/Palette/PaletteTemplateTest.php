<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\ITemplate;
use AlecRabbit\Spinner\Core\Palette\PaletteTemplate;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class PaletteTemplateTest extends TestCase
{
    private const DEFAULT_INTERVAL = 531;

    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(PaletteTemplate::class, $palette);
    }

    private function getTesteeInstance(
        ?\Traversable $entries = null,
        ?int $interval = null,
        ?IPaletteOptions $options = null,
    ): ITemplate {
        return
            new PaletteTemplate(
                entries: $entries ?? $this->getTraversableMock(),
                interval: $interval ?? self::DEFAULT_INTERVAL,
                options: $options ?? $this->getPaletteOptionsMock(),
            );
    }

    private function getTraversableMock(): MockObject&\Traversable
    {
        return $this->createMock(\Traversable::class);
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    #[Test]
    public function canGetEntries(): void
    {
        $entries = new \ArrayObject();

        $template = $this->getTesteeInstance(
            entries: $entries,
        );

        self::assertSame($entries, $template->getEntries());
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = 111;

        $template = $this->getTesteeInstance(
            interval: $interval,
        );

        self::assertSame($interval, $template->getInterval());
    }
    #[Test]
    public function canGetPaletteOptions(): void
    {
        $options = $this->getPaletteOptionsMock();

        $template = $this->getTesteeInstance(
            options: $options,
        );

        self::assertSame($options, $template->getOptions());
    }
}
