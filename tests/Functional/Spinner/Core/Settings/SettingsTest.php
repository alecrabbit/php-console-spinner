<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SettingsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(Settings::class, $settings);
    }

    public function getTesteeInstance(): ISettings
    {
        return
            new Settings();
    }

    #[Test]
    public function canSetAndGetAuxSettings(): void
    {
        $settings = $this->getTesteeInstance();

        $auxSettings = new AuxSettings();

        $settings->set($auxSettings);

        self::assertSame($auxSettings, $settings->get(IAuxSettings::class));
    }

    #[Test]
    public function canSetAndGetDriverSettings(): void
    {
        $settings = $this->getTesteeInstance();

        $driverSettings = new DriverSettings();

        $settings->set($driverSettings);

        self::assertSame($driverSettings, $settings->get(IDriverSettings::class));
    }

    #[Test]
    public function canSetAndGetLoopSettings(): void
    {
        $settings = $this->getTesteeInstance();

        $loopSettings = new LoopSettings();

        $settings->set($loopSettings);

        self::assertSame($loopSettings, $settings->get(ILoopSettings::class));
    }

    #[Test]
    public function canSetAndGetOutputSettings(): void
    {
        $settings = $this->getTesteeInstance();

        $outputSettings = new OutputSettings();

        $settings->set($outputSettings);

        self::assertSame($outputSettings, $settings->get(IOutputSettings::class));
    }

    #[Test]
    public function canSetAndGetWidgetSettings(): void
    {
        $settings = $this->getTesteeInstance();

        $widgetSettings = new WidgetSettings();

        $settings->set($widgetSettings);

        self::assertSame($widgetSettings, $settings->get(IWidgetSettings::class));
    }

    #[Test]
    public function canSetAndGetRootWidgetSettings(): void
    {
        $settings = $this->getTesteeInstance();

        $widgetSettings = new RootWidgetSettings();

        $settings->set($widgetSettings);

        self::assertSame($widgetSettings, $settings->get(IRootWidgetSettings::class));
    }

    #[Test]
    public function canSetAndGetAll(): void
    {
        $settings = $this->getTesteeInstance();

        $auxSettings = new AuxSettings();
        $driverSettings = new DriverSettings();
        $loopSettings = new LoopSettings();
        $outputSettings = new OutputSettings();
        $widgetSettings = new WidgetSettings();
        $rootWidgetSettings = new RootWidgetSettings();

        $settings->set(
            $auxSettings,
            $driverSettings,
            $loopSettings,
            $outputSettings,
            $widgetSettings,
            $rootWidgetSettings,
        );

        self::assertSame($auxSettings, $settings->get(IAuxSettings::class));
        self::assertSame($driverSettings, $settings->get(IDriverSettings::class));
        self::assertSame($loopSettings, $settings->get(ILoopSettings::class));
        self::assertSame($outputSettings, $settings->get(IOutputSettings::class));
        self::assertSame($widgetSettings, $settings->get(IWidgetSettings::class));
        self::assertSame($rootWidgetSettings, $settings->get(IRootWidgetSettings::class));
    }
}
