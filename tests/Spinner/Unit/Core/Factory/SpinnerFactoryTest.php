<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
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
        ?ISpinnerBuilder $spinnerBuilder = null,
    ): ISpinnerFactory {
        return
            new SpinnerFactory(
                widgetFactory: $widgetFactory ?? $this->getWidgetFactoryMock(),
                widgetConfigFactory: $widgetConfigFactory ?? $this->getWidgetConfigFactoryMock(),
                spinnerBuilder: $spinnerBuilder ?? $this->getSpinnerBuilderMock(),
            );
    }

    private function getWidgetFactoryMock(): MockObject&IWidgetFactory
    {
        return $this->createMock(IWidgetFactory::class);
    }

    private function getWidgetConfigFactoryMock(): MockObject&IRootWidgetConfigFactory
    {
        return $this->createMock(IRootWidgetConfigFactory::class);
    }

    private function getSpinnerBuilderMock(): MockObject&ISpinnerBuilder
    {
        return $this->createMock(ISpinnerBuilder::class);
    }

    #[Test]
    public function canCreateSpinnerUsingSpinnerSettings(): void
    {
        $widget = $this->getWidgetMock();
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
            ->willReturn($widget)
        ;

        $widgetConfigFactory = $this->getWidgetConfigFactoryMock();
        $widgetConfigFactory
            ->expects(self::once())
            ->method('create')
            ->with($widgetSettings)
            ->willReturn($widgetConfig)
        ;

        $spinner = $this->getSpinnerMock();
        $spinnerBuilder = $this->getSpinnerBuilderMock();
        $spinnerBuilder
            ->expects($this->once())
            ->method('withWidget')
            ->with($widget)
            ->willReturnSelf()
        ;
        $spinnerBuilder
            ->expects($this->once())
            ->method('build')
            ->willReturn($spinner)
        ;

        $spinnerFactory = $this->getTesteeInstance(
            widgetFactory: $widgetFactory,
            widgetConfigFactory: $widgetConfigFactory,
            spinnerBuilder: $spinnerBuilder,
        );

        $spinnerSettings = $this->getSpinnerSettingsMock();
        $spinnerSettings
            ->expects(self::once())
            ->method('getWidgetSettings')
            ->willReturn($widgetSettings)
        ;

        $actual = $spinnerFactory->create($spinnerSettings);

        self::assertSame($spinner, $actual);
    }

    private function getRootWidgetConfigMock(): MockObject&IRootWidgetConfig
    {
        return $this->createMock(IRootWidgetConfig::class);
    }

    private function getWidgetSettingsMock(): MockObject&IWidgetSettings
    {
        return $this->createMock(IWidgetSettings::class);
    }

    private function getSpinnerSettingsMock(): MockObject&ISpinnerSettings
    {
        return $this->createMock(ISpinnerSettings::class);
    }

    #[Test]
    public function canCreateSpinnerWithoutSpinnerSettings(): void
    {
        $widget = $this->getWidgetMock();
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
            ->willReturn($widget)
        ;

        $widgetConfigFactory = $this->getWidgetConfigFactoryMock();
        $widgetConfigFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::identicalTo(null))
            ->willReturn($widgetConfig)
        ;

        $spinner = $this->getSpinnerMock();
        $spinnerBuilder = $this->getSpinnerBuilderMock();
        $spinnerBuilder
            ->expects($this->once())
            ->method('withWidget')
            ->with($widget)
            ->willReturnSelf()
        ;
        $spinnerBuilder
            ->expects($this->once())
            ->method('build')
            ->willReturn($spinner)
        ;

        $spinnerFactory = $this->getTesteeInstance(
            widgetFactory: $widgetFactory,
            widgetConfigFactory: $widgetConfigFactory,
            spinnerBuilder: $spinnerBuilder,
        );

        $actual = $spinnerFactory->create();

        self::assertSame($spinner, $actual);
    }

    private function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    private function getSpinnerMock(): MockObject&ISpinner
    {
        return $this->createMock(ISpinner::class);
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
