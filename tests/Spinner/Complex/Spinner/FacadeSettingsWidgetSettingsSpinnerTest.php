<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Complex\Spinner;


use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Palette\LegacyNoStylePalette;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
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

final class FacadeSettingsWidgetSettingsSpinnerTest extends ContainerModifyingTestCase
{
    #[Test]
    public function spinnerCanBeCreatedWithCustomLeadingSpacerAndNoStylePalette(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $stylePalette = new LegacyNoStylePalette();

        $widgetSettings = new WidgetSettings(stylePalette: $stylePalette);

        $test =
            static function (IWidgetConfig|IWidgetSettings|null $config) use ($stylePalette, $leadingSpacer): void {
                self::assertInstanceOf(IWidgetConfig::class, $config);

                self::assertSame(
                    $config->getLeadingSpacer(),
                    $leadingSpacer,
                    'Leading spacer mismatch.'
                );
                self::assertNotSame(
                    $config->getTrailingSpacer(),
                    $leadingSpacer,
                    'Trailing spacer and leading spacer are the same.'
                );

                self::assertSame(
                    $config->getWidgetRevolverConfig()->getStylePalette(),
                    $stylePalette,
                    'Style palette mismatch.'
                );
                self::assertNotSame(
                    $config->getWidgetRevolverConfig()->getCharPalette(),
                    $stylePalette,
                    'Char palette and style palette are the same.'
                );
            };

        $widget = $this->getWidgetMock();

        $widgetFactory = $this->createWidgetFactoryWithTest($widget, $test);

        self::replaceService(IWidgetFactory::class, $widgetFactory);

        Facade::getSettings()->set(
            new RootWidgetSettings(
                leadingSpacer: $leadingSpacer,
            ),
        );

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

    private function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    protected function createWidgetFactoryWithTest(MockObject&IWidget $widget, Closure $test): IWidgetFactory
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
    public function spinnerCanBeCreatedWithCustomTrailingSpacerAndNoStylePalette(): void
    {
        $trailingSpacer = $this->getFrameMock();
        $stylePalette = new LegacyNoStylePalette();

        $widgetSettings = new WidgetSettings(stylePalette: $stylePalette);

        $test =
            static function (IWidgetConfig|IWidgetSettings|null $config) use ($stylePalette, $trailingSpacer): void {
                self::assertInstanceOf(IWidgetConfig::class, $config);

                self::assertNotSame(
                    $config->getLeadingSpacer(),
                    $trailingSpacer,
                    'Leading spacer and trailing spacer are the same.'
                );
                self::assertSame(
                    $config->getTrailingSpacer(),
                    $trailingSpacer,
                    'Trailing spacer mismatch.'
                );

                self::assertSame(
                    $config->getWidgetRevolverConfig()->getStylePalette(),
                    $stylePalette,
                    'Style palette mismatch.'
                );
                self::assertNotSame(
                    $config->getWidgetRevolverConfig()->getCharPalette(),
                    $stylePalette,
                    'Char palette and style palette are the same.'
                );
            };

        $widget = $this->getWidgetMock();

        $widgetFactory = $this->createWidgetFactoryWithTest($widget, $test);

        self::replaceService(IWidgetFactory::class, $widgetFactory);

        Facade::getSettings()->set(
            new RootWidgetSettings(
                trailingSpacer: $trailingSpacer,
            ),
        );

        $spinnerSettings = new SpinnerSettings(widgetSettings: $widgetSettings);

        $spinner = Facade::createSpinner($spinnerSettings);

        self::assertInstanceOf(Spinner::class, $spinner);

        $driver = Facade::getDriver();

        self::assertTrue($driver->has($spinner));
    }

    #[Test]
    public function closestWidgetSettingsHasPriority(): void
    {
        $trailingSpacerOne = $this->getFrameMock();
        $stylePaletteOne = new LegacyNoStylePalette();

        $trailingSpacerTwo = $this->getFrameMock();
        $stylePaletteTwo = $this->getStylePaletteMock();

        $widgetSettings =
            new WidgetSettings(
                trailingSpacer: $trailingSpacerOne, // <-- used
                stylePalette: $stylePaletteOne, // <-- used
            );

        $test =
            static function (IWidgetConfig|IWidgetSettings|null $config) use (
                $stylePaletteOne,
                $stylePaletteTwo,
                $trailingSpacerOne,
                $trailingSpacerTwo,
            ): void {
                self::assertInstanceOf(IWidgetConfig::class, $config);

                self::assertNotSame(
                    $config->getLeadingSpacer(),
                    $trailingSpacerOne,
                    'Leading spacer and trailing spacer are the same(one).'
                );
                self::assertNotSame(
                    $config->getLeadingSpacer(),
                    $trailingSpacerTwo,
                    'Leading spacer and trailing spacer are the same(two).'
                );

                self::assertSame(
                    $config->getTrailingSpacer(),
                    $trailingSpacerOne,
                    'Trailing spacer mismatch.'
                );
                self::assertNotSame(
                    $config->getTrailingSpacer(),
                    $trailingSpacerTwo,
                    'Wrong trailing spacer.'
                );

                self::assertSame(
                    $config->getWidgetRevolverConfig()->getStylePalette(),
                    $stylePaletteOne,
                    'Style palette mismatch.'
                );
                self::assertNotSame(
                    $config->getWidgetRevolverConfig()->getCharPalette(),
                    $stylePaletteOne,
                    'Char palette and style palette are the same.'
                );
                self::assertNotSame(
                    $config->getWidgetRevolverConfig()->getStylePalette(),
                    $stylePaletteTwo,
                    'Wrong style palette.'
                );
            };

        $widget = $this->getWidgetMock();

        $widgetFactory = $this->createWidgetFactoryWithTest($widget, $test);

        self::replaceService(IWidgetFactory::class, $widgetFactory);

        Facade::getSettings()->set(
            new RootWidgetSettings(
                trailingSpacer: $trailingSpacerTwo, // <-- ignored
                stylePalette: $stylePaletteTwo, // <-- ignored
            ),
        );

        $spinnerSettings = new SpinnerSettings(widgetSettings: $widgetSettings); // <-- closest

        $spinner = Facade::createSpinner($spinnerSettings);

        self::assertInstanceOf(Spinner::class, $spinner);

        $driver = Facade::getDriver();

        self::assertTrue($driver->has($spinner));
    }

    private function getStylePaletteMock(): MockObject&IStylePalette
    {
        return $this->createMock(IStylePalette::class);
    }
}
