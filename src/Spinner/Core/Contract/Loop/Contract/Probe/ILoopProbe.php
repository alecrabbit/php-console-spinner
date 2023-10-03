<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Loop\Contract\Probe;

use AlecRabbit\Spinner\Contract\Probe\IStaticProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;

interface ILoopProbe extends IStaticProbe
{
    public function createLoop(): ILoop;
}
