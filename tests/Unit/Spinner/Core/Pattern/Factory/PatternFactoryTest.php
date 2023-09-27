<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\PatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Template;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class PatternFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $pattern = $this->getTesteeInstance();

        self::assertInstanceOf(PatternFactory::class, $pattern);
    }

    public function getTesteeInstance(
        ?IIntervalFactory $intervalFactory = null,
        ?IPaletteModeFactory $paletteModeFactory = null,
    ): IPatternFactory {
        return
            new PatternFactory(
                intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock(),
                paletteModeFactory: $paletteModeFactory ?? $this->getPaletteModeFactoryMock(),
            );
    }

    private function getIntervalFactoryMock(): MockObject&IIntervalFactory
    {
        return $this->createMock(IIntervalFactory::class);
    }

    private function getPaletteModeFactoryMock(): MockObject&IPaletteModeFactory
    {
        return $this->createMock(IPaletteModeFactory::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $intervalFactory = $this->getIntervalFactoryMock();
        $paletteInterval = 100;
        $factoryInterval = $this->getIntervalMock();
        $intervalFactory
            ->expects(self::once())
            ->method('createNormalized')
            ->with(self::identicalTo($paletteInterval))
            ->willReturn($factoryInterval)
        ;

        $options = $this->getPaletteOptionsMock();
        $options
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($paletteInterval)
        ;

        $entries = $this->getTraversableMock();
        $paletteMode = $this->getPaletteModeMock();
        $paletteModeFactory = $this->getPaletteModeFactoryMock();
        $paletteModeFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($paletteMode)
        ;

        $factory = $this->getTesteeInstance(
            intervalFactory: $intervalFactory,
            paletteModeFactory: $paletteModeFactory,
        );

        $palette = $this->getPaletteMock();
        $palette
            ->expects(self::once())
            ->method('getEntries')
            ->with($paletteMode)
            ->willReturn($entries)
        ;
        $palette
            ->expects(self::once())
            ->method('getOptions')
            ->willReturn($options)
        ;

        $template = $factory->create($palette);

        self::assertInstanceOf(Template::class, $template);

        self::assertSame($entries, $template->getFrames());
        self::assertSame($factoryInterval, $template->getInterval());
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }

    private function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }
}
