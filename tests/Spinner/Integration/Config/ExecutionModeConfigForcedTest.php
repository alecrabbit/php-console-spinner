<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Integration\Config;

use AlecRabbit\Spinner\Container\Reference;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;
use AlecRabbit\Spinner\Contract\Option\ExecutionOption;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\GeneralSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use AlecRabbit\Tests\TestCase\Stub\DetectedSettingsFactoryFactoryStub;
use PHPUnit\Framework\Attributes\Test;

final class ExecutionModeConfigForcedTest extends ConfigurationTestCase
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
                ]
            )
        );
    }

    #[Test]
    public function canSetLoopExecutionOptionAuto(): void
    {
        Facade::getSettings()
            ->set(
                new GeneralSettings(
                    executionOption: ExecutionOption::AUTO,
                ),
            )
        ;

        /** @var IGeneralConfig $generalConfig */
        $generalConfig = self::getRequiredConfig(IGeneralConfig::class);

        self::assertSame(ExecutionMode::ASYNC, $generalConfig->getExecutionMode());
    }

    #[Test]
    public function canSetLoopExecutionOptionEnabled(): void
    {
        Facade::getSettings()
            ->set(
                new GeneralSettings(
                    executionOption: ExecutionOption::ASYNC,
                ),
            )
        ;

        /** @var IGeneralConfig $generalConfig */
        $generalConfig = self::getRequiredConfig(IGeneralConfig::class);

        self::assertSame(ExecutionMode::ASYNC, $generalConfig->getExecutionMode());
    }

    #[Test]
    public function canSetLoopExecutionOptionDisabled(): void
    {
        Facade::getSettings()
            ->set(
                new GeneralSettings(
                    executionOption: ExecutionOption::SYNCHRONOUS,
                ),
            )
        ;

        /** @var IGeneralConfig $generalConfig */
        $generalConfig = self::getRequiredConfig(IGeneralConfig::class);

        self::assertEquals(ExecutionMode::SYNCHRONOUS, $generalConfig->getExecutionMode());
    }
}
