<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\LoopSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;

final class LoopSettingsTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopSettings = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSettings::class, $loopSettings);
        self::assertSame(OptionRunMode::SYNCHRONOUS, $loopSettings->getRunModeOption());
        self::assertSame(OptionAutoStart::DISABLED, $loopSettings->getAutoStartOption());
        self::assertSame(OptionSignalHandlers::DISABLED, $loopSettings->getSignalHandlersOption());
    }

    public function getTesteeInstance(
        ?OptionRunMode $runModeOption = null,
        ?OptionAutoStart $autoStartOption = null,
        ?OptionSignalHandlers $signalHandlersOption = null,
    ): ILoopSettings {
        return
            new LoopSettings(
                runModeOption: $runModeOption ?? OptionRunMode::SYNCHRONOUS,
                autoStartOption: $autoStartOption ?? OptionAutoStart::DISABLED,
                signalHandlersOption: $signalHandlersOption ?? OptionSignalHandlers::DISABLED,
            );
    }

    #[Test]
    public function canBeCreatedWithArguments(): void
    {
        $runModeOption = OptionRunMode::ASYNC;
        $autoStartOption = OptionAutoStart::ENABLED;
        $signalHandlersOption = OptionSignalHandlers::ENABLED;

        $loopSettings =
            $this->getTesteeInstance(
                $runModeOption,
                $autoStartOption,
                $signalHandlersOption,
            );

        self::assertInstanceOf(LoopSettings::class, $loopSettings);
        self::assertSame($runModeOption, $loopSettings->getRunModeOption());
        self::assertSame($autoStartOption, $loopSettings->getAutoStartOption());
        self::assertSame($signalHandlersOption, $loopSettings->getSignalHandlersOption());
    }

    #[Test]
    public function valuesCanBeOverriddenWithSetters(): void
    {
        $runModeOption = OptionRunMode::ASYNC;
        $autoStartOption = OptionAutoStart::ENABLED;
        $signalHandlersOption = OptionSignalHandlers::ENABLED;

        $loopSettings =
            $this->getTesteeInstance(
                $runModeOption,
                $autoStartOption,
                $signalHandlersOption,
            );
        $loopSettings->setRunModeOption($runModeOption);
        $loopSettings->setAutoStartOption($autoStartOption);
        $loopSettings->setSignalHandlersOption($signalHandlersOption);

        self::assertInstanceOf(LoopSettings::class, $loopSettings);
        self::assertSame($runModeOption, $loopSettings->getRunModeOption());
        self::assertSame($autoStartOption, $loopSettings->getAutoStartOption());
        self::assertSame($signalHandlersOption, $loopSettings->getSignalHandlersOption());
    }
}
