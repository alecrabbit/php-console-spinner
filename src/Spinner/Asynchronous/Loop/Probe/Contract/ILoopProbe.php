<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Asynchronous\Loop\Probe\Contract;

use AlecRabbit\Spinner\Core\Contract\IProbe;
use AlecRabbit\Spinner\Extras\Contract\ILoop;

interface ILoopProbe extends IProbe
{
    public static function createLoop(): ILoop;
}
