<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SpinnerFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $spinnerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SpinnerFactory::class, $spinnerFactory);
    }

    public function getTesteeInstance(
        ?IDefaultsProvider $defaultsProvider = null,
        ?IWidgetFactory $widgetFactory = null,
        ?IWidgetSettingsBuilder $widgetSettingsBuilder = null,
    ): ISpinnerFactory {
        return
            new SpinnerFactory(
                defaultsProvider: $defaultsProvider ?? $this->getDefaultsProviderMock(),
                widgetFactory: $widgetFactory ?? $this->getWidgetFactoryMock(),
                widgetSettingsBuilder: $widgetSettingsBuilder ?? $this->getWidgetSettingsBuilderMock(),
            );
    }

    #[Test]
    public function canCreateSpinnerWithConfig(): void
    {
        $rootWidgetSettings = $this->getWidgetSettingsMock();
        $rootWidgetSettings
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn($this->getFrameMock())
        ;
        $rootWidgetSettings
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn($this->getFrameMock())
        ;
        $rootWidgetSettings
            ->expects(self::once())
            ->method('getStylePattern')
            ->willReturn($this->getStylePatternMock())
        ;
        $rootWidgetSettings
            ->expects(self::once())
            ->method('getCharPattern')
            ->willReturn($this->getPatternMock())
        ;

        $defaultsProvider = $this->getDefaultsProviderMock();
        $defaultsProvider
            ->expects(self::once())
            ->method('getRootWidgetSettings')
            ->willReturn($rootWidgetSettings)
        ;
        $widgetSettings = $this->getWidgetSettingsMock();

        $widgetSettingsBuilder = $this->getWidgetSettingsBuilderMock();
        $widgetSettingsBuilder
            ->expects(self::once())
            ->method('withLeadingSpacer')
            ->willReturn($widgetSettingsBuilder)
        ;
        $widgetSettingsBuilder
            ->expects(self::once())
            ->method('withTrailingSpacer')
            ->willReturn($widgetSettingsBuilder)
        ;
        $widgetSettingsBuilder
            ->expects(self::once())
            ->method('withStylePattern')
            ->willReturn($widgetSettingsBuilder)
        ;
        $widgetSettingsBuilder
            ->expects(self::once())
            ->method('withCharPattern')
            ->willReturn($widgetSettingsBuilder)
        ;
        $widgetSettingsBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($widgetSettings)
        ;
        $widgetConfig = $this->getWidgetConfigMock();
        $widgetConfig
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn(null)
        ;
        $widgetConfig
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn(null)
        ;
        $widgetConfig
            ->expects(self::once())
            ->method('getStylePattern')
            ->willReturn(null)
        ;
        $widgetConfig
            ->expects(self::once())
            ->method('getCharPattern')
            ->willReturn(null)
        ;


        $config = $this->getSpinnerConfigMock();
        $config
            ->expects(self::once())
            ->method('getWidgetConfig')
            ->willReturn($widgetConfig)
        ;
        $widget = $this->getWidgetCompositeMock();


        $widgetFactory = $this->getWidgetFactoryMock();
        $widgetFactory
            ->expects(self::once())
            ->method('createWidget')
            ->with($widgetSettings)
            ->willReturn($widget)
        ;
        $spinnerFactory = $this->getTesteeInstance(
            defaultsProvider: $defaultsProvider,
            widgetFactory: $widgetFactory,
            widgetSettingsBuilder: $widgetSettingsBuilder,
        );

        $spinner = $spinnerFactory->createSpinner($config);
        self::assertInstanceOf(SpinnerFactory::class, $spinnerFactory);
        self::assertInstanceOf(Spinner::class, $spinner);
        self::assertSame($widget, self::getPropertyValue('rootWidget', $spinner));
    }
}
