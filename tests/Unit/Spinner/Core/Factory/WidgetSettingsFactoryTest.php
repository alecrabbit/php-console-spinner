<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\WidgetSettingsFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetSettingsFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $widgetSettingsFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetSettingsFactory::class, $widgetSettingsFactory);
    }

    public function getTesteeInstance(
        ?IDefaultsProvider $defaultsProvider = null,
        ?IWidgetSettingsBuilder $widgetSettingsBuilder = null,
    ): IWidgetSettingsFactory {
        return
            new WidgetSettingsFactory(
                defaultsProvider: $defaultsProvider ?? $this->getDefaultsProviderMock(),
                widgetSettingsBuilder: $widgetSettingsBuilder ?? $this->getWidgetSettingsBuilderMock()
            );
    }

    #[Test]
    public function canCreateFromFullyFilledConfig(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $stylePattern = $this->getStylePatternMock();
        $charPattern = $this->getPatternMock();

        $widgetSettings = $this->getWidgetSettingsMock();

        $builder = $this->getWidgetSettingsBuilderMock();
        $builder
            ->expects(self::once())
            ->method('withLeadingSpacer')
            ->with($leadingSpacer)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withTrailingSpacer')
            ->with($trailingSpacer)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withStylePattern')
            ->with($stylePattern)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withCharPattern')
            ->with($charPattern)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('build')
            ->willReturn($widgetSettings)
        ;

        $widgetSettingsFactory = $this->getTesteeInstance(
            widgetSettingsBuilder: $builder,
        );

        self::assertInstanceOf(WidgetSettingsFactory::class, $widgetSettingsFactory);

        $config = $this->getWidgetConfigMock();
        $config
            ->expects(self::once())
            ->method('merge')
            ->willReturnSelf()
        ;

        $config
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn($leadingSpacer)
        ;
        $config
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn($trailingSpacer)
        ;
        $config
            ->expects(self::once())
            ->method('getStylePattern')
            ->willReturn($stylePattern)
        ;
        $config
            ->expects(self::once())
            ->method('getCharPattern')->willReturn($charPattern)
        ;

        self::assertSame($widgetSettings, $widgetSettingsFactory->createFromConfig($config));
    }

    #[Test]
    public function canCreateFromEmptyConfig(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $stylePattern = $this->getStylePatternMock();
        $charPattern = $this->getPatternMock();

        $widgetSettings = $this->getWidgetSettingsMock();

        $builder = $this->getWidgetSettingsBuilderMock();
        $builder
            ->expects(self::once())
            ->method('withLeadingSpacer')
            ->with(self::identicalTo($leadingSpacer))
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withTrailingSpacer')
            ->with(self::identicalTo($trailingSpacer))
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withStylePattern')
            ->with(self::identicalTo($stylePattern))
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withCharPattern')
            ->with(self::identicalTo($charPattern))
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('build')
            ->willReturn($widgetSettings)
        ;

        $defaultsProvider = $this->getDefaultsProviderMock();
        $defaultsProvider
            ->expects(self::once())
            ->method('getWidgetConfig')
        ;
        $rootWidgetConfig = $this->getWidgetConfigMock();
        $rootWidgetConfig
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn($leadingSpacer)
        ;
        $rootWidgetConfig
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn($trailingSpacer)
        ;
        $rootWidgetConfig
            ->expects(self::once())
            ->method('getStylePattern')
            ->willReturn($stylePattern)
        ;
        $rootWidgetConfig
            ->expects(self::once())
            ->method('getCharPattern')
            ->willReturn($charPattern)
        ;

        $defaultsProvider
            ->expects(self::once())
            ->method('getRootWidgetConfig')
            ->willReturn($rootWidgetConfig)
        ;

        $widgetSettingsFactory = $this->getTesteeInstance(
            defaultsProvider: $defaultsProvider,
            widgetSettingsBuilder: $builder,
        );

        self::assertInstanceOf(WidgetSettingsFactory::class, $widgetSettingsFactory);

        $config = $this->getWidgetConfigMock();
        $config
            ->expects(self::once())
            ->method('merge')
            ->willReturn($rootWidgetConfig)
        ;
        $config
            ->expects(self::never())
            ->method('getLeadingSpacer')
        ;
        $config
            ->expects(self::never())
            ->method('getTrailingSpacer')
            ->willReturn(null)
        ;
        $config
            ->expects(self::never())
            ->method('getStylePattern')
        ;
        $config
            ->expects(self::never())
            ->method('getCharPattern')
        ;

        self::assertSame($widgetSettings, $widgetSettingsFactory->createFromConfig($config));
    }
}
