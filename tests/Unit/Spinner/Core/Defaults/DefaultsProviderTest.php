<?php

declare(strict_types=1);

namespace Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\AuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\DriverSettings;
use AlecRabbit\Spinner\Core\Defaults\LoopSettings;
use AlecRabbit\Spinner\Core\Defaults\SpinnerSettings;
use AlecRabbit\Spinner\Core\Defaults\WidgetSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;

final class DefaultsProviderTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $defaultsProvider = $this->getTesteeInstance();

        self::assertInstanceOf(DefaultsProvider::class, $defaultsProvider);

        self::assertInstanceOf(ILoopSettings::class, $defaultsProvider->getLoopSettings());
        self::assertInstanceOf(ISpinnerSettings::class, $defaultsProvider->getSpinnerSettings());
        self::assertInstanceOf(IAuxSettings::class, $defaultsProvider->getAuxSettings());
        self::assertInstanceOf(IDriverSettings::class, $defaultsProvider->getDriverSettings());
        self::assertInstanceOf(IWidgetSettings::class, $defaultsProvider->getWidgetSettings());
        self::assertInstanceOf(IWidgetSettings::class, $defaultsProvider->getRootWidgetSettings());
    }

    public function getTesteeInstance(
        ?ILoopSettings $loopSettings = null,
        ?ISpinnerSettings $spinnerSettings = null,
        ?IAuxSettings $auxSettings = null,
        ?IDriverSettings $driverSettings = null,
        ?IWidgetSettings $widgetSettings = null,
        ?IWidgetSettings $rootWidgetSettings = null,
    ): IDefaultsProvider {
        return
            new DefaultsProvider(
                auxSettings: $auxSettings ?? $this->getAuxSettingsMock(),
                loopSettings: $loopSettings ?? $this->getLoopSettingsMock(),
                spinnerSettings: $spinnerSettings ?? $this->getSpinnerSettingsMock(),
                driverSettings: $driverSettings ?? $this->getDriverSettingsMock(),
                widgetSettings: $widgetSettings ?? $this->getWidgetSettingsMock(),
                rootWidgetSettings: $rootWidgetSettings ?? $this->getWidgetSettingsMock(),
            );
    }
}
