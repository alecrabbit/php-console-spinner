<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Complex;

use AlecRabbit\Spinner\Contract\Mode\SignalHandlersMode;
use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlersOptionCreator;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use PHPUnit\Framework\Attributes\Test;

final class SignalHandlersModeConfigTest extends ConfigurationTestCase
{
    protected static function performContainerModifications(): void
    {
        self::modifyContainer(
            self::extractContainer(),
            [
                // Detected settings considered as AUTO
                IDetectedSettingsFactory::class => static function () {
                    return
                        new class implements IDetectedSettingsFactory {
                            public function create(): ISettings
                            {
                                return new Settings();
                            }
                        };
                },
                ISignalHandlersOptionCreator::class => static function () {
                    return
                        new class implements ISignalHandlersOptionCreator {
                            public static function create(): SignalHandlersOption
                            {
                                return SignalHandlersOption::AUTO;
                            }
                        };
                },
            ]
        );
    }

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

        self::assertSame(SignalHandlersMode::ENABLED, dump($loopConfig->getSignalHandlersMode()));
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
