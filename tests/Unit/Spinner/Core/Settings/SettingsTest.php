<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SettingsTest extends TestCaseWithPrebuiltMocksAndStubs
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
    public function canGetAuxSettings(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(AuxSettings::class, $settings->getAuxSettings());
    }

    #[Test]
    public function canGetWidgetSettings(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetSettings::class, $settings->getWidgetSettings());
    }

    #[Test]
    public function canGetRootWidgetSettings(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetSettings::class, $settings->getRootWidgetSettings());
    }

    #[Test]
    public function canGetDriverSettings(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(DriverSettings::class, $settings->getDriverSettings());
    }

    #[Test]
    public function canGetLoopSettings(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSettings::class, $settings->getLoopSettings());
    }

    #[Test]
    public function canGetOutputSettings(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(OutputSettings::class, $settings->getOutputSettings());
    }
}
