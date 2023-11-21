<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Core\Settings\Contract\ILinkerSettings;
use AlecRabbit\Spinner\Core\Settings\LinkerSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class LinkerSettingsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(LinkerSettings::class, $settings);
    }

    public function getTesteeInstance(
        ?LinkerOption $linkerOption = null,
    ): ILinkerSettings {
        return
            new LinkerSettings(
                linkerOption: $linkerOption ?? LinkerOption::AUTO,
            );
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertEquals(ILinkerSettings::class, $settings->getIdentifier());
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
