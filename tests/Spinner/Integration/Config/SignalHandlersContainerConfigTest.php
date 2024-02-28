<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Integration\Config;

use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Settings\SignalHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\SignalHandlerSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use Closure;
use PHPUnit\Framework\Attributes\Test;

final class SignalHandlersContainerConfigTest extends ConfigurationTestCase
{
    protected static function setTestContainer(): void
    {
        self::setContainer(
            self::modifyContainer(
                self::getStoredContainer(),
                [
                    // Detected settings considered as AUTO
                    IDetectedSettingsFactory::class => static function () {
                        return new class() implements IDetectedSettingsFactory {
                            public function create(): ISettings
                            {
                                return new Settings(); // empty object considered as AUTO
                            }
                        };
                    },
                ]
            )
        );
    }

    #[Test]
    public function canSetStylingMethodOptionNone(): void
    {
        $signal = 2;
        $handlerCreator =
            new class() implements IHandlerCreator {
                public function createHandler(IDriver $driver, ILoop $loop): Closure
                {
                    return static function (): void {
                        // dummy
                    };
                }
            };

        Facade::getSettings()
            ->set(
                new SignalHandlerSettings(
                    new SignalHandlerCreator(
                        signal: 2,
                        handlerCreator: $handlerCreator,
                    )
                ),
            )
        ;

        /** @var ILoopConfig $loopConfig */
        $loopConfig = self::getRequiredConfig(ILoopConfig::class);

        self::assertSame(
            [
                $signal => $handlerCreator
            ],
            iterator_to_array($loopConfig->getSignalHandlersContainer()->getHandlerCreators())
        );
    }
}
