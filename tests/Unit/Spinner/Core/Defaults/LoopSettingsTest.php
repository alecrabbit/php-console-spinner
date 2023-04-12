<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionAttachHandlers;
use AlecRabbit\Spinner\Contract\Option\OptionAutoStart;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\LoopSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class LoopSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopSettings = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSettings::class, $loopSettings);
        self::assertFalse($loopSettings->isLoopAvailable());
        self::assertFalse($loopSettings->isAutoStartEnabled());
        self::assertFalse($loopSettings->isAttachHandlersEnabled());
        self::assertFalse($loopSettings->isSignalProcessingAvailable());
    }

    public function getTesteeInstance(
        ?bool $loopAvailable = null,
        ?OptionAutoStart $autoStartOption = null,
        ?OptionAttachHandlers $signalHandlersOption = null,
        ?bool $pcntlExtensionAvailable = null,
    ): ILoopSettings {
        return
            new LoopSettings(
                loopAvailable: $loopAvailable ?? false,
                optionAutoStart: $autoStartOption ?? OptionAutoStart::DISABLED,
                signalProcessingAvailable: $pcntlExtensionAvailable ?? false,
                optionAttachHandlers: $signalHandlersOption ?? OptionAttachHandlers::DISABLED,
            );
    }

    #[Test]
    public function canBeCreatedWithArguments(): void
    {
        $loopSettings =
            $this->getTesteeInstance(
                true,
                OptionAutoStart::ENABLED,
                OptionAttachHandlers::ENABLED,
                true,
            );

        self::assertInstanceOf(LoopSettings::class, $loopSettings);
        self::assertTrue($loopSettings->isLoopAvailable());
        self::assertTrue($loopSettings->isAutoStartEnabled());
        self::assertTrue($loopSettings->isAttachHandlersEnabled());
        self::assertTrue($loopSettings->isSignalProcessingAvailable());
    }

    #[Test]
    public function valuesCanBeOverriddenWithSetters(): void
    {
        $loopSettings =
            $this->getTesteeInstance(
                loopAvailable: true,
                pcntlExtensionAvailable: true,
            );

        $loopSettings->setOptionAutoStart(OptionAutoStart::ENABLED);
        $loopSettings->setAttachHandlersOption(OptionAttachHandlers::ENABLED);

        self::assertInstanceOf(LoopSettings::class, $loopSettings);
        self::assertTrue($loopSettings->isLoopAvailable());
        self::assertTrue($loopSettings->isAutoStartEnabled());
        self::assertTrue($loopSettings->isAttachHandlersEnabled());
        self::assertTrue($loopSettings->isSignalProcessingAvailable());
    }
}
