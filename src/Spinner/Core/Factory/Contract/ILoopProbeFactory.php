<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\IStaticProbeFactory;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;

interface ILoopProbeFactory extends IStaticProbeFactory
{
    public function createProbe(): ILoopProbe;
}
