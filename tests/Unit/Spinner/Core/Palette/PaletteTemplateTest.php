<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\ITemplate;
use AlecRabbit\Spinner\Core\Palette\PaletteTemplate;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

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
        ?Traversable $entries = null,
        ?IPaletteOptions $options = null,
    ): ITemplate {
        return
            new PaletteTemplate(
                entries: $entries ?? $this->getTraversableMock(),
                options: $options ?? $this->getPaletteOptionsMock(),
            );
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    #[Test]
    public function canGetEntries(): void
    {
        $entries = new ArrayObject();

        $template = $this->getTesteeInstance(
            entries: $entries,
        );

        self::assertSame($entries, $template->getEntries());
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = 111;
        $options = $this->getPaletteOptionsMock();
        $options
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $template = $this->getTesteeInstance(
            options: $options,
        );

        self::assertSame($interval, $template->getOptions()->getInterval());
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
