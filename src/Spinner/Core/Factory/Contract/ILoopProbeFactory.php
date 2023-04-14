<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\IProbeFactory;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;

interface ILoopProbeFactory extends IProbeFactory
{
    public function getProbe(): ILoopProbe;
}
