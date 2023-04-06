<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\DriverSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $interruptMessage = 'interruptMessage';
        $finalMessage = 'finalMessage';

        $widgetSettings = $this->getTesteeInstance(
            $interruptMessage,
            $finalMessage,
        );

        self::assertInstanceOf(DriverSettings::class, $widgetSettings);
        self::assertSame($interruptMessage, $widgetSettings->getInterruptMessage());
        self::assertSame($finalMessage, $widgetSettings->getFinalMessage());
    }

    public function getTesteeInstance(
        string $interruptMessage,
        string $finalMessage,
    ): IDriverSettings {
        return
            new DriverSettings(
                interruptMessage: $interruptMessage,
                finalMessage: $finalMessage,
            );
    }


    #[Test]
    public function valuesCanBeOverriddenWithSetters(): void
    {
        $widgetSettings = $this->getTesteeInstance(
            'interrupt',
            'final',
        );

        $interruptMessage = 'interruptMessage';
        $finalMessage = 'finalMessage';


        $widgetSettings->setInterruptMessage($interruptMessage);
        $widgetSettings->setFinalMessage($finalMessage);

        self::assertInstanceOf(DriverSettings::class, $widgetSettings);
        self::assertSame($interruptMessage, $widgetSettings->getInterruptMessage());
        self::assertSame($finalMessage, $widgetSettings->getFinalMessage());
    }
}
