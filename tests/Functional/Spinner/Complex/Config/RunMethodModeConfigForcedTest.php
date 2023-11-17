<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Complex\Config;

use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\GeneralSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;

final class RunMethodModeConfigForcedTest extends ConfigurationTestCase
{
    protected static function performContainerModifications(): void
    {
        self::modifyContainer(
            self::getFacadeContainer(),
            [
                // Detected settings considered as AUTO
                IDetectedSettingsFactory::class => static function () {
                    return     new class() implements IDetectedSettingsFactory {
                            public function create(): ISettings
                            {
                                return new Settings(
                                    new ArrayObject([
                                        new GeneralSettings(
                                            runMethodOption: RunMethodOption::ASYNC,
                                        )
                                    ])
                                );
                            }
                        };
                },
            ]
        );
    }

    #[Test]
    public function canSetLoopRunMethodOptionAuto(): void
    {
        Facade::getSettings()
            ->set(
                new GeneralSettings(
                    runMethodOption: RunMethodOption::AUTO,
                ),
            )
        ;

        /** @var IGeneralConfig $generalConfig */
        $generalConfig = self::getRequiredConfig(IGeneralConfig::class);

        self::assertSame(RunMethodMode::ASYNC, $generalConfig->getRunMethodMode());
    }

    #[Test]
    public function canSetLoopRunMethodOptionEnabled(): void
    {
        Facade::getSettings()
            ->set(
                new GeneralSettings(
                    runMethodOption: RunMethodOption::ASYNC,
                ),
            )
        ;

        /** @var IGeneralConfig $generalConfig */
        $generalConfig = self::getRequiredConfig(IGeneralConfig::class);

        self::assertSame(RunMethodMode::ASYNC, $generalConfig->getRunMethodMode());
    }

    #[Test]
    public function canSetLoopRunMethodOptionDisabled(): void
    {
        Facade::getSettings()
            ->set(
                new GeneralSettings(
                    runMethodOption: RunMethodOption::SYNCHRONOUS,
                ),
            )
        ;

        /** @var IGeneralConfig $generalConfig */
        $generalConfig = self::getRequiredConfig(IGeneralConfig::class);

        self::assertEquals(RunMethodMode::SYNCHRONOUS, $generalConfig->getRunMethodMode());
    }
}
