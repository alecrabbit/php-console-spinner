<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette\A;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteTemplate;
use AlecRabbit\Tests\Spinner\Unit\Core\Palette\A\Override\ACharPaletteOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class ACharPaletteTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(ACharPaletteOverride::class, $palette);
    }

    private function getTesteeInstance(
        ?IPaletteOptions $options = null,
        ?Traversable $entries = null,
    ): ICharPalette {
        return
            new ACharPaletteOverride(
                options: $options ?? $this->getPaletteOptionsMock(),
                entries: $entries ?? $this->getTraversableMock(),
            );
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    #[Test]
    public function canGetTemplate(): void
    {
        $entries = $this->getTraversableMock();
        $options = $this->getPaletteOptionsMock();
        $interval = 150;
        $options
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $palette = $this->getTesteeInstance(
            options: $options,
            entries: $entries,
        );

        $template = $palette->getTemplate();

        self::assertInstanceOf(PaletteTemplate::class, $template);

        self::assertSame($interval, $template->getOptions()->getInterval());
    }

    #[Test]
    public function canGetTemplateTwo(): void
    {
        $entries = $this->getTraversableMock();
        $options = $this->getPaletteOptionsMock();

        $palette = $this->getTesteeInstance(
            options: $options,
            entries: $entries,
        );

        $template = $palette->getTemplate();

        self::assertInstanceOf(PaletteTemplate::class, $template);

        self::assertSame(100, $template->getOptions()->getInterval());
    }

    #[Test]
    public function canGetTemplateThree(): void
    {
        $charFrame = new CharFrame('22', 2);

        $entries = new ArrayObject(['a', $charFrame, 'b']);

        $options = $this->getPaletteOptionsMock();

        $palette = $this->getTesteeInstance(
            options: $options,
            entries: $entries,
        );

        $template = $palette->getTemplate();

        self::assertInstanceOf(PaletteTemplate::class, $template);

        self::assertSame(100, $template->getOptions()->getInterval());

        $templateEntries = iterator_to_array($template->getEntries());

        self::assertEquals(new CharFrame('a', 1), $templateEntries[0]);
        self::assertEquals(new CharFrame('b', 1), $templateEntries[2]);
        self::assertSame($charFrame, $templateEntries[1]);
    }
}
