<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Probe\A;

use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Loop\Probe\Contract\ILoopProbe;

abstract class ALoopProbe implements ILoopProbe
{
    abstract public static function isSupported(): bool;

    abstract public function createLoop(): ILoopAdapter;
}
