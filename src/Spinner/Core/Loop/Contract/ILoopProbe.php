<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Core\Loop\Contract;

use AlecRabbit\Spinner\Contract\IProbe;

interface ILoopProbe extends IProbe
{
    public function createLoop(): ILoopAdapter;
}
