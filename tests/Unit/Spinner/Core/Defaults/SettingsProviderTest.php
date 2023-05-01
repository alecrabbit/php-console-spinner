<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Core\Settings\SettingsProvider;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SettingsProviderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $settingsProvider = $this->getTesteeInstance();

        self::assertInstanceOf(SettingsProvider::class, $settingsProvider);

        self::assertInstanceOf(ILoopSettings::class, $settingsProvider->getLoopSettings());
        self::assertInstanceOf(IAuxSettings::class, $settingsProvider->getAuxSettings());
        self::assertInstanceOf(ITerminalSettings::class, $settingsProvider->getTerminalSettings());
        self::assertInstanceOf(IDriverSettings::class, $settingsProvider->getDriverSettings());
        self::assertInstanceOf(IWidgetConfig::class, $settingsProvider->getWidgetConfig());
        self::assertInstanceOf(IWidgetConfig::class, $settingsProvider->getRootWidgetConfig());
    }

    public function getTesteeInstance(
        ?ILoopSettings $loopSettings = null,
        ?ITerminalSettings $terminalSettings = null,
        ?IAuxSettings $auxSettings = null,
        ?IDriverSettings $driverSettings = null,
        ?IWidgetConfig $widgetConfig = null,
        ?IWidgetConfig $rootWidgetConfig = null,
    ): ISettingsProvider {
        return
            new SettingsProvider(
                auxSettings: $auxSettings ?? $this->getAuxSettingsMock(),
                terminalSettings: $terminalSettings ?? $this->getTerminalSettingsMock(),
                loopSettings: $loopSettings ?? $this->getLoopSettingsMock(),
                driverSettings: $driverSettings ?? $this->getDriverSettingsMock(),
                widgetConfig: $widgetConfig ?? $this->getWidgetConfigMock(),
                rootWidgetConfig: $rootWidgetConfig ?? $this->getWidgetConfigMock(),
            );
    }
}
