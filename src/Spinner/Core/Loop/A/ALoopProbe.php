<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\A;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;

abstract class ALoopProbe implements ILoopProbe
{
    use NoInstanceTrait;

    abstract public static function isSupported(): bool;

    abstract public static function createLoop(): ILoop;
}
