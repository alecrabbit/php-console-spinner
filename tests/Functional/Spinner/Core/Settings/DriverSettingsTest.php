<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class DriverSettingsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(DriverSettings::class, $settings);
    }

    #[Test]
    public function canGetInterface(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertEquals(IDriverSettings::class, $settings->getIdentifier());
    }

    public function getTesteeInstance(
        ?LinkerOption $linkerOption = null,
        ?InitializationOption $initializationOption = null,
    ): IDriverSettings {
        return
            new DriverSettings(
                linkerOption: $linkerOption ?? LinkerOption::AUTO,
                initializationOption: $initializationOption ?? InitializationOption::AUTO,
            );
    }

    #[Test]
    public function canGetLinkerOption(): void
    {
        $linkerOption = LinkerOption::DISABLED;

        $settings = $this->getTesteeInstance(
            linkerOption: $linkerOption,
        );

        self::assertEquals($linkerOption, $settings->getLinkerOption());
    }

    #[Test]
    public function canSetLinkerOption(): void
    {
        $linkerOptionInitial = LinkerOption::ENABLED;

        $settings = $this->getTesteeInstance(
            linkerOption: $linkerOptionInitial,
        );

        $linkerOption = LinkerOption::DISABLED;

        self::assertNotEquals($linkerOption, $settings->getLinkerOption());

        $settings->setLinkerOption($linkerOption);

        self::assertEquals($linkerOption, $settings->getLinkerOption());
    }

    #[Test]
    public function canGetInitializationOption(): void
    {
        $initializationOption = InitializationOption::ENABLED;

        $settings = $this->getTesteeInstance(
            initializationOption: $initializationOption,
        );

        self::assertEquals($initializationOption, $settings->getInitializationOption());
    }

    #[Test]
    public function canSetInitializationOption(): void
    {
        $initializationOptionInitial = InitializationOption::ENABLED;

        $settings = $this->getTesteeInstance(
            initializationOption: $initializationOptionInitial,
        );

        $initializationOption = InitializationOption::DISABLED;

        self::assertNotEquals($initializationOption, $settings->getInitializationOption());

        $settings->setInitializationOption($initializationOption);

        self::assertEquals($initializationOption, $settings->getInitializationOption());
    }
}
