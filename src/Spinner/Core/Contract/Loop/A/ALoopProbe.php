<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Loop\A;

use AlecRabbit\Spinner\Contract\Probe\ILoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;

abstract class ALoopProbe implements ILoopProbe
{
    abstract public static function isSupported(): bool;

    abstract public function createLoop(): ILoop;
}
