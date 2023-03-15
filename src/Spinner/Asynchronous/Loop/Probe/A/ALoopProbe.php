<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Loop\Probe\A;

use AlecRabbit\Spinner\I\ILoop;
use AlecRabbit\Spinner\I\ILoopProbe;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;

abstract class ALoopProbe implements ILoopProbe
{
    use NoInstanceTrait;

    abstract public static function isSupported(): bool;

    abstract public static function createLoop(): ILoop;
}
