<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Complex\Config;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Settings\LinkerSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use PHPUnit\Framework\Attributes\Test;

final class LinkerModeConfigTest extends ConfigurationTestCase
{


    #[Test]
    public function canSetLinkerOptionEnabled(): void
    {
        Facade::getSettings()
            ->set(
                new LinkerSettings(
                    linkerOption: LinkerOption::ENABLED,
                ),
            )
        ;

        /** @var ILinkerConfig $linkerConfig */
        $linkerConfig = self::getRequiredConfig(ILinkerConfig::class);

        self::assertSame(LinkerMode::ENABLED, $linkerConfig->getLinkerMode());
    }

    #[Test]
    public function canSetLinkerOptionDisabled(): void
    {
        Facade::getSettings()
            ->set(
                new LinkerSettings(
                    linkerOption: LinkerOption::DISABLED,
                ),
            )
        ;

        /** @var ILinkerConfig $linkerConfig */
        $linkerConfig = self::getRequiredConfig(ILinkerConfig::class);

        self::assertSame(LinkerMode::DISABLED, $linkerConfig->getLinkerMode());
    }
}
