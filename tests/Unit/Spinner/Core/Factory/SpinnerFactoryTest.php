<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetCompositeFactory;
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
        ?ILegacySettingsProvider $settingsProvider = null,
        ?IWidgetCompositeFactory $widgetFactory = null,
        ?IWidgetSettingsFactory $widgetSettingsFactory = null,
    ): ISpinnerFactory {
        return new SpinnerFactory(
            settingsProvider: $settingsProvider ?? $this->getLegacySettingsProviderMock(),
            widgetFactory: $widgetFactory ?? $this->getWidgetCompositeFactoryMock(),
            widgetSettingsFactory: $widgetSettingsFactory ?? $this->getWidgetSettingsFactoryMock(),
        );
    }

    #[Test]
    public function canCreateSpinnerWithoutConfig(): void
    {
        $rootWidgetSettings = $this->getLegacyWidgetSettingsMock();
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

        $widgetConfig = $this->getLegacyWidgetConfigMock();

        $settingsProvider = $this->getLegacySettingsProviderMock();
        $settingsProvider
            ->expects(self::once())
            ->method('getLegacyRootWidgetConfig')
            ->willReturn($widgetConfig)
        ;

        $widgetSettingsBuilder = $this->getLegacyWidgetSettingsBuilderMock();
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

        $widget = $this->getWidgetCompositeMock();

        $widgetFactory = $this->getWidgetCompositeFactoryMock();
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
        self::assertSame($widget, self::getPropertyValue('widget', $spinner));
    }

    #[Test]
    public function canCreateSpinnerWithConfig(): void
    {
        $rootWidgetConfig = $this->getLegacyWidgetConfigMock();
        $settingsProvider = $this->getLegacySettingsProviderMock();
        $settingsProvider
            ->expects(self::once())
            ->method('getLegacyRootWidgetConfig')
            ->willReturn($rootWidgetConfig)
        ;

        $widgetConfig = $this->getLegacyWidgetConfigMock();
        $widgetConfig
            ->expects(self::once())
            ->method('merge')
            ->with($rootWidgetConfig)
            ->willReturnSelf()
        ;

        $spinnerConfig = $this->getSpinnerConfigMock();
        $spinnerConfig
            ->expects(self::once())
            ->method('getWidgetConfig')
            ->willReturn($widgetConfig)
        ;

        $widget = $this->getWidgetCompositeMock();
        $widgetSettings = $this->getLegacyWidgetSettingsMock();

        $widgetFactory = $this->getWidgetCompositeFactoryMock();
        $widgetFactory
            ->expects(self::once())
            ->method('createWidget')
            ->with($widgetSettings)
            ->willReturn($widget)
        ;

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

        self::assertInstanceOf(SpinnerFactory::class, $spinnerFactory);
        self::assertInstanceOf(Spinner::class, $spinner);
        self::assertSame($widget, self::getPropertyValue('widget', $spinner));
    }

    #[Test]
    public function canCreateSpinnerWithWidgetConfig(): void
    {
        $rootWidgetConfig = $this->getLegacyWidgetConfigMock();
        $settingsProvider = $this->getLegacySettingsProviderMock();
        $settingsProvider
            ->expects(self::once())
            ->method('getLegacyRootWidgetConfig')
            ->willReturn($rootWidgetConfig)
        ;

        $widgetConfig = $this->getLegacyWidgetConfigMock();
        $widgetConfig
            ->expects(self::once())
            ->method('merge')
            ->with($rootWidgetConfig)
            ->willReturnSelf()
        ;

        $widget = $this->getWidgetCompositeMock();
        $widgetSettings = $this->getLegacyWidgetSettingsMock();

        $widgetFactory = $this->getWidgetCompositeFactoryMock();
        $widgetFactory
            ->expects(self::once())
            ->method('createWidget')
            ->with($widgetSettings)
            ->willReturn($widget)
        ;

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

        $spinner = $spinnerFactory->createSpinner($widgetConfig);

        self::assertInstanceOf(SpinnerFactory::class, $spinnerFactory);
        self::assertInstanceOf(Spinner::class, $spinner);
        self::assertSame($widget, self::getPropertyValue('widget', $spinner));
    }
}
