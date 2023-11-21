<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\IGeneralSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILinkerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\GeneralSettings;
use AlecRabbit\Spinner\Core\Settings\LinkerSettings;
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
    public function canSetAndGetGeneralSettings(): void
    {
        $settings = $this->getTesteeInstance();

        $generalSettings = new GeneralSettings();

        $settings->set($generalSettings);

        self::assertSame($generalSettings, $settings->get(IGeneralSettings::class));
    }

    #[Test]
    public function canSetAndGetLinkerSettings(): void
    {
        $settings = $this->getTesteeInstance();

        $linkerSettings = new LinkerSettings();

        $settings->set($linkerSettings);

        self::assertSame($linkerSettings, $settings->get(ILinkerSettings::class));
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

        $generalSettings = new GeneralSettings();
        $linkerSettings = new LinkerSettings();
        $loopSettings = new LoopSettings();
        $outputSettings = new OutputSettings();
        $widgetSettings = new WidgetSettings();
        $rootWidgetSettings = new RootWidgetSettings();

        $settings->set(
            $generalSettings,
            $linkerSettings,
            $loopSettings,
            $outputSettings,
            $widgetSettings,
            $rootWidgetSettings,
        );

        self::assertSame($generalSettings, $settings->get(IGeneralSettings::class));
        self::assertSame($linkerSettings, $settings->get(ILinkerSettings::class));
        self::assertSame($loopSettings, $settings->get(ILoopSettings::class));
        self::assertSame($outputSettings, $settings->get(IOutputSettings::class));
        self::assertSame($widgetSettings, $settings->get(IWidgetSettings::class));
        self::assertSame($rootWidgetSettings, $settings->get(IRootWidgetSettings::class));
    }
}
