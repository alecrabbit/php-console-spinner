<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Complex\Spinner;


use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\NoCharPalette;
use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ContainerModifyingTestCase;
use Closure;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetSettingsSpinnerTest extends ContainerModifyingTestCase
{
    #[Test]
    public function spinnerCanBeCreatedWithNoStylePalette(): void
    {
        $stylePalette = new NoStylePalette();

        $widgetSettings = new WidgetSettings(stylePalette: $stylePalette);

        $test = static function (IWidgetConfig|IWidgetSettings|null $config) use ($stylePalette): void {
            self::assertInstanceOf(IWidgetConfig::class, $config);
            self::assertSame($config->getWidgetRevolverConfig()->getStylePalette(), $stylePalette);
            self::assertNotSame($config->getWidgetRevolverConfig()->getCharPalette(), $stylePalette);
        };

        $widget = $this->getWidgetMock();

        $widgetFactory = $this->createWidgetFactory($widget, $test);

        self::replaceService(IWidgetFactory::class, $widgetFactory);

        $spinnerSettings = new SpinnerSettings(widgetSettings: $widgetSettings);
        $spinner = Facade::createSpinner($spinnerSettings);

        self::assertInstanceOf(Spinner::class, $spinner);

        $driver = Facade::getDriver();

        self::assertTrue($driver->has($spinner));
    }

    private function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    protected function createWidgetFactory(MockObject&IWidget $widget, Closure $test): IWidgetFactory
    {
        return
            new class($widget, $test) implements IWidgetFactory {

                public function __construct(
                    private readonly IWidget $widget,
                    private readonly Closure $test,
                ) {
                }

                public function create(
                    IWidgetConfig|IWidgetSettings|null $widgetSettings = null,
                ): IWidget {
                    ($this->test)($widgetSettings);

                    return $this->widget;
                }
            };
    }

    private static function replaceService(string $id, object|callable|string $definition): void
    {
        self::setContainer(
            self::modifyContainer(
                self::getStoredContainer(),
                [
                    $id => $definition,
                ]
            ),
        );
    }

    #[Test]
    public function spinnerCanBeCreatedWithAnyStylePalette(): void
    {
        $stylePalette = $this->getPaletteMock();

        $widgetSettings = new WidgetSettings(stylePalette: $stylePalette);

        $test = static function (IWidgetConfig|IWidgetSettings|null $config) use ($stylePalette): void {
            self::assertInstanceOf(IWidgetConfig::class, $config);
            self::assertSame($config->getWidgetRevolverConfig()->getStylePalette(), $stylePalette);
            self::assertNotSame($config->getWidgetRevolverConfig()->getCharPalette(), $stylePalette);
        };

        $widget = $this->getWidgetMock();

        $widgetFactory = $this->createWidgetFactory($widget, $test);

        self::replaceService(IWidgetFactory::class, $widgetFactory);

        $spinnerSettings = new SpinnerSettings(widgetSettings: $widgetSettings);
        $spinner = Facade::createSpinner($spinnerSettings);

        self::assertInstanceOf(Spinner::class, $spinner);

        $driver = Facade::getDriver();

        self::assertTrue($driver->has($spinner));
    }

    private function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }

    #[Test]
    public function spinnerCanBeCreatedWithNoCharPalette(): void
    {
        $charPalette = new NoCharPalette();

        $widgetSettings = new WidgetSettings(charPalette: $charPalette);

        $test = static function (IWidgetConfig|IWidgetSettings|null $config) use ($charPalette): void {
            self::assertInstanceOf(IWidgetConfig::class, $config);
            self::assertSame($config->getWidgetRevolverConfig()->getCharPalette(), $charPalette);
            self::assertNotSame($config->getWidgetRevolverConfig()->getStylePalette(), $charPalette);
        };

        $widget = $this->getWidgetMock();

        $widgetFactory = $this->createWidgetFactory($widget, $test);

        self::replaceService(IWidgetFactory::class, $widgetFactory);

        $spinnerSettings = new SpinnerSettings(widgetSettings: $widgetSettings);
        $spinner = Facade::createSpinner($spinnerSettings);

        self::assertInstanceOf(Spinner::class, $spinner);

        $driver = Facade::getDriver();

        self::assertTrue($driver->has($spinner));
    }

    #[Test]
    public function spinnerCanBeCreatedWithAnyCharPalette(): void
    {
        $charPalette = $this->getPaletteMock();

        $widgetSettings = new WidgetSettings(charPalette: $charPalette);

        $test = static function (IWidgetConfig|IWidgetSettings|null $config) use ($charPalette): void {
            self::assertInstanceOf(IWidgetConfig::class, $config);
            self::assertSame($config->getWidgetRevolverConfig()->getCharPalette(), $charPalette);
            self::assertNotSame($config->getWidgetRevolverConfig()->getStylePalette(), $charPalette);
        };

        $widget = $this->getWidgetMock();

        $widgetFactory = $this->createWidgetFactory($widget, $test);

        self::replaceService(IWidgetFactory::class, $widgetFactory);

        $spinnerSettings = new SpinnerSettings(widgetSettings: $widgetSettings);
        $spinner = Facade::createSpinner($spinnerSettings);

        self::assertInstanceOf(Spinner::class, $spinner);

        $driver = Facade::getDriver();

        self::assertTrue($driver->has($spinner));
    }

    #[Test]
    public function spinnerCanBeCreatedWithAnyLeadingSpacer(): void
    {
        $leadingSpacer = $this->getFrameMock();

        $widgetSettings = new WidgetSettings(leadingSpacer: $leadingSpacer);

        $test = static function (IWidgetConfig|IWidgetSettings|null $config) use ($leadingSpacer): void {
            self::assertInstanceOf(IWidgetConfig::class, $config);
            self::assertSame($config->getLeadingSpacer(), $leadingSpacer);
            self::assertNotSame($config->getTrailingSpacer(), $leadingSpacer);
        };

        $widget = $this->getWidgetMock();

        $widgetFactory = $this->createWidgetFactory($widget, $test);

        self::replaceService(IWidgetFactory::class, $widgetFactory);

        $spinnerSettings = new SpinnerSettings(widgetSettings: $widgetSettings);
        $spinner = Facade::createSpinner($spinnerSettings);

        self::assertInstanceOf(Spinner::class, $spinner);

        $driver = Facade::getDriver();

        self::assertTrue($driver->has($spinner));
    }

    private function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    #[Test]
    public function spinnerCanBeCreatedWithAnyTrailingSpacer(): void
    {
        $trailingSpacer = $this->getFrameMock();

        $widgetSettings = new WidgetSettings(trailingSpacer: $trailingSpacer);

        $test = static function (IWidgetConfig|IWidgetSettings|null $config) use ($trailingSpacer): void {
            self::assertInstanceOf(IWidgetConfig::class, $config);
            self::assertSame($config->getTrailingSpacer(), $trailingSpacer);
            self::assertNotSame($config->getLeadingSpacer(), $trailingSpacer);
        };

        $widget = $this->getWidgetMock();

        $widgetFactory = $this->createWidgetFactory($widget, $test);

        self::replaceService(IWidgetFactory::class, $widgetFactory);

        $spinnerSettings = new SpinnerSettings(widgetSettings: $widgetSettings);
        $spinner = Facade::createSpinner($spinnerSettings);

        self::assertInstanceOf(Spinner::class, $spinner);

        $driver = Facade::getDriver();

        self::assertTrue($driver->has($spinner));
    }
}
