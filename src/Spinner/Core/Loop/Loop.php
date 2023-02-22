<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Core\Loop;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Factory\LoopFactory;

final class Loop
{
    private static ?ILoop $loopInstance = null;

    public static function attach(ISpinner $spinner): void
    {
        self::get()->attach($spinner);
    }

    public static function get(): ILoop
    {
        if (self::$loopInstance instanceof ILoop) {
            return self::$loopInstance;
        }

        self::$loopInstance = LoopFactory::create();

        return self::$loopInstance;
    }

    public static function setSignalHandlers(ISpinner $spinner, ?iterable $handlers = null): void
    {
        $handlers ??= self::get()->createHandlers($spinner);
        self::get()->setSignalHandlers($handlers);
    }

    public static function autoStart(): void
    {
        self::get()->autoStart();
    }
}