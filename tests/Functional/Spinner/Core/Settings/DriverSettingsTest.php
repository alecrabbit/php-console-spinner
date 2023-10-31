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

    public function getTesteeInstance(
        ?LinkerOption $linkerOption = null,
    ): IDriverSettings {
        return
            new DriverSettings(
                linkerOption: $linkerOption ?? LinkerOption::AUTO,
            );
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertEquals(IDriverSettings::class, $settings->getIdentifier());
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
}
