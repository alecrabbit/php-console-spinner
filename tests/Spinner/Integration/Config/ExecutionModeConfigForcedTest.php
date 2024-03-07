<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Integration\Config;

use AlecRabbit\Spinner\Container\Reference;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;
use AlecRabbit\Spinner\Contract\Option\ExecutionModeOption;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\GeneralSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use AlecRabbit\Tests\TestCase\Stub\DetectedSettingsFactoryFactoryStub;
use ArrayObject;
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
    public function canSetLoopExecutionModeOptionAuto(): void
    {
        Facade::getSettings()
            ->set(
                new GeneralSettings(
                    runMethodOption: ExecutionModeOption::AUTO,
                ),
            )
        ;

        /** @var IGeneralConfig $generalConfig */
        $generalConfig = self::getRequiredConfig(IGeneralConfig::class);

        self::assertSame(ExecutionMode::ASYNC, $generalConfig->getExecutionMode());
    }

    #[Test]
    public function canSetLoopExecutionModeOptionEnabled(): void
    {
        Facade::getSettings()
            ->set(
                new GeneralSettings(
                    runMethodOption: ExecutionModeOption::ASYNC,
                ),
            )
        ;

        /** @var IGeneralConfig $generalConfig */
        $generalConfig = self::getRequiredConfig(IGeneralConfig::class);

        self::assertSame(ExecutionMode::ASYNC, $generalConfig->getExecutionMode());
    }

    #[Test]
    public function canSetLoopExecutionModeOptionDisabled(): void
    {
        Facade::getSettings()
            ->set(
                new GeneralSettings(
                    runMethodOption: ExecutionModeOption::SYNCHRONOUS,
                ),
            )
        ;

        /** @var IGeneralConfig $generalConfig */
        $generalConfig = self::getRequiredConfig(IGeneralConfig::class);

        self::assertEquals(ExecutionMode::SYNCHRONOUS, $generalConfig->getExecutionMode());
    }
}
