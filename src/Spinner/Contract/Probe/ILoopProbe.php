<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Probe;

use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;

interface ILoopProbe extends IStaticProbe
{
    public function createLoop(): ILoop;
}
