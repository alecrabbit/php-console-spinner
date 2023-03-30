<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Probe\A;

use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;

abstract class ALoopProbe implements ILoopProbe
{
    use NoInstanceTrait;

    abstract public static function isSupported(): bool;

    abstract public static function createLoop(): ILoopAdapter;
}
