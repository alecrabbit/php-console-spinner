<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionDriverInitialization;
use AlecRabbit\Spinner\Contract\Option\OptionLinker;
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
        OptionDriverInitialization $optionInitialization = OptionDriverInitialization::ENABLED,
        OptionLinker $optionLinker = OptionLinker::ENABLED,
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

        $optionLinker = OptionLinker::DISABLED;

        $driverSettings = $this->getTesteeInstance(
            optionInitialization: OptionDriverInitialization::DISABLED,
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
        $optionLinker = OptionLinker::ENABLED;

        $driverSettings->setOptionDriverInitialization(OptionDriverInitialization::ENABLED);
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
