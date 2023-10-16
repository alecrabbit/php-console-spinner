<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class LoopSettingsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSettings::class, $settings);
    }

    public function getTesteeInstance(
        ?AutoStartOption $autoStartOption = null,
        ?SignalHandlingOption $signalHandlersOption = null,
    ): ILoopSettings {
        return
            new LoopSettings(
                autoStartOption: $autoStartOption ?? AutoStartOption::AUTO,
                signalHandlersOption: $signalHandlersOption ?? SignalHandlingOption::AUTO,
            );
    }

    #[Test]
    public function canGetInterface(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertEquals(ILoopSettings::class, $settings->getIdentifier());
    }

    #[Test]
    public function canGetAutoStartOption(): void
    {
        $autoStartOption = AutoStartOption::ENABLED;

        $settings = $this->getTesteeInstance(
            autoStartOption: $autoStartOption,
        );

        self::assertEquals($autoStartOption, $settings->getAutoStartOption());
    }

    #[Test]
    public function canSetAutoStartOption(): void
    {
        $autoStartOptionInitial = AutoStartOption::ENABLED;

        $settings = $this->getTesteeInstance(
            autoStartOption: $autoStartOptionInitial,
        );

        $autoStartOption = AutoStartOption::DISABLED;

        self::assertNotEquals($autoStartOption, $settings->getAutoStartOption());

        $settings->setAutoStartOption($autoStartOption);

        self::assertEquals($autoStartOption, $settings->getAutoStartOption());
    }

    #[Test]
    public function canGetSignalHandlingOption(): void
    {
        $signalHandlersOption = SignalHandlingOption::ENABLED;

        $settings = $this->getTesteeInstance(
            signalHandlersOption: $signalHandlersOption,
        );

        self::assertEquals($signalHandlersOption, $settings->getSignalHandlingOption());
    }

    #[Test]
    public function canSetSignalHandlingOption(): void
    {
        $signalHandlersOptionInitial = SignalHandlingOption::ENABLED;

        $settings = $this->getTesteeInstance(
            signalHandlersOption: $signalHandlersOptionInitial,
        );

        $signalHandlersOption = SignalHandlingOption::DISABLED;

        self::assertNotEquals($signalHandlersOption, $settings->getSignalHandlingOption());

        $settings->setSignalHandlingOption($signalHandlersOption);

        self::assertEquals($signalHandlersOption, $settings->getSignalHandlingOption());
    }
}
