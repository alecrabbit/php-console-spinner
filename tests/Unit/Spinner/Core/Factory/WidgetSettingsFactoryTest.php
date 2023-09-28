<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacyWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Factory\Legacy\ILegacyWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Legacy\LegacyWidgetSettingsFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetSettingsFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetSettingsFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyWidgetSettingsFactory::class, $widgetSettingsFactory);
    }

    public function getTesteeInstance(
        ?ILegacySettingsProvider $settingsProvider = null,
        ?ILegacyWidgetSettingsBuilder $widgetSettingsBuilder = null,
    ): ILegacyWidgetSettingsFactory {
        return
            new LegacyWidgetSettingsFactory(
                settingsProvider: $settingsProvider ?? $this->getLegacySettingsProviderMock(),
                widgetSettingsBuilder: $widgetSettingsBuilder ?? $this->getLegacyWidgetSettingsBuilderMock()
            );
    }

    #[Test]
    public function canCreateFromFullyFilledConfig(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $stylePattern = $this->getStylePatternMock();
        $charPattern = $this->getCharPatternMock();

        $widgetSettings = $this->getLegacyWidgetSettingsMock();

        $builder = $this->getLegacyWidgetSettingsBuilderMock();
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

        self::assertInstanceOf(LegacyWidgetSettingsFactory::class, $widgetSettingsFactory);

        $config = $this->getLegacyWidgetConfigMock();
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
        $charPattern = $this->getCharPatternMock();

        $widgetSettings = $this->getLegacyWidgetSettingsMock();

        $builder = $this->getLegacyWidgetSettingsBuilderMock();
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

        $widgetConfig = $this->getLegacyWidgetConfigMock();

        $settingsProvider = $this->getLegacySettingsProviderMock();
        $settingsProvider
            ->expects(self::once())
            ->method('getLegacyWidgetConfig')
            ->willReturn($widgetConfig)
        ;
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
            ->method('getStylePattern')
            ->willReturn($stylePattern)
        ;
        $widgetConfig
            ->expects(self::once())
            ->method('getCharPattern')
            ->willReturn($charPattern)
        ;

        $settingsProvider
            ->expects(self::never())
            ->method('getLegacyRootWidgetConfig')
        ;

        $widgetSettingsFactory = $this->getTesteeInstance(
            settingsProvider: $settingsProvider,
            widgetSettingsBuilder: $builder,
        );

        self::assertInstanceOf(LegacyWidgetSettingsFactory::class, $widgetSettingsFactory);

        $config = $this->getLegacyWidgetConfigMock();
        $config
            ->expects(self::once())
            ->method('merge')
            ->willReturn($widgetConfig)
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
