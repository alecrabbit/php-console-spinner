<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Asynchronous\Loop;

use AlecRabbit\Spinner\Asynchronous\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopHelper;
use AlecRabbit\Spinner\Core\Contract\ISpinner;

final class LoopHelper implements ILoopHelper
{
    private static ?ILoopAdapter $loopInstance = null;

    public static function attach(ISpinner $spinner): void
    {
        self::getLoopAdapter()->attach($spinner);
    }

    public static function getLoopAdapter(): ILoopAdapter
    {
        if (self::$loopInstance instanceof ILoopAdapter) {
            return self::$loopInstance;
        }

        self::$loopInstance = LoopFactory::create();

        return self::$loopInstance;
    }

    public static function setSignalHandlers(ISpinner $spinner, ?iterable $handlers = null): void
    {
        $handlers ??= self::getLoopAdapter()->createSignalHandlers($spinner);
        self::getLoopAdapter()->setSignalHandlers($handlers);
    }

    public static function autoStart(): void
    {
        self::getLoopAdapter()->autoStart();
    }
}
