<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Complex\Config;

use AlecRabbit\Spinner\Contract\Mode\SignalHandlingMode;
use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use PHPUnit\Framework\Attributes\Test;

final class SignalHandlingModeConfigTest extends ConfigurationTestCase
{
    protected static function setTestContainer(): void
    {
        self::modifyContainer(
            self::getStoredContainer(),
            [
                // Detected settings considered as AUTO
                IDetectedSettingsFactory::class => static function () {
                    return new class() implements IDetectedSettingsFactory {
                        public function create(): ISettings
                        {
                            return new Settings();
                        }
                    };
                },
            ],
        );
    }

    #[Test]
    public function canSetLoopSignalHandlingOptionEnabled(): void
    {
        Facade::getSettings()
            ->set(
                new LoopSettings(
                    signalHandlingOption: SignalHandlingOption::ENABLED,
                ),
            )
        ;

        /** @var ILoopConfig $loopConfig */
        $loopConfig = self::getRequiredConfig(ILoopConfig::class);

        if (function_exists('pcntl_signal')) {
            self::assertSame(SignalHandlingMode::ENABLED, $loopConfig->getSignalHandlingMode());
        } else {
            self::assertSame(SignalHandlingMode::DISABLED, $loopConfig->getSignalHandlingMode());
        }
    }

    #[Test]
    public function canSetLoopSignalHandlingOptionDisabled(): void
    {
        Facade::getSettings()
            ->set(
                new LoopSettings(
                    signalHandlingOption: SignalHandlingOption::DISABLED,
                ),
            )
        ;

        /** @var ILoopConfig $loopConfig */
        $loopConfig = self::getRequiredConfig(ILoopConfig::class);

        self::assertSame(SignalHandlingMode::DISABLED, $loopConfig->getSignalHandlingMode());
    }
}
