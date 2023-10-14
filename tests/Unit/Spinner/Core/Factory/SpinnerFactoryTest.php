<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetCompositeFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SpinnerFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $spinnerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SpinnerFactory::class, $spinnerFactory);
    }

    public function getTesteeInstance(
        ?IWidgetFactory $widgetFactory = null,
        ?IRootWidgetConfig $rootWidgetConfig = null,
    ): ISpinnerFactory {
        return
            new SpinnerFactory(
                widgetFactory: $widgetFactory ?? $this->getWidgetFactoryMock(),
                rootWidgetConfig: $rootWidgetConfig ?? $this->getRootWidgetConfigMock(),
            );
    }

    protected function getWidgetFactoryMock(): MockObject&IWidgetFactory
    {
        return $this->createMock(IWidgetFactory::class);
    }

    protected function getRootWidgetConfigMock(): MockObject&IRootWidgetConfig
    {
        return $this->createMock(IRootWidgetConfig::class);
    }

    #[Test]
    public function canCreateSpinnerUsingSpinnerSettings(): void
    {
        $widgetSettings = $this->getWidgetSettingsMock();
        $widgetFactory = $this->getWidgetFactoryMock();
        $widgetFactory
            ->expects(self::once())
            ->method('create')
            ->with($widgetSettings)
        ;
        $spinnerFactory = $this->getTesteeInstance(
            widgetFactory: $widgetFactory,
        );

        $spinnerSettings = $this->getSpinnerSettingsMock();
        $spinnerSettings
            ->expects(self::once())
            ->method('getWidgetSettings')
            ->willReturn($widgetSettings)
        ;

        $spinner = $spinnerFactory->create($spinnerSettings);

        self::assertInstanceOf(Spinner::class, $spinner);
    }

    protected function getWidgetSettingsMock(): MockObject&IWidgetSettings
    {
        return $this->createMock(IWidgetSettings::class);
    }

    protected function getSpinnerSettingsMock(): MockObject&ISpinnerSettings
    {
        return $this->createMock(ISpinnerSettings::class);
    }

    #[Test]
    public function canCreateSpinnerWithoutSpinnerSettings(): void
    {
        $widgetConfig = $this->getRootWidgetConfigMock();

        $widgetFactory = $this->getWidgetFactoryMock();
        $widgetFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::identicalTo($widgetConfig))
        ;
        $spinnerFactory = $this->getTesteeInstance(
            widgetFactory: $widgetFactory,
            rootWidgetConfig: $widgetConfig,
        );

        $spinner = $spinnerFactory->create();

        self::assertInstanceOf(Spinner::class, $spinner);
    }

    #[Test]
    public function canCreateUsingWidgetCompositeFactory(): void
    {
        $widgetConfig = $this->getRootWidgetConfigMock();

        $widgetFactory = $this->getWidgetCompositeFactoryMock();
        $widgetFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::identicalTo($widgetConfig))
        ;
        $spinnerFactory = $this->getTesteeInstance(
            widgetFactory: $widgetFactory,
            rootWidgetConfig: $widgetConfig,
        );

        $spinner = $spinnerFactory->create();

        self::assertInstanceOf(Spinner::class, $spinner);
    }

    protected function getWidgetCompositeFactoryMock(): MockObject&IWidgetCompositeFactory
    {
        return $this->createMock(IWidgetCompositeFactory::class);
    }

    protected function getSettingsProviderMock(): MockObject&ISettingsProvider
    {
        return $this->createMock(ISettingsProvider::class);
    }

    protected function getRootWidgetSettingsMock(): MockObject&IRootWidgetSettings
    {
        return $this->createMock(IRootWidgetSettings::class);
    }

    protected function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }

    protected function getConfigProviderMock(): MockObject&IConfigProvider
    {
        return $this->createMock(IConfigProvider::class);
    }

}
