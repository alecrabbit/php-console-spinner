<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Complex\Config;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetConfigTest extends ConfigurationTestCase
{
    protected static function setTestContainer(): void
    {
        self::setContainer(
            self::modifyContainer(
                self::getStoredContainer(),
                [
                    // Detected settings considered as AUTO
                    IDetectedSettingsFactory::class => static function () {
                        return new class() implements IDetectedSettingsFactory {
                            public function create(): ISettings
                            {
                                return new Settings(); // empty object considered as AUTO
                            }
                        };
                    },
                ]
            )
        );
    }

    #[Test]
    public function canSetStylePalette(): void
    {
        $stylePalette = $this->getStylePaletteMock();

        Facade::getSettings()
            ->set(
                new WidgetSettings(
                    stylePalette: $stylePalette,
                ),
            )
        ;

        /** @var IWidgetConfig $widgetConfig */
        $widgetConfig = self::getRequiredConfig(IWidgetConfig::class);

        $revolverConfig = $widgetConfig->getWidgetRevolverConfig();
        self::assertSame($stylePalette, $revolverConfig->getStylePalette());
        self::assertNotSame($stylePalette, $revolverConfig->getCharPalette());
    }

    private function getStylePaletteMock(): MockObject&IStylePalette
    {
        return $this->createMock(IStylePalette::class);
    }

    #[Test]
    public function canSetCharPalette(): void
    {
        $charPalette = $this->getCharPaletteMock();

        Facade::getSettings()
            ->set(
                new WidgetSettings(
                    charPalette: $charPalette,
                ),
            )
        ;

        /** @var IWidgetConfig $widgetConfig */
        $widgetConfig = self::getRequiredConfig(IWidgetConfig::class);

        $revolverConfig = $widgetConfig->getWidgetRevolverConfig();
        self::assertSame($charPalette, $revolverConfig->getCharPalette());
        self::assertNotSame($charPalette, $revolverConfig->getStylePalette());
    }

    private function getCharPaletteMock(): MockObject&ICharPalette
    {
        return $this->createMock(ICharPalette::class);
    }

    #[Test]
    public function canSetLeadingSpacer(): void
    {
        $leadingSpacer = $this->getFrameMock();

        Facade::getSettings()
            ->set(
                new WidgetSettings(
                    leadingSpacer: $leadingSpacer,
                ),
            )
        ;

        /** @var IWidgetConfig $widgetConfig */
        $widgetConfig = self::getRequiredConfig(IWidgetConfig::class);

        self::assertSame($leadingSpacer, $widgetConfig->getLeadingSpacer());
        self::assertNotSame($leadingSpacer, $widgetConfig->getTrailingSpacer());
    }

    private function getFrameMock(): MockObject&ISequenceFrame
    {
        return $this->createMock(ISequenceFrame::class);
    }

    #[Test]
    public function canSetTrailingSpacer(): void
    {
        $trailingSpacer = $this->getFrameMock();

        Facade::getSettings()
            ->set(
                new WidgetSettings(
                    trailingSpacer: $trailingSpacer,
                ),
            )
        ;

        /** @var IWidgetConfig $widgetConfig */
        $widgetConfig = self::getRequiredConfig(IWidgetConfig::class);

        self::assertSame($trailingSpacer, $widgetConfig->getTrailingSpacer());
        self::assertNotSame($trailingSpacer, $widgetConfig->getLeadingSpacer());
    }
}
