<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
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

    public function getTesteeInstance(
        ?IAuxSettings $auxSettings = null,
        ?ILoopSettings $loopSettings = null,
        ?IOutputSettings $outputSettings = null,
        ?IDriverSettings $driverSettings = null,
        ?IWidgetSettings $widgetSettings = null,
        ?IWidgetSettings $rootWidgetSettings = null,
    ): ISettings {
        return
            new Settings(
                auxSettings: $auxSettings ?? $this->getAuxSettingsMock(),
                loopSettings: $loopSettings ?? $this->getLoopSettingsMock(),
                outputSettings: $outputSettings ?? $this->getOutputSettingsMock(),
                driverSettings: $driverSettings ?? $this->getDriverSettingsMock(),
                widgetSettings: $widgetSettings ?? $this->getWidgetSettingsMock(),
                rootWidgetSettings: $rootWidgetSettings ?? $this->getWidgetSettingsMock(),
            );
    }

    #[Test]
    public function canGetAuxSettings(): void
    {
        $auxSettings = $this->getAuxSettingsMock();

        $settings = $this->getTesteeInstance(
            auxSettings: $auxSettings,
        );

        self::assertSame($auxSettings, $settings->getAuxSettings());
    }

    #[Test]
    public function canGetWidgetSettings(): void
    {
        $widgetSettings = $this->getWidgetSettingsMock();

        $settings = $this->getTesteeInstance(
            widgetSettings: $widgetSettings,
        );

        self::assertSame($widgetSettings, $settings->getWidgetSettings());
        self::assertNotSame($widgetSettings, $settings->getRootWidgetSettings());
    }

    #[Test]
    public function canGetRootWidgetSettings(): void
    {
        $rootWidgetSettings = $this->getWidgetSettingsMock();

        $settings = $this->getTesteeInstance(
            rootWidgetSettings: $rootWidgetSettings,
        );

        self::assertSame($rootWidgetSettings, $settings->getRootWidgetSettings());
        self::assertNotSame($rootWidgetSettings, $settings->getWidgetSettings());
    }

    #[Test]
    public function canGetDriverSettings(): void
    {
        $driverSettings = $this->getDriverSettingsMock();

        $settings = $this->getTesteeInstance(
            driverSettings: $driverSettings,
        );

        self::assertSame($driverSettings, $settings->getDriverSettings());
    }

    #[Test]
    public function canGetLoopSettings(): void
    {
        $loopSettings = $this->getLoopSettingsMock();

        $settings = $this->getTesteeInstance(
            loopSettings: $loopSettings,
        );

        self::assertSame($loopSettings, $settings->getLoopSettings());
    }

    #[Test]
    public function canGetOutputSettings(): void
    {
        $outputSettings = $this->getOutputSettingsMock();

        $settings = $this->getTesteeInstance(
            outputSettings: $outputSettings,
        );

        self::assertSame($outputSettings, $settings->getOutputSettings());
    }

    protected function getAuxSettingsMock(): IAuxSettings
    {
        return $this->createMock(IAuxSettings::class);
    }

    protected function getLoopSettingsMock(): ILoopSettings
    {
        return $this->createMock(ILoopSettings::class);
    }

    protected function getOutputSettingsMock(): IOutputSettings
    {
        return $this->createMock(IOutputSettings::class);
    }

    protected function getDriverSettingsMock(): IDriverSettings
    {
        return $this->createMock(IDriverSettings::class);
    }

    protected function getWidgetSettingsMock(): IWidgetSettings
    {
        return $this->createMock(IWidgetSettings::class);
    }
}
