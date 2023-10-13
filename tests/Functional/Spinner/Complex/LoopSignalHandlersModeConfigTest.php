<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Complex;

use AlecRabbit\Spinner\Contract\Mode\SignalHandlersMode;
use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use PHPUnit\Framework\Attributes\Test;

final class LoopSignalHandlersModeConfigTest extends ConfigurationTestCase
{
    #[Test]
    public function canSetLoopSignalHandlersOptionEnabled(): void
    {
        Facade::getSettings()
            ->set(
                new LoopSettings(
                    signalHandlersOption: SignalHandlersOption::ENABLED,
                ),
            )
        ;

        /** @var ILoopConfig $loopConfig */
        $loopConfig = self::getRequiredConfig(ILoopConfig::class);

        self::assertSame(SignalHandlersMode::ENABLED, $loopConfig->getSignalHandlersMode());
    }

    #[Test]
    public function canSetLoopSignalHandlersOptionDisabled(): void
    {
        Facade::getSettings()
            ->set(
                new LoopSettings(
                    signalHandlersOption: SignalHandlersOption::DISABLED,
                ),
            )
        ;

        /** @var ILoopConfig $loopConfig */
        $loopConfig = self::getRequiredConfig(ILoopConfig::class);

        self::assertSame(SignalHandlersMode::DISABLED, $loopConfig->getSignalHandlersMode());
    }
}
