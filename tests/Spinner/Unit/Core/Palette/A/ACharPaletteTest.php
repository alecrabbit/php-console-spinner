<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette\A;

use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Tests\Spinner\Unit\Core\Palette\A\Override\ACharPaletteOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use Generator;
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
    public function canGetOptions(): void
    {
        $options = $this->getPaletteOptionsMock();

        $palette = $this->getTesteeInstance(
            options: $options,
        );

        $mode = $this->getPaletteModeMock();

        self::assertInstanceOf(PaletteOptions::class, $palette->getOptions($mode));
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }

    #[Test]
    public function canGetEntries(): void
    {
        $palette = $this->getTesteeInstance();
        $mode = $this->getPaletteModeMock();

        self::assertInstanceOf(Generator::class, $palette->getEntries($mode));
    }

    #[Test]
    public function canGetTemplateThree(): void
    {
        $charFrame = new CharSequenceFrame('22', 2);

        $entries = new ArrayObject(['a', $charFrame, 'b']);

        $options = $this->getPaletteOptionsMock();

        $palette = $this->getTesteeInstance(
            options: $options,
            entries: $entries,
        );

        $mode = $this->getPaletteModeMock();

        $traversable = $palette->getEntries($mode);

        self::assertInstanceOf(Generator::class, $traversable);

        self::assertSame(200, $palette->getOptions()->getInterval());

        $templateEntries = iterator_to_array($traversable);

        self::assertEquals(new CharSequenceFrame('a', 1), $templateEntries[0]);
        self::assertEquals(new CharSequenceFrame('b', 1), $templateEntries[2]);
        self::assertSame($charFrame, $templateEntries[1]);
    }
}
