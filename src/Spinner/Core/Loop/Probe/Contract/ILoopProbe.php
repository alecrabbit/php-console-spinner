<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Core\Loop\Probe\Contract;

use AlecRabbit\Spinner\Contract\IProbe;
use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;

interface ILoopProbe extends IProbe
{
    public function createLoop(): ILoopAdapter;
}
