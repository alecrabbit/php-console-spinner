<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Complex\Config;

use AlecRabbit\Spinner\Contract\Mode\DriverMode;
use AlecRabbit\Spinner\Contract\Option\DriverOption;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use PHPUnit\Framework\Attributes\Test;

final class DriverModeConfigTest extends ConfigurationTestCase
{


    #[Test]
    public function canSetDriverOptionEnabled(): void
    {
        Facade::getSettings()
            ->set(
                new DriverSettings(
                    driverOption: DriverOption::ENABLED,
                ),
            )
        ;

        /** @var IDriverConfig $driverConfig */
        $driverConfig = self::getRequiredConfig(IDriverConfig::class);

        self::assertSame(DriverMode::ENABLED, $driverConfig->getDriverMode());
    }

    #[Test]
    public function canSetDriverOptionDisabled(): void
    {
        Facade::getSettings()
            ->set(
                new DriverSettings(
                    driverOption: DriverOption::DISABLED,
                ),
            )
        ;

        /** @var IDriverConfig $driverConfig */
        $driverConfig = self::getRequiredConfig(IDriverConfig::class);

        self::assertSame(DriverMode::DISABLED, $driverConfig->getDriverMode());
    }
}
