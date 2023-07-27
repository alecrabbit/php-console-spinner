<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetCompositeFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\WidgetCompositeFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetCompositeFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetCompositeFactory::class, $widgetFactory);
    }

    public function getTesteeInstance(
        ?IWidgetCompositeBuilder $widgetBuilder = null,
        ?IWidgetRevolverFactory $widgetRevolverFactory = null,
    ): IWidgetCompositeFactory {
        return new WidgetCompositeFactory(
            widgetBuilder: $widgetBuilder ?? $this->getWidgetCompositeBuilderMock(),
            widgetRevolverFactory: $widgetRevolverFactory ?? $this->getWidgetRevolverFactoryMock(),
        );
    }

    #[Test]
    public function canCreateWidget(): void
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
            ->method('createWidgetRevolver')
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
        self::assertSame($widgetComposite, $widgetFactory->createWidget($widgetSettings));
    }
}
