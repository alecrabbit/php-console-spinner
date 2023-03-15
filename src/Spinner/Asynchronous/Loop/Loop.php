<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Asynchronous\Loop;

use AlecRabbit\Spinner\Asynchronous\Factory\LoopFactory;
use AlecRabbit\Spinner\Contract\ILoop;
use AlecRabbit\Spinner\Contract\ILoopGetter;
use AlecRabbit\Spinner\Contract\ILoopHelper;
use AlecRabbit\Spinner\Contract\ILoopSignalHandlers;
use AlecRabbit\Spinner\Contract\ILoopSpinnerAttach;
use AlecRabbit\Spinner\Contract\ISpinner;

final class Loop implements ILoopHelper
{
    private static ?ILoop $loopInstance = null;

    public static function attach(ISpinner $spinner): void
    {
        self::get()->attach($spinner);
    }

    public static function get(): ILoop|ILoopGetter|ILoopSignalHandlers|ILoopSpinnerAttach
    {
        if (self::$loopInstance instanceof ILoop) {
            return self::$loopInstance;
        }

        self::$loopInstance = LoopFactory::create();

        return self::$loopInstance;
    }

    public static function setSignalHandlers(ISpinner $spinner, ?iterable $handlers = null): void
    {
        $handlers ??= self::get()->createSignalHandlers($spinner);
        self::get()->setSignalHandlers($handlers);
    }

    public static function autoStart(): void
    {
        self::get()->autoStart();
    }
}
