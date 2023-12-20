<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Spinner;
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
        ?IRootWidgetConfigFactory $widgetConfigFactory = null,
    ): ISpinnerFactory {
        return
            new SpinnerFactory(
                widgetFactory: $widgetFactory ?? $this->getWidgetFactoryMock(),
                widgetConfigFactory: $widgetConfigFactory ?? $this->getWidgetConfigFactoryMock(),
            );
    }

    protected function getWidgetFactoryMock(): MockObject&IWidgetFactory
    {
        return $this->createMock(IWidgetFactory::class);
    }

    protected function getWidgetConfigFactoryMock(): MockObject&IRootWidgetConfigFactory
    {
        return $this->createMock(IRootWidgetConfigFactory::class);
    }

    #[Test]
    public function canCreateSpinnerUsingSpinnerSettings(): void
    {
        $widgetConfig = $this->getRootWidgetConfigMock();

        $widgetSettings = $this->getWidgetSettingsMock();

        $widgetFactory = $this->getWidgetFactoryMock();
        $widgetFactory
            ->expects(self::once())
            ->method('usingSettings')
            ->with(self::identicalTo($widgetConfig))
            ->willReturnSelf()
        ;
        $widgetFactory
            ->expects(self::once())
            ->method('create')
        ;

        $widgetConfigFactory = $this->getWidgetConfigFactoryMock();
        $widgetConfigFactory
            ->expects(self::once())
            ->method('create')
            ->with($widgetSettings)
            ->willReturn($widgetConfig)
        ;

        $spinnerFactory = $this->getTesteeInstance(
            widgetFactory: $widgetFactory,
            widgetConfigFactory: $widgetConfigFactory,
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

    protected function getRootWidgetConfigMock(): MockObject&IRootWidgetConfig
    {
        return $this->createMock(IRootWidgetConfig::class);
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
            ->method('usingSettings')
            ->with(self::identicalTo($widgetConfig))
            ->willReturnSelf()
        ;
        $widgetFactory
            ->expects(self::once())
            ->method('create')
        ;

        $widgetConfigFactory = $this->getWidgetConfigFactoryMock();
        $widgetConfigFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::identicalTo(null))
            ->willReturn($widgetConfig)
        ;


        $spinnerFactory = $this->getTesteeInstance(
            widgetFactory: $widgetFactory,
            widgetConfigFactory: $widgetConfigFactory,
        );

        $spinner = $spinnerFactory->create();

        self::assertInstanceOf(Spinner::class, $spinner);
    }

    protected function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
