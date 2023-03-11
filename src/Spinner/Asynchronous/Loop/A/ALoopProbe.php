<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Loop\A;

use AlecRabbit\Spinner\Asynchronous\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Asynchronous\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;

abstract class ALoopProbe implements ILoopProbe
{
    use NoInstanceTrait;

    abstract public static function isSupported(): bool;

    abstract public static function createLoop(): ILoop;
}
