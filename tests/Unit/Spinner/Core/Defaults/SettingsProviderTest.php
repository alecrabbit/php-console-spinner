<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyTerminalSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacySettingsProvider;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SettingsProviderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $settingsProvider = $this->getTesteeInstance();

        self::assertInstanceOf(LegacySettingsProvider::class, $settingsProvider);

        self::assertInstanceOf(ILegacyLoopSettings::class, $settingsProvider->getLegacyLoopSettings());
        self::assertInstanceOf(ILegacyAuxSettings::class, $settingsProvider->getLegacyAuxSettings());
        self::assertInstanceOf(ILegacyTerminalSettings::class, $settingsProvider->getLegacyTerminalSettings());
        self::assertInstanceOf(ILegacyDriverSettings::class, $settingsProvider->getLegacyDriverSettings());
        self::assertInstanceOf(ILegacyWidgetConfig::class, $settingsProvider->getLegacyWidgetConfig());
        self::assertInstanceOf(ILegacyWidgetConfig::class, $settingsProvider->getLegacyRootWidgetConfig());
    }

    public function getTesteeInstance(
        ?ILegacyLoopSettings $loopSettings = null,
        ?ILegacyTerminalSettings $terminalSettings = null,
        ?ILegacyAuxSettings $auxSettings = null,
        ?ILegacyDriverSettings $driverSettings = null,
        ?ILegacyWidgetConfig $widgetConfig = null,
        ?ILegacyWidgetConfig $rootWidgetConfig = null,
    ): ILegacySettingsProvider {
        return
            new LegacySettingsProvider(
                auxSettings: $auxSettings ?? $this->getLegacyAuxSettingsMock(),
                terminalSettings: $terminalSettings ?? $this->getLegacyTerminalSettingsMock(),
                loopSettings: $loopSettings ?? $this->getLegacyLoopSettingsMock(),
                driverSettings: $driverSettings ?? $this->getLegacyDriverSettingsMock(),
                widgetConfig: $widgetConfig ?? $this->getLegacyWidgetConfigMock(),
                rootWidgetConfig: $rootWidgetConfig ?? $this->getLegacyWidgetConfigMock(),
            );
    }
}
