<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\A;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;

abstract class ALoopProbe implements ILoopProbe
{
    abstract public static function isAvailable(): bool;

    abstract public function createLoop(): ILoop;
}
