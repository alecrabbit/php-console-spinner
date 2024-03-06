<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Integration\Config;

use AlecRabbit\Spinner\Container\Reference;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\Messages;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use AlecRabbit\Tests\TestCase\Stub\DetectedSettingsFactoryFactoryStub;
use PHPUnit\Framework\Attributes\Test;

final class DriverMessagesConfigTest extends ConfigurationTestCase
{
    private const DEFAULT_MESSAGE = '';

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
                ]
            )
        );
    }

    #[Test]
    public function canSetDefaults(): void
    {
        $messages = new Messages();

        Facade::getSettings()
            ->set(
                new DriverSettings(
                    messages: $messages,
                ),
            )
        ;

        /** @var IDriverConfig $driverConfig */
        $driverConfig = self::getRequiredConfig(IDriverConfig::class);

        $driverMessages = $driverConfig->getDriverMessages();

        self::assertSame(self::DEFAULT_MESSAGE, $driverMessages->getFinalMessage());
        self::assertSame(self::DEFAULT_MESSAGE, $driverMessages->getInterruptionMessage());
    }

    #[Test]
    public function canSetFinalMessage(): void
    {
        $finalMessage = 'Final message';

        $messages = new Messages(
            finalMessage: $finalMessage,
        );

        Facade::getSettings()
            ->set(
                new DriverSettings(
                    messages: $messages,
                ),
            )
        ;

        /** @var IDriverConfig $driverConfig */
        $driverConfig = self::getRequiredConfig(IDriverConfig::class);

        $driverMessages = $driverConfig->getDriverMessages();

        self::assertSame($finalMessage, $driverMessages->getFinalMessage());
        self::assertSame(self::DEFAULT_MESSAGE, $driverMessages->getInterruptionMessage());
    }

    #[Test]
    public function canSetInterruptionMessage(): void
    {
        $interruptMessage = 'Interrupt message';

        $messages = new Messages(
            interruptionMessage: $interruptMessage,
        );

        Facade::getSettings()
            ->set(
                new DriverSettings(
                    messages: $messages,
                ),
            )
        ;

        /** @var IDriverConfig $driverConfig */
        $driverConfig = self::getRequiredConfig(IDriverConfig::class);

        $driverMessages = $driverConfig->getDriverMessages();

        self::assertSame(self::DEFAULT_MESSAGE, $driverMessages->getFinalMessage());
        self::assertSame($interruptMessage, $driverMessages->getInterruptionMessage());
    }

    #[Test]
    public function canSetAllMessages(): void
    {
        $finalMessage = 'Final message';
        $interruptMessage = 'Interrupt message';

        $messages = new Messages(
            finalMessage: $finalMessage,
            interruptionMessage: $interruptMessage,
        );

        Facade::getSettings()
            ->set(
                new DriverSettings(
                    messages: $messages,
                ),
            )
        ;

        /** @var IDriverConfig $driverConfig */
        $driverConfig = self::getRequiredConfig(IDriverConfig::class);

        $driverMessages = $driverConfig->getDriverMessages();

        self::assertSame($finalMessage, $driverMessages->getFinalMessage());
        self::assertSame($interruptMessage, $driverMessages->getInterruptionMessage());
    }

}
