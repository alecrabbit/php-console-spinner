<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetCompositeFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\WidgetCompositeFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetCompositeFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetCompositeFactory::class, $widgetFactory);
    }

    public function getTesteeInstance(
        ?IWidgetConfigFactory $widgetConfigFactory = null,
        ?IWidgetCompositeBuilder $widgetBuilder = null,
        ?IWidgetRevolverFactory $widgetRevolverFactory = null,
    ): IWidgetCompositeFactory {
        return new WidgetCompositeFactory(
            widgetConfigFactory: $widgetConfigFactory ?? $this->getWidgetConfigFactoryMock(),
            widgetBuilder: $widgetBuilder ?? $this->getWidgetCompositeBuilderMock(),
            widgetRevolverFactory: $widgetRevolverFactory ?? $this->getWidgetRevolverFactoryMock(),
        );
    }

    protected function getWidgetConfigFactoryMock(): MockObject&IWidgetConfigFactory
    {
        return $this->createMock(IWidgetConfigFactory::class);
    }

    protected function getWidgetCompositeBuilderMock(): MockObject&IWidgetCompositeBuilder
    {
        return $this->createMock(IWidgetCompositeBuilder::class);
    }

    protected function getWidgetRevolverFactoryMock(): MockObject&IWidgetRevolverFactory
    {
        return $this->createMock(IWidgetRevolverFactory::class);
    }

    #[Test]
    public function canLegacyCreateWidget(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $widgetComposite = $this->getWidgetCompositeMock();

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
            ->method('legacyCreateWidgetRevolver')
            ->with(self::identicalTo($widgetSettings))
            ->willReturn($widgetRevolver)
        ;


        $widgetBuilder = $this->getWidgetCompositeBuilderMock();
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
            ->willReturn($widgetComposite)
        ;


        $widgetFactory = $this->getTesteeInstance(
            widgetBuilder: $widgetBuilder,
            widgetRevolverFactory: $widgetRevolverFactory,
        );

        self::assertInstanceOf(WidgetCompositeFactory::class, $widgetFactory);
        self::assertSame($widgetComposite, $widgetFactory->legacyCreateWidget($widgetSettings));
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getWidgetCompositeMock(): MockObject&IWidgetComposite
    {
        return $this->createMock(IWidgetComposite::class);
    }

    protected function getLegacyWidgetSettingsMock(): MockObject&ILegacyWidgetSettings
    {
        return $this->createMock(ILegacyWidgetSettings::class);
    }

    protected function getWidgetRevolverMock(): MockObject&IWidgetRevolver
    {
        return $this->createMock(IWidgetRevolver::class);
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
            ->method('getWidgetRevolverConfig')
            ->willReturn($revolverConfig)
        ;

        $widgetConfigFactory = $this->getWidgetConfigFactoryMock();
        $widgetConfigFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::identicalTo(null))
            ->willReturn($widgetConfig)
        ;

        $widget = $this->getWidgetCompositeMock();

        $widgetRevolver = $this->getWidgetRevolverMock();

        $widgetRevolverFactory = $this->getWidgetRevolverFactoryMock();
        $widgetRevolverFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::identicalTo($revolverConfig))
            ->willReturn($widgetRevolver)
        ;

        $widgetBuilder = $this->getWidgetCompositeBuilderMock();
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
            widgetConfigFactory: $widgetConfigFactory,
            widgetBuilder: $widgetBuilder,
            widgetRevolverFactory: $widgetRevolverFactory,
        );

        self::assertInstanceOf(WidgetCompositeFactory::class, $widgetFactory);
        self::assertSame($widget, $widgetFactory->create());
    }

    protected function getRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }

    protected function getWidgetConfigMock(): MockObject&IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }

    protected function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }
}
