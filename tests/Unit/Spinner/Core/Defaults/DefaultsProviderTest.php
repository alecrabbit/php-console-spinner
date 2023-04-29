<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProvider;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DefaultsProviderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $defaultsProvider = $this->getTesteeInstance();

        self::assertInstanceOf(DefaultsProvider::class, $defaultsProvider);

        self::assertInstanceOf(ILoopSettings::class, $defaultsProvider->getLoopSettings());
        self::assertInstanceOf(IAuxSettings::class, $defaultsProvider->getAuxSettings());
        self::assertInstanceOf(ITerminalSettings::class, $defaultsProvider->getTerminalSettings());
        self::assertInstanceOf(IDriverSettings::class, $defaultsProvider->getDriverSettings());
        self::assertInstanceOf(IWidgetConfig::class, $defaultsProvider->getWidgetConfig());
        self::assertInstanceOf(IWidgetConfig::class, $defaultsProvider->getRootWidgetConfig());
    }

    public function getTesteeInstance(
        ?ILoopSettings $loopSettings = null,
        ?ITerminalSettings $terminalSettings = null,
        ?IAuxSettings $auxSettings = null,
        ?IDriverSettings $driverSettings = null,
        ?IWidgetConfig $widgetConfig = null,
        ?IWidgetConfig $rootWidgetConfig = null,
    ): IDefaultsProvider {
        return
            new DefaultsProvider(
                auxSettings: $auxSettings ?? $this->getAuxSettingsMock(),
                terminalSettings: $terminalSettings ?? $this->getTerminalSettingsMock(),
                loopSettings: $loopSettings ?? $this->getLoopSettingsMock(),
                driverSettings: $driverSettings ?? $this->getDriverSettingsMock(),
                widgetConfig: $widgetConfig ?? $this->getWidgetConfigMock(),
                rootWidgetConfig: $rootWidgetConfig ?? $this->getWidgetConfigMock(),
            );
    }
}