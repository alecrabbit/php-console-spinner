<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Contract\AutoStart;
use AlecRabbit\Spinner\Contract\StyleMode;
use AlecRabbit\Spinner\Contract\Cursor;
use AlecRabbit\Spinner\Contract\RunMode;
use AlecRabbit\Spinner\Contract\SignalHandlers;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\A\ASpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;

final class AFactoryTest extends TestCase
{
    /** @test */
    public function canCreateDefaultSpinner(): void
    {
        $spinner = ASpinnerFactory::createSpinner();

        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf(ISpinner::class, $spinner);
    }

//    /** @test */
//    public function canCreateAndAddWidgets(): void
//    {
//        $config =
//            (new ConfigBuilder(DefaultsFactory::create()))
//                ->withWidgets([NullWidget::create()])
//                ->build();
//        $spinner = ASpinnerFactory::createSpinner($config);
//
//        self::assertEquals(1, self::getValue('childrenCount', self::getValue('widget', $spinner)));
//    }

    protected function setUp(): void
    {
        DefaultsFactory::get()
            ->overrideRunMode(RunMode::SYNCHRONOUS)
            ->getLoopSettings()
            ->overrideAutoStartOption(AutoStart::DISABLED)
            ->overrideSignalHandlersOption(SignalHandlers::DISABLED)
            ->toParent()
            ->getTerminalSettings()
            ->overrideColorMode(StyleMode::NONE)
            ->overrideCursor(Cursor::ENABLED)
            ->toParent();
    }
}
