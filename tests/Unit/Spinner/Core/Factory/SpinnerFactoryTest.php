<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidgetSettingsFactory;
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
        ?ISettingsProvider $settingsProvider = null,
        ?IWidgetFactory $widgetFactory = null,
        ?IWidgetSettingsFactory $widgetSettingsFactory = null,
    ): ISpinnerFactory {
        return new SpinnerFactory(
            settingsProvider: $settingsProvider ?? $this->getSettingsProviderMock(),
            widgetFactory: $widgetFactory ?? $this->getWidgetFactoryMock(),
            widgetSettingsFactory: $widgetSettingsFactory ?? $this->getWidgetSettingsFactoryMock(),
        );
    }

    #[Test]
    public function canCreateSpinnerWithoutConfig(): void
    {
        $rootWidgetSettings = $this->getWidgetSettingsMock();
        $rootWidgetSettings
            ->expects(self::never())
            ->method('getLeadingSpacer')
        ;
        $rootWidgetSettings
            ->expects(self::never())
            ->method('getTrailingSpacer')
        ;
        $rootWidgetSettings
            ->expects(self::never())
            ->method('getStylePattern')
        ;
        $rootWidgetSettings
            ->expects(self::never())
            ->method('getCharPattern')
        ;

        $widgetConfig = $this->getWidgetConfigMock();

        $settingsProvider = $this->getSettingsProviderMock();
        $settingsProvider
            ->expects(self::once())
            ->method('getRootWidgetConfig')
            ->willReturn($widgetConfig)
        ;

        $widgetSettingsBuilder = $this->getWidgetSettingsBuilderMock();
        $widgetSettingsBuilder
            ->expects(self::never())
            ->method('withLeadingSpacer')
            ->willReturn($widgetSettingsBuilder)
        ;
        $widgetSettingsBuilder
            ->expects(self::never())
            ->method('withTrailingSpacer')
        ;
        $widgetSettingsBuilder
            ->expects(self::never())
            ->method('withStylePattern')
        ;
        $widgetSettingsBuilder
            ->expects(self::never())
            ->method('withCharPattern')
        ;
        $widgetSettingsBuilder
            ->expects(self::never())
            ->method('build')
        ;

        $widget = $this->getWidgetMock();

        $widgetFactory = $this->getWidgetFactoryMock();
        $widgetFactory
            ->expects(self::once())
            ->method('createWidget')
            ->with($rootWidgetSettings)
            ->willReturn($widget)
        ;
        $widgetSettingsFactory = $this->getWidgetSettingsFactoryMock();
        $widgetSettingsFactory
            ->expects(self::once())
            ->method('createFromConfig')
            ->willReturn($rootWidgetSettings)
        ;
        $spinnerFactory = $this->getTesteeInstance(
            settingsProvider: $settingsProvider,
            widgetFactory: $widgetFactory,
            widgetSettingsFactory: $widgetSettingsFactory,
        );

        $spinner = $spinnerFactory->createSpinner();
        self::assertInstanceOf(SpinnerFactory::class, $spinnerFactory);
        self::assertInstanceOf(Spinner::class, $spinner);
        self::assertSame($widget, self::getPropertyValue('rootWidget', $spinner));
    }

    #[Test]
    public function canCreateSpinnerWithConfig(): void
    {
        $rootWidgetConfig = $this->getWidgetConfigMock();
        $settingsProvider = $this->getSettingsProviderMock();
        $settingsProvider
            ->expects(self::once())
            ->method('getRootWidgetConfig')
            ->willReturn($rootWidgetConfig)
        ;

        $widgetConfig = $this->getWidgetConfigMock();
        $widgetConfig
            ->expects(self::once())
            ->method('merge')
            ->with($rootWidgetConfig)
            ->willReturnSelf();

        $spinnerConfig = $this->getSpinnerConfigMock();
        $spinnerConfig
            ->expects(self::once())
            ->method('getWidgetConfig')
            ->willReturn($widgetConfig);

        $widget = $this->getWidgetMock();
        $widgetSettings = $this->getWidgetSettingsMock();

        $widgetFactory = $this->getWidgetFactoryMock();
        $widgetFactory
            ->expects(self::once())
            ->method('createWidget')
            ->with($widgetSettings)
            ->willReturn($widget);

        $widgetSettingsFactory = $this->getWidgetSettingsFactoryMock();
        $widgetSettingsFactory
            ->expects(self::once())
            ->method('createFromConfig')
            ->with($widgetConfig)
            ->willReturn($widgetSettings)
        ;
        $spinnerFactory = $this->getTesteeInstance(
            settingsProvider: $settingsProvider,
            widgetFactory: $widgetFactory,
            widgetSettingsFactory: $widgetSettingsFactory,
        );

        $spinner = $spinnerFactory->createSpinner($spinnerConfig);
//
        self::assertInstanceOf(SpinnerFactory::class, $spinnerFactory);
        self::assertInstanceOf(Spinner::class, $spinner);
        self::assertSame($widget, self::getPropertyValue('rootWidget', $spinner));
    }
}
