<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Complex\Config;

use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\GeneralSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;

final class ForcedSynchronousModeTest extends ConfigurationTestCase
{
    protected static function setTestContainer(): void
    {
        parent::setTestContainer();

        self::modifyContainer(
            self::getCurrentContainer(),
            [
                // Detected settings considered as AUTO
                IDetectedSettingsFactory::class => static function () {
                    return new class() implements IDetectedSettingsFactory {
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
    public function synchronousModeCanBeForcedOne(): void
    {
        Facade::getSettings()
            ->set(
                new GeneralSettings(
                    runMethodOption: RunMethodOption::SYNCHRONOUS,
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

        self::assertEquals(RunMethodMode::SYNCHRONOUS, $generalConfig->getRunMethodMode());

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
                    runMethodOption: RunMethodOption::SYNCHRONOUS,
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
                    runMethodOption: RunMethodOption::SYNCHRONOUS,
                ),
            )
        ;

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Loop is not set.');

        $loop = self::getService(ILoopProvider::class)->getLoop();

        self::fail('Exception was not thrown.');
    }
}
