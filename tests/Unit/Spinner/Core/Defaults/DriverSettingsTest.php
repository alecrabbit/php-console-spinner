<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionAttacher;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\DriverSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $driverSettings = $this->getTesteeInstance();

        self::assertInstanceOf(DriverSettings::class, $driverSettings);
    }

    public function getTesteeInstance(
        OptionInitialization $optionInitialization = OptionInitialization::ENABLED,
        OptionAttacher $optionAttacher = OptionAttacher::ENABLED,
    ): IDriverSettings {
        return
            new DriverSettings(
                optionInitialization: $optionInitialization,
                optionAttacher: $optionAttacher,
            );
    }


    #[Test]
    public function valuesCanBeOverriddenWithSetters(): void
    {
        $driverSettings = $this->getTesteeInstance(
            optionInitialization: OptionInitialization::DISABLED,
            optionAttacher: OptionAttacher::DISABLED,
        );
        self::assertInstanceOf(DriverSettings::class, $driverSettings);
        self::assertFalse($driverSettings->isInitializationEnabled());
        self::assertFalse($driverSettings->isAttacherEnabled());

        $driverSettings->setOptionInitialization(OptionInitialization::ENABLED);
        $driverSettings->setOptionAttacher(OptionAttacher::ENABLED);

        self::assertTrue($driverSettings->isInitializationEnabled());
        self::assertTrue($driverSettings->isAttacherEnabled());
    }
}
