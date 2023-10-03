<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Probe\ILoopProbe;
use AlecRabbit\Spinner\Contract\Probe\IStaticProbeFactory;

interface ILoopProbeFactory extends IStaticProbeFactory
{
    public function createProbe(): ILoopProbe;
}
