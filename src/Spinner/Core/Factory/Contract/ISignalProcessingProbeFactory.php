<?php

declare(strict_types=1);

// 14.04.23

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\IProbeFactory;
use AlecRabbit\Spinner\Core\Contract\ISignalProcessingProbe;

interface ISignalProcessingProbeFactory extends IProbeFactory
{
    public function getProbe(): ISignalProcessingProbe;
}
