<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Integration\Config;

use AlecRabbit\Spinner\Container\Reference;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Contract\Mode\SignalHandlingMode;
use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use AlecRabbit\Tests\TestCase\Stub\DetectedSettingsFactoryFactoryStub;
use PHPUnit\Framework\Attributes\Test;

final class SignalHandlingModeConfigTest extends ConfigurationTestCase
{
    protected static function setTestContainer(): void
    {
        self::setContainer(
            self::modifyContainer(
                [
                    // Detected settings considered as AUTO
                    new ServiceDefinition(
                        IDetectedSettingsFactory::class,
                        new Reference(DetectedSettingsFactoryFactoryStub::class),
                    ),
                    new ServiceDefinition(
                        DetectedSettingsFactoryFactoryStub::class,
                        DetectedSettingsFactoryFactoryStub::class,
                    ),
                ],
            )
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

        if ($this->isPcntlExtensionAvailable()) {
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
