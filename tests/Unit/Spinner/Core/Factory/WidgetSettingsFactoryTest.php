<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\ILegacyPattern;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
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
        ?IWidgetSettingsBuilder $widgetSettingsBuilder = null,
    ): IWidgetSettingsFactory {
        return
            new WidgetSettingsFactory(
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

        $config->method('getLeadingSpacer')->willReturn($leadingSpacer);
        $config->method('getTrailingSpacer')->willReturn($trailingSpacer);
        $config->method('getStylePattern')->willReturn($stylePattern);
        $config->method('getCharPattern')->willReturn($charPattern);

        self::assertSame($widgetSettings, $widgetSettingsFactory->createFromConfig($config));
    }#[Test]
    public function canCreateFromEmptyConfig(): void
    {
        $widgetSettings = $this->getWidgetSettingsMock();

        $builder = $this->getWidgetSettingsBuilderMock();
        $builder
            ->expects(self::once())
            ->method('withLeadingSpacer')
            ->with(self::IsInstanceOf(IFrame::class))
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withTrailingSpacer')
            ->with(self::IsInstanceOf(IFrame::class))
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withStylePattern')
            ->with(self::IsInstanceOf(ILegacyPattern::class))
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withCharPattern')
            ->with(self::IsInstanceOf(ILegacyPattern::class))
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

        $config->method('getLeadingSpacer')->willReturn(null);
        $config->method('getTrailingSpacer')->willReturn(null);
        $config->method('getStylePattern')->willReturn(null);
        $config->method('getCharPattern')->willReturn(null);

        self::assertSame($widgetSettings, $widgetSettingsFactory->createFromConfig($config));
    }

}
