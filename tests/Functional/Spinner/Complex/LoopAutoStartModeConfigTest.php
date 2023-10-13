<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Complex;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use PHPUnit\Framework\Attributes\Test;

final class LoopAutoStartModeConfigTest extends ConfigurationTestCase
{
    #[Test]
    public function canSetLoopAutoStartOptionEnabled(): void
    {
        Facade::getSettings()
            ->set(
                new LoopSettings(
                    autoStartOption: AutoStartOption::ENABLED,
                ),
            )
        ;

        /** @var ILoopConfig $loopConfig */
        $loopConfig = self::getRequiredConfig(ILoopConfig::class);

        self::assertSame(AutoStartMode::ENABLED, $loopConfig->getAutoStartMode());
    }

    #[Test]
    public function canSetLoopAutoStartOptionDisabled(): void
    {
        Facade::getSettings()
            ->set(
                new LoopSettings(
                    autoStartOption: AutoStartOption::DISABLED,
                ),
            )
        ;

        /** @var ILoopConfig $loopConfig */
        $loopConfig = self::getRequiredConfig(ILoopConfig::class);

        self::assertSame(AutoStartMode::DISABLED, $loopConfig->getAutoStartMode());
    }
}
