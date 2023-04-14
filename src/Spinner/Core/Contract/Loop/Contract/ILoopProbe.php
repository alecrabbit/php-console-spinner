<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Core\Contract\Loop\Contract;

use AlecRabbit\Spinner\Contract\IProbe;

interface ILoopProbe extends IProbe
{
    public function createLoop(): ILoop;
}
