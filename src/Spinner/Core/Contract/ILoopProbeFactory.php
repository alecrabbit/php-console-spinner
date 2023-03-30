<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IProbeFactory;

interface ILoopProbeFactory extends IProbeFactory
{
    public function getProbe(): ILoopProbe;
}
