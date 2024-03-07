<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Integration\Config;

use AlecRabbit\Spinner\Container\Reference;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use AlecRabbit\Tests\TestCase\Stub\DetectedSettingsFactoryFactoryStub;
use PHPUnit\Framework\Attributes\Test;

final class StylingMethodModeConfigTest extends ConfigurationTestCase
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
    public function canSetStylingMethodOptionNone(): void
    {
        Facade::getSettings()
            ->set(
                new OutputSettings(
                    stylingMethodOption: StylingMethodOption::NONE,
                ),
            )
        ;

        /** @var IOutputConfig $outputConfig */
        $outputConfig = self::getRequiredConfig(IOutputConfig::class);

        self::assertSame(StylingMethodMode::NONE, $outputConfig->getStylingMethodMode());
    }

    #[Test]
    public function canSetStylingMethodOptionAnsi4(): void
    {
        Facade::getSettings()
            ->set(
                new OutputSettings(
                    stylingMethodOption: StylingMethodOption::ANSI4,
                ),
            )
        ;

        /** @var IOutputConfig $outputConfig */
        $outputConfig = self::getRequiredConfig(IOutputConfig::class);

        self::assertSame(StylingMethodMode::ANSI4, $outputConfig->getStylingMethodMode());
    }

    #[Test]
    public function canSetStylingMethodOptionAnsi8(): void
    {
        Facade::getSettings()
            ->set(
                new OutputSettings(
                    stylingMethodOption: StylingMethodOption::ANSI8,
                ),
            )
        ;

        /** @var IOutputConfig $outputConfig */
        $outputConfig = self::getRequiredConfig(IOutputConfig::class);

        self::assertSame(StylingMethodMode::ANSI8, $outputConfig->getStylingMethodMode());
    }

    #[Test]
    public function canSetStylingMethodOptionAnsi24(): void
    {
        Facade::getSettings()
            ->set(
                new OutputSettings(
                    stylingMethodOption: StylingMethodOption::ANSI24,
                ),
            )
        ;

        /** @var IOutputConfig $outputConfig */
        $outputConfig = self::getRequiredConfig(IOutputConfig::class);

        self::assertSame(StylingMethodMode::ANSI24, $outputConfig->getStylingMethodMode());
    }
}
