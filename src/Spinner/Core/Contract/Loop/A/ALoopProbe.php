<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Loop\A;

use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;

abstract class ALoopProbe implements ILoopProbe
{
    abstract public static function isAvailable(): bool;

    abstract public function createLoop(): ILoop;
}
