<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Contract;

use AlecRabbit\Spinner\Contract\IProbeFactory;
use AlecRabbit\Spinner\Core\Loop\Probe\Contract\ILoopProbe;

interface ILoopProbeFactory extends IProbeFactory
{
    public function getProbe(): ILoopProbe;
}
