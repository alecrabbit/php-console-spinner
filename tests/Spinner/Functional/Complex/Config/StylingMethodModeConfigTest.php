<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Complex\Config;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use PHPUnit\Framework\Attributes\Test;

final class StylingMethodModeConfigTest extends ConfigurationTestCase
{
    protected static function performContainerModifications(): void
    {
        self::setContainer(
            self::modifyContainer(
                self::getFacadeContainer(),
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
