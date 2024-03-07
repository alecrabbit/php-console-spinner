<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Integration\Config;

use AlecRabbit\Spinner\Container\Reference;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;
use AlecRabbit\Spinner\Contract\Option\ExecutionModeOption;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\GeneralSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use AlecRabbit\Tests\TestCase\Stub\DetectedSettingsFactoryFactoryModeAsyncStub;
use PHPUnit\Framework\Attributes\Test;

final class ForcedSynchronousModeTest extends ConfigurationTestCase
{
    protected static function setTestContainer(): void
    {
        parent::setTestContainer();

        self::modifyContainer(

            [
                // Detected settings considered as AUTO
                new ServiceDefinition(
                    IDetectedSettingsFactory::class,
                    new Reference(DetectedSettingsFactoryFactoryModeAsyncStub::class),
                ),
                new ServiceDefinition(
                    DetectedSettingsFactoryFactoryModeAsyncStub::class,
                    DetectedSettingsFactoryFactoryModeAsyncStub::class,
                ),
            ]
        );
    }

    #[Test]
    public function synchronousModeCanBeForcedOne(): void
    {
        Facade::getSettings()
            ->set(
                new GeneralSettings(
                    executionModeOption: ExecutionModeOption::SYNCHRONOUS,
                ),
            )
        ;

        $spinnerSettings = new SpinnerSettings(
            autoAttach: false,
        );
        $spinner = Facade::createSpinner($spinnerSettings);

        self::assertInstanceOf(Spinner::class, $spinner);

        $driver = Facade::getDriver();

        self::assertFalse($driver->has($spinner));

        /** @var IGeneralConfig $generalConfig */
        $generalConfig = self::getRequiredConfig(IGeneralConfig::class);

        self::assertEquals(ExecutionMode::SYNCHRONOUS, $generalConfig->getExecutionMode());

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Loop is not set.');

        $loop = self::getService(ILoopProvider::class)->getLoop();

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function synchronousModeCanBeForcedTwo(): void
    {
        Facade::getSettings()
            ->set(
                new GeneralSettings(
                    executionModeOption: ExecutionModeOption::SYNCHRONOUS,
                ),
            )
        ;

        $spinner = Facade::createSpinner();

        self::assertInstanceOf(Spinner::class, $spinner);

        $driver = Facade::getDriver();

        self::assertTrue($driver->has($spinner));

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Loop is not set.');

        $loop = self::getService(ILoopProvider::class)->getLoop();

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function synchronousModeCanBeForcedThree(): void
    {
        Facade::getSettings()
            ->set(
                new GeneralSettings(
                    executionModeOption: ExecutionModeOption::SYNCHRONOUS,
                ),
            )
        ;

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Loop is not set.');

        $loop = self::getService(ILoopProvider::class)->getLoop();

        self::fail('Exception was not thrown.');
    }
}
