<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Complex\Config;

use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use PHPUnit\Framework\Attributes\Test;

final class RunMethodModeConfigTest extends ConfigurationTestCase
{
    protected static function performContainerModifications(): void
    {
        self::modifyContainer(
            self::getFacadeContainer(),
            [
                // Detected settings considered as AUTO
                IDetectedSettingsFactory::class => static function () {
                    return
                        new class implements IDetectedSettingsFactory {
                            public function create(): ISettings
                            {
                                return new Settings();
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
                new AuxSettings(
                    runMethodOption: RunMethodOption::AUTO,
                ),
            )
        ;

        /** @var IAuxConfig $auxConfig */
        $auxConfig = self::getRequiredConfig(IAuxConfig::class);

        self::assertSame(RunMethodMode::ASYNC, $auxConfig->getRunMethodMode());
    }

    #[Test]
    public function canSetLoopRunMethodOptionEnabled(): void
    {
        Facade::getSettings()
            ->set(
                new AuxSettings(
                    runMethodOption: RunMethodOption::ASYNC,
                ),
            )
        ;

        /** @var IAuxConfig $auxConfig */
        $auxConfig = self::getRequiredConfig(IAuxConfig::class);

        self::assertSame(RunMethodMode::ASYNC, $auxConfig->getRunMethodMode());
    }

    #[Test]
    public function canSetLoopRunMethodOptionDisabled(): void
    {
        Facade::getSettings()
            ->set(
                new AuxSettings(
                    runMethodOption: RunMethodOption::SYNCHRONOUS,
                ),
            )
        ;

        /** @var IAuxConfig $auxConfig */
        $auxConfig = self::getRequiredConfig(IAuxConfig::class);

        self::assertSame(RunMethodMode::SYNCHRONOUS, $auxConfig->getRunMethodMode());
    }
}
