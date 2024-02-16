<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Widget\Factory;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
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
        ?IWidgetRevolverBuilder $widgetRevolverBuilder = null,
        ?IStyleFrameRevolverFactory $styleRevolverFactory = null,
        ?ICharFrameRevolverFactory $charRevolverFactory = null,
        ?IPatternFactory $patternFactory = null,
        ?IIntervalComparator $intervalComparator = null,
    ): IWidgetRevolverFactory {
        return new WidgetRevolverFactory(
            widgetRevolverBuilder: $widgetRevolverBuilder ?? $this->getWidgetRevolverBuilderMock(),
            styleRevolverFactory: $styleRevolverFactory ?? $this->getStyleFrameRevolverFactoryMock(),
            charRevolverFactory: $charRevolverFactory ?? $this->getCharFrameRevolverFactoryMock(),
            patternFactory: $patternFactory ?? $this->getPatternFactoryMock(),
            intervalComparator: $intervalComparator ?? $this->getIntervalComparatorMock(),
        );
    }

    protected function getWidgetRevolverBuilderMock(): MockObject&IWidgetRevolverBuilder
    {
        return $this->createMock(IWidgetRevolverBuilder::class);
    }

    protected function getStyleFrameRevolverFactoryMock(): MockObject&IStyleFrameRevolverFactory
    {
        return $this->createMock(IStyleFrameRevolverFactory::class);
    }

    protected function getCharFrameRevolverFactoryMock(): MockObject&ICharFrameRevolverFactory
    {
        return $this->createMock(ICharFrameRevolverFactory::class);
    }

    private function getPatternFactoryMock(): MockObject&IPatternFactory
    {
        return $this->createMock(IPatternFactory::class);
    }

    private function getIntervalComparatorMock(): MockObject&IIntervalComparator
    {
        return $this->createMock(IIntervalComparator::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $intervalComparator = $this->getIntervalComparatorMock();

        $stylePattern = $this->getPatternMock();
        $charPattern = $this->getPatternMock();

        $stylePalette = $this->getStylePaletteMock();
        $charPalette = $this->getCharPaletteMock();

        $styleRevolver = $this->getFrameRevolverMock();
        $charRevolver = $this->getFrameRevolverMock();
        $widgetRevolver = $this->getWidgetRevolverMock();

        $patternFactory = $this->getPatternFactoryMock();
        $patternFactory
            ->expects(self::exactly(2))
            ->method('create')
            ->willReturnOnConsecutiveCalls(
                $stylePattern,
                $charPattern,
            )
        ;

        $styleRevolverFactory = $this->getStyleFrameRevolverFactoryMock();
        $styleRevolverFactory
            ->expects(self::once())
            ->method('legacyCreate')
            ->with($stylePattern)
            ->willReturn($styleRevolver)
        ;

        $charRevolverFactory = $this->getCharFrameRevolverFactoryMock();
        $charRevolverFactory
            ->expects(self::once())
            ->method('legacyCreate')
            ->with($charPattern)
            ->willReturn($charRevolver)
        ;

        $widgetRevolverBuilder = $this->getWidgetRevolverBuilderMock();
        $widgetRevolverBuilder
            ->expects(self::once())
            ->method('withStyleRevolver')
            ->with($styleRevolver)
            ->willReturnSelf()
        ;
        $widgetRevolverBuilder
            ->expects(self::once())
            ->method('withCharRevolver')
            ->with($charRevolver)
            ->willReturnSelf()
        ;
        $widgetRevolverBuilder
            ->expects(self::once())
            ->method('withIntervalComparator')
            ->with($intervalComparator)
            ->willReturnSelf()
        ;

        $widgetRevolverBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($widgetRevolver)
        ;

        $widgetRevolverFactory = $this->getTesteeInstance(
            widgetRevolverBuilder: $widgetRevolverBuilder,
            styleRevolverFactory: $styleRevolverFactory,
            charRevolverFactory: $charRevolverFactory,
            patternFactory: $patternFactory,
            intervalComparator: $intervalComparator,
        );

        self::assertInstanceOf(WidgetRevolverFactory::class, $widgetRevolverFactory);

        $widgetRevolverConfig = $this->getWidgetRevolverConfigMock();

        $widgetRevolverConfig
            ->expects(self::once())
            ->method('getStylePalette')
            ->willReturn($stylePalette)
        ;
        $widgetRevolverConfig
            ->expects(self::once())
            ->method('getCharPalette')
            ->willReturn($charPalette)
        ;

        self::assertEquals($widgetRevolver, $widgetRevolverFactory->create($widgetRevolverConfig));
    }

    private function getPatternMock(): MockObject&IPattern
    {
        return $this->createMock(IPattern::class);
    }

    private function getStylePaletteMock(): MockObject&IStylePalette
    {
        return $this->createMock(IStylePalette::class);
    }

    private function getCharPaletteMock(): MockObject&ICharPalette
    {
        return $this->createMock(ICharPalette::class);
    }

    private function getFrameRevolverMock(): MockObject&IFrameRevolver
    {
        return $this->createMock(IFrameRevolver::class);
    }

    private function getWidgetRevolverMock(): MockObject&IWidgetRevolver
    {
        return $this->createMock(IWidgetRevolver::class);
    }

    private function getWidgetRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }
}
