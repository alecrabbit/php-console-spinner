<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Integration\Config;

use AlecRabbit\Spinner\Container\Reference;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Contract\Mode\StylingMode;
use AlecRabbit\Spinner\Contract\Option\StylingOption;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use AlecRabbit\Tests\TestCase\Stub\DetectedSettingsFactoryFactoryStub;
use PHPUnit\Framework\Attributes\Test;

final class StylingModeConfigTest extends ConfigurationTestCase
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
    public function canSetStylingOptionNone(): void
    {
        Facade::getSettings()
            ->set(
                new OutputSettings(
                    stylingOption: StylingOption::NONE,
                ),
            )
        ;

        /** @var IOutputConfig $outputConfig */
        $outputConfig = self::getRequiredConfig(IOutputConfig::class);

        self::assertSame(StylingMode::NONE, $outputConfig->getStylingMode());
    }

    #[Test]
    public function canSetStylingOptionAnsi4(): void
    {
        Facade::getSettings()
            ->set(
                new OutputSettings(
                    stylingOption: StylingOption::ANSI4,
                ),
            )
        ;

        /** @var IOutputConfig $outputConfig */
        $outputConfig = self::getRequiredConfig(IOutputConfig::class);

        self::assertSame(StylingMode::ANSI4, $outputConfig->getStylingMode());
    }

    #[Test]
    public function canSetStylingOptionAnsi8(): void
    {
        Facade::getSettings()
            ->set(
                new OutputSettings(
                    stylingOption: StylingOption::ANSI8,
                ),
            )
        ;

        /** @var IOutputConfig $outputConfig */
        $outputConfig = self::getRequiredConfig(IOutputConfig::class);

        self::assertSame(StylingMode::ANSI8, $outputConfig->getStylingMode());
    }

    #[Test]
    public function canSetStylingOptionAnsi24(): void
    {
        Facade::getSettings()
            ->set(
                new OutputSettings(
                    stylingOption: StylingOption::ANSI24,
                ),
            )
        ;

        /** @var IOutputConfig $outputConfig */
        $outputConfig = self::getRequiredConfig(IOutputConfig::class);

        self::assertSame(StylingMode::ANSI24, $outputConfig->getStylingMode());
    }
}
