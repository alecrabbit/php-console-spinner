<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\DriverInitializationOption;
use AlecRabbit\Spinner\Contract\Option\DriverLinkerOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $driverSettings = $this->getTesteeInstance();

        self::assertInstanceOf(DriverSettings::class, $driverSettings);
    }

    public function getTesteeInstance(
        DriverInitializationOption $optionInitialization = DriverInitializationOption::ENABLED,
        DriverLinkerOption $optionLinker = DriverLinkerOption::ENABLED,
        string $finalMessage = 'Final message',
        string $interruptMessage = 'Interrupt message',
    ): IDriverSettings {
        return new DriverSettings(
            optionDriverInitialization: $optionInitialization,
            optionLinker: $optionLinker,
            finalMessage: $finalMessage,
            interruptMessage: $interruptMessage,
        );
    }

    #[Test]
    public function valuesCanBeOverriddenWithSetters(): void
    {
        $finalMessage = 'Final';
        $interruptMessage = 'Interrupt';

        $optionLinker = DriverLinkerOption::DISABLED;

        $driverSettings = $this->getTesteeInstance(
            optionInitialization: DriverInitializationOption::DISABLED,
            optionLinker: $optionLinker,
            finalMessage: $finalMessage,
            interruptMessage: $interruptMessage,
        );
        self::assertInstanceOf(DriverSettings::class, $driverSettings);
        self::assertFalse($driverSettings->isInitializationEnabled());
        self::assertFalse($driverSettings->isLinkerEnabled());
        self::assertSame($finalMessage, $driverSettings->getFinalMessage());
        self::assertSame($interruptMessage, $driverSettings->getInterruptMessage());
        self::assertSame($optionLinker, $driverSettings->getOptionLinker());

        $finalMessage = 'Final message';
        $interruptMessage = 'Interrupt message';
        $optionLinker = DriverLinkerOption::ENABLED;

        $driverSettings->setOptionDriverInitialization(DriverInitializationOption::ENABLED);
        $driverSettings->setOptionLinker($optionLinker);
        $driverSettings->setFinalMessage($finalMessage);
        $driverSettings->setInterruptMessage($interruptMessage);

        self::assertTrue($driverSettings->isInitializationEnabled());
        self::assertTrue($driverSettings->isLinkerEnabled());
        self::assertSame($finalMessage, $driverSettings->getFinalMessage());
        self::assertSame($interruptMessage, $driverSettings->getInterruptMessage());
        self::assertSame($optionLinker, $driverSettings->getOptionLinker());
    }
}
