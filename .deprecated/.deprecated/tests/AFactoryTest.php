<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\A\AStaticSpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\StaticDefaultsFactory;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;

final class AFactoryTest extends TestCase
{
    /** @test */
    public function canCreateDefaultSpinner(): void
    {
        $spinner = AStaticSpinnerFactory::createSpinner();

        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf(ISpinner::class, $spinner);
    }

    protected function setUp(): void
    {
        StaticDefaultsFactory::get()
            ->overrideRunMode(OptionRunMode::SYNCHRONOUS)
            ->getLoopSettings()
            ->overrideAutoStartOption(OptionAutoStart::DISABLED)
            ->overrideSignalHandlersOption(OptionSignalHandlers::DISABLED)
            ->toParent()
            ->getTerminalSettings()
            ->overrideColorMode(OptionStyleMode::NONE)
            ->overrideCursorOption(OptionCursor::ENABLED)
            ->toParent();
    }
}