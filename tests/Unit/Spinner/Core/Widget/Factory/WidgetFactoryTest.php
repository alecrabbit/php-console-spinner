<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\WidgetFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetFactory::class, $widgetFactory);
    }

    public function getTesteeInstance(
        ?IWidgetBuilder $widgetBuilder = null,
        ?IWidgetRevolverFactory $widgetRevolverFactory = null,
        ?IWidgetConfigFactory $widgetConfigFactory = null,
    ): IWidgetFactory {
        return
            new WidgetFactory(
                widgetConfigFactory: $widgetConfigFactory ?? $this->getWidgetConfigFactoryMock(),
                widgetRevolverFactory: $widgetRevolverFactory ?? $this->getWidgetRevolverFactoryMock(),
                widgetBuilder: $widgetBuilder ?? $this->getWidgetCompositeBuilderMock(),
            );
    }

    protected function getWidgetConfigFactoryMock(): MockObject&IWidgetConfigFactory
    {
        return $this->createMock(IWidgetConfigFactory::class);
    }

//    #[Test]
//    public function canCreateWidgetWithWidgetSettings(): void
//    {
//        $widgetFactory = $this->getTesteeInstance(
//        );
//        self::assertInstanceOf(WidgetFactory::class, $widgetFactory);
//        self::assertSame($widget, $widgetFactory->createWidget($widgetSettings));
//    }

    #[Test]
    public function canLegacyCreateWidget(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $widget = $this->getWidgetMock();

        $widgetSettings = $this->getLegacyWidgetSettingsMock();
        $widgetSettings
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn($leadingSpacer)
        ;
        $widgetSettings
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn($trailingSpacer)
        ;
        $widgetRevolver = $this->getWidgetRevolverMock();
        $widgetRevolverFactory = $this->getWidgetRevolverFactoryMock();
        $widgetRevolverFactory
            ->expects(self::once())
            ->method('createWidgetRevolver')
            ->with(self::identicalTo($widgetSettings))
            ->willReturn($widgetRevolver)
        ;


        $widgetBuilder = $this->getWidgetBuilderMock();
        $widgetBuilder
            ->expects(self::once())
            ->method('withLeadingSpacer')
            ->with(self::identicalTo($leadingSpacer))
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::once())
            ->method('withTrailingSpacer')
            ->with(self::identicalTo($trailingSpacer))
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::once())
            ->method('withWidgetRevolver')
            ->with(self::identicalTo($widgetRevolver))
            ->willReturnSelf()
        ;


        $widgetBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($widget)
        ;


        $widgetFactory = $this->getTesteeInstance(
            widgetBuilder: $widgetBuilder,
            widgetRevolverFactory: $widgetRevolverFactory,
        );

        self::assertInstanceOf(WidgetFactory::class, $widgetFactory);
        self::assertSame($widget, $widgetFactory->legacyCreateWidget($widgetSettings));
    }

    #[Test]
    public function canCreateWidgetWithoutWidgetSettings(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $revolverConfig = $this->getRevolverConfigMock();
        $widgetConfig = $this->getWidgetConfigMock();
        $widgetConfig
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn($leadingSpacer)
        ;
        $widgetConfig
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn($trailingSpacer)
        ;
        $widgetConfig
            ->expects(self::once())
            ->method('getRevolverConfig')
            ->willReturn($revolverConfig)
        ;

        $widgetConfigFactory = $this->getWidgetConfigFactoryMock();
        $widgetConfigFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::identicalTo(null))
            ->willReturn($widgetConfig)
        ;

        $widget = $this->getWidgetMock();

        $widgetRevolver = $this->getWidgetRevolverMock();

        $widgetRevolverFactory = $this->getWidgetRevolverFactoryMock();
        $widgetRevolverFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::identicalTo($revolverConfig))
            ->willReturn($widgetRevolver)
        ;

        $widgetBuilder = $this->getWidgetBuilderMock();
        $widgetBuilder
            ->expects(self::once())
            ->method('withLeadingSpacer')
            ->with(self::identicalTo($leadingSpacer))
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::once())
            ->method('withTrailingSpacer')
            ->with(self::identicalTo($trailingSpacer))
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::once())
            ->method('withWidgetRevolver')
            ->with(self::identicalTo($widgetRevolver))
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($widget)
        ;

        $widgetFactory = $this->getTesteeInstance(
            widgetBuilder: $widgetBuilder,
            widgetRevolverFactory: $widgetRevolverFactory,
            widgetConfigFactory: $widgetConfigFactory,
        );

        self::assertInstanceOf(WidgetFactory::class, $widgetFactory);
        self::assertSame($widget, $widgetFactory->createWidget());
    }

    protected function getRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }

    protected function getWidgetConfigMock(): MockObject&IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }
}
