<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteTemplateFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\PatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Pattern;
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
        ?IPaletteTemplateFactory $paletteTemplateFactory = null,
    ): IPatternFactory {
        return
            new PatternFactory(
                intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock(),
                paletteTemplateFactory: $paletteTemplateFactory ?? $this->getPaletteTemplateFactoryMock(),
            );
    }

    private function getIntervalFactoryMock(): MockObject&IIntervalFactory
    {
        return $this->createMock(IIntervalFactory::class);
    }

    private function getPaletteTemplateFactoryMock(): MockObject&IPaletteTemplateFactory
    {
        return $this->createMock(IPaletteTemplateFactory::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $paletteInterval = 100;
        $factoryInterval = $this->getIntervalMock();

        $intervalFactory = $this->getIntervalFactoryMock();
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

        $template = $this->getTemplateMock();
        $template
            ->expects(self::once())
            ->method('getEntries')
            ->willReturn($entries)
        ;

        $palette = $this->getPaletteMock();

        $paletteTemplateFactory = $this->getPaletteTemplateFactoryMock();
        $paletteTemplateFactory
            ->expects(self::once())
            ->method('create')
            ->with($palette)
            ->willReturn($template)
        ;

        $template
            ->expects(self::once())
            ->method('getOptions')
            ->willReturn($options)
        ;

        $patternFactory = $this->getTesteeInstance(
            intervalFactory: $intervalFactory,
            paletteTemplateFactory: $paletteTemplateFactory,
        );

        $pattern = $patternFactory->create($palette);

        self::assertInstanceOf(Pattern::class, $pattern);

        self::assertSame($entries, $pattern->getFrames());
        self::assertSame($factoryInterval, $pattern->getInterval());
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    private function getTemplateMock(): MockObject&IPaletteTemplate
    {
        return $this->createMock(IPaletteTemplate::class);
    }

    private function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }

    private function getPaletteModeFactoryMock(): MockObject&IPaletteModeFactory
    {
        return $this->createMock(IPaletteModeFactory::class);
    }
}
