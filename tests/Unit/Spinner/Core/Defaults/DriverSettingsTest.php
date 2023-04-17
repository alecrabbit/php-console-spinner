<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionAttacher;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\DriverSettings;
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
        OptionInitialization $optionInitialization = OptionInitialization::ENABLED,
        OptionAttacher $optionAttacher = OptionAttacher::ENABLED,
        string $finalMessage = 'Final message',
        string $interruptMessage = 'Interrupt message',
    ): IDriverSettings {
        return
            new DriverSettings(
                optionInitialization: $optionInitialization,
                optionAttacher: $optionAttacher,
                finalMessage: $finalMessage,
                interruptMessage: $interruptMessage,
            );
    }

    #[Test]
    public function valuesCanBeOverriddenWithSetters(): void
    {
        $finalMessage = 'Final';
        $interruptMessage = 'Interrupt';

        $driverSettings = $this->getTesteeInstance(
            optionInitialization: OptionInitialization::DISABLED,
            optionAttacher: OptionAttacher::DISABLED,
            finalMessage: $finalMessage,
            interruptMessage: $interruptMessage,
        );
        self::assertInstanceOf(DriverSettings::class, $driverSettings);
        self::assertFalse($driverSettings->isInitializationEnabled());
        self::assertFalse($driverSettings->isAttacherEnabled());
        self::assertSame($finalMessage, $driverSettings->getFinalMessage());
        self::assertSame($interruptMessage, $driverSettings->getInterruptMessage());

        $finalMessage = 'Final message';
        $interruptMessage = 'Interrupt message';

        $driverSettings->setOptionInitialization(OptionInitialization::ENABLED);
        $driverSettings->setOptionAttacher(OptionAttacher::ENABLED);
        $driverSettings->setFinalMessage($finalMessage);
        $driverSettings->setInterruptMessage($interruptMessage);

        self::assertTrue($driverSettings->isInitializationEnabled());
        self::assertTrue($driverSettings->isAttacherEnabled());
        self::assertSame($finalMessage, $driverSettings->getFinalMessage());
        self::assertSame($interruptMessage, $driverSettings->getInterruptMessage());
    }
}
