<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Widget\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\ICharPattern;
use AlecRabbit\Spinner\Contract\Pattern\IStylePattern;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\ICharPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IStylePatternFactory;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\WidgetRevolverFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetRevolverFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetRevolverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetRevolverFactory::class, $widgetRevolverFactory);
    }

    public function getTesteeInstance(
        ?IWidgetRevolverBuilder $builder = null,
        ?IStylePatternFactory $styleFactory = null,
        ?ICharPatternFactory $charFactory = null,
        ?IIntervalComparator $intervalComparator = null,
    ): IWidgetRevolverFactory {
        return new WidgetRevolverFactory(
            builder: $builder ?? $this->getWidgetRevolverBuilderMock(),
            styleFactory: $styleFactory ?? $this->getStylePatternFactoryMock(),
            charFactory: $charFactory ?? $this->getCharPatternFactoryMock(),
            intervalComparator: $intervalComparator ?? $this->getIntervalComparatorMock(),
        );
    }

    private function getWidgetRevolverBuilderMock(): MockObject&IWidgetRevolverBuilder
    {
        return $this->createMock(IWidgetRevolverBuilder::class);
    }

    private function getStylePatternFactoryMock(): MockObject&IStylePatternFactory
    {
        return $this->createMock(IStylePatternFactory::class);
    }

    private function getCharPatternFactoryMock(): MockObject&ICharPatternFactory
    {
        return $this->createMock(ICharPatternFactory::class);
    }

    private function getIntervalComparatorMock(): MockObject&IIntervalComparator
    {
        return $this->createMock(IIntervalComparator::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $styleInterval = $this->getIntervalMock();
        $charInterval = $this->getIntervalMock();
        $charPalette = $this->getCharPaletteMock();
        $stylePalette = $this->getStylePaletteMock();
        $config = $this->getWidgetRevolverConfigMock();
        $config
            ->expects(self::once())
            ->method('getStylePalette')
            ->willReturn($stylePalette)
        ;
        $config
            ->expects(self::once())
            ->method('getCharPalette')
            ->willReturn($charPalette)
        ;
        $stylePattern = $this->getStylePatternMock();
        $stylePattern
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($styleInterval)
        ;

        $stylePatternFactory = $this->getStylePatternFactoryMock();
        $stylePatternFactory
            ->expects(self::once())
            ->method('create')
            ->with($stylePalette)
            ->willReturn($stylePattern)
        ;

        $charPattern = $this->getCharPatternMock();
        $charPattern
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($charInterval)
        ;

        $charPatternFactory = $this->getCharPatternFactoryMock();
        $charPatternFactory
            ->expects(self::once())
            ->method('create')
            ->with($charPalette)
            ->willReturn($charPattern)
        ;

        $widgetRevolver = $this->getWidgetRevolverMock();

        $charIntervalComparator = $this->getIntervalComparatorMock();
        $charIntervalComparator
            ->expects(self::once())
            ->method('smallest')
            ->with($styleInterval, $charInterval)
            ->willReturn($charInterval)
        ;

        $builder = $this->getWidgetRevolverBuilderMock();
        $builder
            ->expects(self::once())
            ->method('withStyle')
            ->with($stylePattern)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withChar')
            ->with($charPattern)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withInterval')
            ->with($charInterval)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('build')
            ->willReturn($widgetRevolver)
        ;


        $widgetRevolverFactory = $this->getTesteeInstance(
            builder: $builder,
            styleFactory: $stylePatternFactory,
            charFactory: $charPatternFactory,
            intervalComparator: $charIntervalComparator,
        );

        $actual = $widgetRevolverFactory->create($config);

        self::assertSame($widgetRevolver, $actual);
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getCharPaletteMock(): MockObject&ICharPalette
    {
        return $this->createMock(ICharPalette::class);
    }

    private function getStylePaletteMock(): MockObject&IStylePalette
    {
        return $this->createMock(IStylePalette::class);
    }

    private function getWidgetRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }

    private function getStylePatternMock(): MockObject&IStylePattern
    {
        return $this->createMock(IStylePattern::class);
    }

    private function getCharPatternMock(): MockObject&ICharPattern
    {
        return $this->createMock(ICharPattern::class);
    }

    private function getWidgetRevolverMock(): MockObject&IWidgetRevolver
    {
        return $this->createMock(IWidgetRevolver::class);
    }

}
