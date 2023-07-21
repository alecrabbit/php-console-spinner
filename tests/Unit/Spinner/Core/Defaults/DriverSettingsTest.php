<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacyDriverSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $driverSettings = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyDriverSettings::class, $driverSettings);
    }

    public function getTesteeInstance(
        InitializationOption $optionInitialization = InitializationOption::ENABLED,
        LinkerOption $optionLinker = LinkerOption::ENABLED,
        string $finalMessage = 'Final message',
        string $interruptMessage = 'Interrupt message',
    ): ILegacyDriverSettings {
        return new LegacyDriverSettings(
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

        $optionLinker = LinkerOption::DISABLED;

        $driverSettings = $this->getTesteeInstance(
            optionInitialization: InitializationOption::DISABLED,
            optionLinker: $optionLinker,
            finalMessage: $finalMessage,
            interruptMessage: $interruptMessage,
        );
        self::assertInstanceOf(LegacyDriverSettings::class, $driverSettings);
        self::assertFalse($driverSettings->isInitializationEnabled());
        self::assertFalse($driverSettings->isLinkerEnabled());
        self::assertSame($finalMessage, $driverSettings->getFinalMessage());
        self::assertSame($interruptMessage, $driverSettings->getInterruptMessage());
        self::assertSame($optionLinker, $driverSettings->getOptionLinker());

        $finalMessage = 'Final message';
        $interruptMessage = 'Interrupt message';
        $optionLinker = LinkerOption::ENABLED;

        $driverSettings->setOptionDriverInitialization(InitializationOption::ENABLED);
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
