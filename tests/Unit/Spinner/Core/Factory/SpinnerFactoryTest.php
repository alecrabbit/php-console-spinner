<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Render\StyleFrameRenderer;
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
        $config = $this->getSpinnerConfigMock();
        $widget = $this->getWidgetCompositeMock();
        $widgetSettings = $this->getWidgetSettingsMock();
        $widgetFactory = $this->getWidgetFactoryMock();
        $widgetFactory
            ->expects(self::once())
            ->method('createWidget')
//            ->with($widgetSettings)
            ->willReturn($widget);
        $spinnerFactory = $this->getTesteeInstance(
            widgetFactory: $widgetFactory,
        );

        $spinner = $spinnerFactory->createSpinner($config);
        self::assertInstanceOf(SpinnerFactory::class, $spinnerFactory);
        self::assertInstanceOf(Spinner::class, $spinner);
        self::assertSame($widget, self::getPropertyValue('rootWidget', $spinner));

    }
}
