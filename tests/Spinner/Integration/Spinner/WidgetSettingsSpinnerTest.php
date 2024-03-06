<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Integration\Spinner;


use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Reference;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
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
use AlecRabbit\Tests\TestCase\Stub\WidgetFactoryTestStub;
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

        self::replaceService(
            new ServiceDefinition(
                IWidgetFactory::class,
                new Reference(WidgetFactoryTestStub::class),
            ),
            new ServiceDefinition(
                WidgetFactoryTestStub::class,
                WidgetFactoryTestStub::class,
            ),

        );

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
                private IWidgetConfig|IWidgetSettings|null $widgetSettings = null;

                public function __construct(
                    private readonly IWidget $widget,
                    private readonly Closure $test,
                ) {
                }

                public function create(): IWidget
                {
                    ($this->test)($this->widgetSettings);
                    $this->widgetSettings = null;
                    return $this->widget;
                }

                public function usingSettings(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IWidgetFactory
                {
                    $this->widgetSettings = $widgetSettings;
                    return $this;
                }
            };
    }

    private static function replaceService(IServiceDefinition ...$definitions): void
    {
        self::setContainer(
            self::modifyContainer(
                $definitions
            ),
        );
    }

    #[Test]
    public function spinnerCanBeCreatedWithAnyStylePalette(): void
    {
        $stylePalette = $this->getStylePaletteMock();

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

    private function getStylePaletteMock(): MockObject&IStylePalette
    {
        return $this->createMock(IStylePalette::class);
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
        $charPalette = $this->getCharPaletteMock();

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

    private function getCharPaletteMock(): MockObject&ICharPalette
    {
        return $this->createMock(ICharPalette::class);
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

    private function getFrameMock(): MockObject&ISequenceFrame
    {
        return $this->createMock(ISequenceFrame::class);
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
